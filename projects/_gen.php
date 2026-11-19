<?php
/**
 * Laravel app generator — emits app-specific files into projects/<slug>/
 * which must already be a copy of the gym skeleton.
 * Usage: php _gen.php <slug>     (spec at _specs/<slug>.php)
 */
$slug = $argv[1] ?? die("usage: php _gen.php <slug>\n");
$spec = require __DIR__ . "/_specs/$slug.php";
$root = __DIR__ . "/$slug";

$colTypes = [
    'string'           => fn($n) => "\$table->string('$n');",
    'stringNullable'   => fn($n) => "\$table->string('$n')->nullable();",
    'text'             => fn($n) => "\$table->text('$n');",
    'textNullable'     => fn($n) => "\$table->text('$n')->nullable();",
    'integer'          => fn($n) => "\$table->integer('$n')->default(0);",
    'decimal'          => fn($n) => "\$table->decimal('$n', 10, 2)->default(0);",
    'date'             => fn($n) => "\$table->date('$n');",
    'dateNullable'     => fn($n) => "\$table->date('$n')->nullable();",
    'datetime'         => fn($n) => "\$table->dateTime('$n');",
    'datetimeNullable' => fn($n) => "\$table->dateTime('$n')->nullable();",
    'bool'             => fn($n) => "\$table->boolean('$n')->default(0);",
    'statusActive'     => fn($n) => "\$table->string('$n')->default('Active');",
];

$studly = fn($s) => str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $s)));
$snake  = fn($s) => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $s));
$plural = fn($s) => \Illuminate\Support\Str::plural($snake($s));
require $root . '/vendor/autoload.php';

$out = fn($path, $content) => file_put_contents("$root/$path", $content) !== false
    ? print("  + $path\n") : print("  ! FAILED $path\n");

// Map each model to its real table name (needed for ->constrained('x'))
$tableOf = [];
foreach (array_merge(array_values($spec['modules'] ?? []), $spec['extra_models'] ?? []) as $mm) {
    $tableOf[$mm['model']] = $mm['table'] ?? $plural($mm['model']);
}

// Models + migrations with no UI module (join tables etc.)
foreach (($spec['extra_models'] ?? []) as $em) {
    $model = $em['model'];
    $table = $em['table'] ?? $plural($model);
    $rels  = '';
    foreach (($em['rels'] ?? []) as $rname => $rdef) {
        $p = explode(':', $rdef);
        $rels .= "\n    public function $rname()\n    {\n        return \$this->{$p[0]}(\\App\\Models\\{$p[1]}::class" . (isset($p[2]) ? ", '{$p[2]}'" : '') . ");\n    }\n";
    }
    $out("app/Models/$model.php", "<?php\n\nnamespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass $model extends Model\n{\n" .
        (isset($em['table']) ? "    protected \$table = '{$em['table']}';\n" : '') .
        "    protected \$fillable = ['" . implode("', '", $em['fillable']) . "'];\n$rels}\n");
    $cols = '';
    foreach ($em['columns'] as [$name, $type]) {
        if (str_starts_with($type, 'fk')) {
            $p = explode(':', $type);
            $req = $p[0] === 'fkreq';
            $ref = $tableOf[$p[1]] ?? $plural($p[1]);
            $col = $p[2] ?? $snake($p[1]) . '_id';
            $cols .= "            \$table->foreignId('$col')" . ($req ? "->constrained('$ref')->cascadeOnDelete()" : "->nullable()->constrained('$ref')->nullOnDelete()") . ";\n";
        } else {
            $cols .= '            ' . $colTypes[$type]($name) . "\n";
        }
    }
    $ts = '2026_11_19_060' . str_pad((string)($em['_mid'] ?? 99), 3, '0', STR_PAD_LEFT);
    $out("database/migrations/{$ts}_create_{$table}_table.php", "<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nreturn new class extends Migration\n{\n    public function up(): void\n    {\n        Schema::create('$table', function (Blueprint \$table) {\n            \$table->id();\n$cols            \$table->timestamps();\n        });\n    }\n\n    public function down(): void\n    {\n        Schema::dropIfExists('$table');\n    }\n};\n");
}

foreach ($spec['modules'] as $uri => $m) {
    $model  = $m['model'];
    $table  = $m['table'] ?? $plural($model);
    $ctrl   = "{$model}Controller";
    $vdir   = "resources/views/$uri";
    @mkdir("$root/$vdir", 0777, true);

    // ---- Model
    $rels = '';
    foreach (($m['rels'] ?? []) as $rname => $rdef) {
        $parts  = explode(':', $rdef); // type:Model[:fk]
        $rtype  = $parts[0];
        $rmodel = $parts[1];
        $rfk    = isset($parts[2]) ? ", '{$parts[2]}'" : '';
        $rels .= "\n    public function $rname()\n    {\n        return \$this->{$rtype}(\\App\\Models\\{$rmodel}::class{$rfk});\n    }\n";
    }
    $tblProp = isset($m['table']) ? "\n    protected \$table = '{$m['table']}';\n" : '';
    $out("app/Models/$model.php", "<?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class $model extends Model
{{$tblProp}
    protected \$fillable = ['" . implode("', '", $m['fillable']) . "'];
$rels}
");

    // ---- Migration
    $cols = '';
    foreach ($m['columns'] as [$name, $type]) {
        if (str_starts_with($type, 'default:')) {
            $cols .= '            ' . "\$table->string('$name')->default('" . substr($type, 8) . "');\n";
        } elseif (str_starts_with($type, 'fk')) {
            $parts = explode(':', $type);       // fk|fkreq:Model[:colname]
            $req   = $parts[0] === 'fkreq';
            $ref   = $tableOf[$parts[1]] ?? $plural($parts[1]);
            $col   = $parts[2] ?? $snake($parts[1]) . '_id';
            $cols .= "            \$table->foreignId('$col')" .
                ($req ? "->constrained('$ref')->cascadeOnDelete()" : "->nullable()->constrained('$ref')->nullOnDelete()") . ";\n";
        } else {
            $cols .= '            ' . $colTypes[$type]($name) . "\n";
        }
    }
    $ts = '2026_11_19_060' . str_pad((string)($m['_mid'] ?? 0), 3, '0', STR_PAD_LEFT);
    $out("database/migrations/{$ts}_create_{$table}_table.php", "<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('$table', function (Blueprint \$table) {
            \$table->id();
$cols            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('$table');
    }
};
");

    // ---- Controller
    $opts   = '';
    $optv   = '';
    foreach ($m['fields'] as $f) {
        if (($f[2] ?? '') === 'select' && is_string($f[3] ?? null) && str_starts_with($f[3], '@')) {
            $rp     = explode(':', substr($f[3], 1));   // @Model[:colname]
            $refm   = $rp[0];
            $rcol   = $rp[1] ?? 'name';
            $var    = lcfirst($plural($refm));
            $opts  .= "            '$var' => \\App\\Models\\$refm::orderBy('$rcol')->pluck('$rcol', 'id'),\n";
            $optv  .= ", \$$var";
        }
    }
    $val = '';
    foreach ($m['validation'] as $f => $r) $val .= "            '$f' => '$r',\n";
    $query = !empty($m['with'])
        ? "{$model}::with(['" . implode("','", $m['with']) . "'])->latest()->get()"
        : "{$model}::latest()->get()";
    $extraQueries = $m['extra_queries'] ?? '';
    $out("app/Http/Controllers/$ctrl.php", "<?php

namespace App\\Http\\Controllers;

use App\\Models\\$model;
use Illuminate\\Http\\Request;

class $ctrl extends Controller
{
    public function index()
    {
        \$rows = $query;
$extraQueries        return view('$uri.index', array_merge(compact('rows'" . ($optv ? '' : '') . "), [
$opts        ]));
    }

    public function store(Request \$request)
    {
        \$data = \$request->validate([
$val        ]);
" . ($m['store_extra'] ?? '') . "
        {$model}::create(\$data);
        return back()->with('ok', '{$m['title']} added.');
    }

    public function update(Request \$request, $model \$row)
    {
        \$row->update(\$request->validate([
$val        ]));
        return redirect()->route('$uri.index')->with('ok', '{$m['title']} updated.');
    }

    public function destroy($model \$row)
    {
        \$row->delete();
        return back()->with('ok', '{$m['title']} deleted.');
    }
}
");

    // ---- View (form + table on one page)
    $form = '';
    foreach ($m['fields'] as $f) {
        [$fn, $fl, $ft] = [$f[0], $f[1], $f[2] ?? 'text'];
        $req = !empty($f[4]) ? ' required' : '';
        $old = "old('$fn', \$edit->{$fn} ?? '')";
        if ($ft === 'select') {
            if (is_string($f[3] ?? null) && str_starts_with($f[3], '@')) {
                $var  = lcfirst($plural(explode(':', substr($f[3], 1))[0]));
                $form .= "                <div class=\"form-row\"><label>$fl</label>\n" .
                    "                    <select name=\"$fn\"><option value=\"\">— Select —</option>\n" .
                    "                        @foreach(\${$var} as \$id => \$n)<option value=\"{{ \$id }}\" @selected($old == \$id)>{{ \$n }}</option>@endforeach\n" .
                    "                    </select></div>\n";
            } else {
                $optsArr = var_export($f[3], true);
                if (array_is_list($f[3])) {
                    $form .= "                <div class=\"form-row\"><label>$fl</label>\n" .
                        "                    <select name=\"$fn\"$req>@foreach($optsArr as \$s)<option @selected($old === \$s)>{{ \$s }}</option>@endforeach</select></div>\n";
                } else {
                    $form .= "                <div class=\"form-row\"><label>$fl</label>\n" .
                        "                    <select name=\"$fn\"$req>@foreach($optsArr as \$k => \$s)<option value=\"{{ \$k }}\" @selected((string)$old === (string)\$k)>{{ \$s }}</option>@endforeach</select></div>\n";
                }
            }
        } elseif ($ft === 'textarea') {
            $form .= "                <div class=\"form-row\"><label>$fl</label><textarea name=\"$fn\"$req>{{ $old }}</textarea></div>\n";
        } else {
            $form .= "                <div class=\"form-row\"><label>$fl</label><input type=\"$ft\" name=\"$fn\" value=\"{{ $old }}\"$req></div>\n";
        }
    }
    $tcols = '';
    foreach ($m['cols'] as $h => $cell) $tcols .= "                    <td>$cell</td>\n";
    $thead = '';
    foreach (array_keys($m['cols']) as $h) $thead .= "<th>$h</th>";
    $out("$vdir/index.blade.php", "@extends('layouts.app')
@section('title', '{$m['title']}s')
@section('content')
@php \$edit = request('edit') ? \$rows->firstWhere('id', request('edit')) : null; @endphp
<div class=\"card\">
    <div class=\"card-head\"><h2>{{ \$edit ? 'Edit {$m['title']}' : 'Add {$m['title']}' }}</h2></div>
    <div class=\"card-body\">
        <form method=\"POST\" action=\"{{ \$edit ? route('$uri.update', \$edit) : route('$uri.store') }}\">
            @csrf @if(\$edit) @method('PUT') @endif
            <div class=\"form-grid\">
$form            </div>
            <button class=\"btn btn-acc\" type=\"submit\">{{ \$edit ? 'Update' : 'Add' }} {$m['title']}</button>
            @if(\$edit)<a class=\"btn\" href=\"{{ route('$uri.index') }}\">Cancel</a>@endif
        </form>
    </div>
</div>

<div class=\"card\">
    <div class=\"card-head\"><h2>All {$m['title']}s ({{ \$rows->count() }})</h2></div>
    <div class=\"card-body\" style=\"padding:0\">
        <table class=\"tbl\">
            <tr>$thead<th></th></tr>
            @forelse(\$rows as \$r)
                <tr>
$tcols                    <td>
                        <a class=\"btn btn-sm\" href=\"{{ route('$uri.index', ['edit' => \$r->id]) }}\">Edit</a>
                        <form method=\"POST\" action=\"{{ route('$uri.destroy', \$r) }}\" class=\"inline\" onsubmit=\"return confirm('Delete?')\">
                            @csrf @method('DELETE')<button class=\"btn btn-sm btn-danger\" type=\"submit\">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan=\"" . (count($m['cols']) + 1) . "\" class=\"empty\">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
");
}

// ---- Layout + Login
$nav = '';
foreach ($spec['nav'] as [$label, $route, $icon]) {
    $rpat = str_replace('.index', '.*', $route);
    $nav .= "            <a href=\"{{ route('$route') }}\" class=\"{{ request()->routeIs('$rpat') ? 'active' : '' }}\"><span class=\"ni\">$icon</span>$label</a>\n";
}
@mkdir("$root/resources/views/layouts", 0777, true);
@mkdir("$root/resources/views/auth", 0777, true);
$out('resources/views/layouts/app.blade.php', "<!DOCTYPE html>
<html lang=\"en\">
<head>
<meta charset=\"UTF-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<title>@yield('title') — {$spec['name']}</title>
<link rel=\"stylesheet\" href=\"{{ asset('css/admin.css') }}\">
<style>:root{--acc:{$spec['accent']}}</style>
</head>
<body class=\"admin\">
<div class=\"shell\">
    <aside class=\"sidebar\">
        <a class=\"side-brand\" href=\"{{ route('dashboard') }}\">
            <span class=\"side-icon\" style=\"background:{$spec['accent']}\">{$spec['icon']}</span>
            <span>{$spec['name']}</span>
        </a>
        <nav class=\"side-nav\">
$nav        </nav>
        <div class=\"side-foot\"><a href=\"{{ url('/../') }}\" class=\"side-back\">← Back to Portfolio</a></div>
    </aside>
    <div class=\"main\">
        <header class=\"topbar\">
            <h1>@yield('title')</h1>
            <div class=\"topbar-right\">
                <span class=\"topbar-user\">{{ auth()->user()->name }}</span>
                <form method=\"POST\" action=\"{{ route('logout') }}\" class=\"inline\">@csrf<button class=\"btn btn-sm\" type=\"submit\">Logout</button></form>
            </div>
        </header>
        <main class=\"content\">
            @if(session('ok'))<div class=\"alert alert-ok\">{{ session('ok') }}</div>@endif
            @if(\$errors->any())<div class=\"alert alert-err\">{{ \$errors->first() }}</div>@endif
            @yield('content')
        </main>
    </div>
</div>
<script src=\"{{ asset('js/admin.js') }}\"></script>
</body>
</html>
");
$out('resources/views/auth/login.blade.php', "<!DOCTYPE html>
<html lang=\"en\">
<head>
<meta charset=\"UTF-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<title>Login — {$spec['name']}</title>
<link rel=\"stylesheet\" href=\"{{ asset('css/admin.css') }}\">
</head>
<body class=\"login-page\">
<div class=\"login-card\">
    <div class=\"login-ico\" style=\"background:{$spec['accent']}\">{$spec['icon']}</div>
    <h1>{$spec['name']}</h1>
    <p class=\"login-sub\">Sign in to the admin panel</p>
    @if(\$errors->any())<div class=\"alert alert-err\">{{ \$errors->first() }}</div>@endif
    <form method=\"POST\" action=\"{{ route('login.attempt') }}\">
        @csrf
        <div class=\"form-row\"><label>Email</label>
            <input type=\"email\" name=\"email\" value=\"{{ old('email', 'admin@demo.local') }}\" required autofocus>
        </div>
        <div class=\"form-row\"><label>Password</label>
            <input type=\"password\" name=\"password\" required>
        </div>
        <button class=\"btn btn-acc btn-block\" type=\"submit\">Login</button>
    </form>
    <p class=\"note\" style=\"margin-top:1rem;text-align:center\">Demo: admin@demo.local / admin123</p>
</div>
</body>
</html>
");

// ---- Dashboard view + controller
$statCards = '';
foreach ($spec['stats'] as [$label, $sub]) {
    $lbl = var_export($label, true);
    $statCards .= "    <div class=\"stat-card\"><div class=\"stat-label\">$label</div><div class=\"stat-value\">{{ \$stats[$lbl] }}</div><div class=\"stat-sub\">$sub</div></div>\n";
}
$dcols = '';
foreach ($spec['dash']['cols'] as $h => $c) $dcols .= "                    <td>$c</td>\n";
$dhead = '';
foreach (array_keys($spec['dash']['cols']) as $h) $dhead .= "<th>$h</th>";
$out('resources/views/dashboard.blade.php', "@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class=\"stats-row\">
$statCards</div>
<div class=\"card\">
    <div class=\"card-head\"><h2>{$spec['dash']['title']}</h2>" .
    (isset($spec['dash']['link']) ? "<a class=\"btn btn-sm\" href=\"{{ route('{$spec['dash']['link'][0]}') }}\">{$spec['dash']['link'][1]}</a>" : '') .
    "</div>
    <div class=\"card-body\" style=\"padding:0\">
        <table class=\"tbl\">
            <tr>$dhead</tr>
            @forelse(\$rows as \$r)
                <tr>
$dcols                </tr>
            @empty
                <tr><td colspan=\"" . count($spec['dash']['cols']) . "\" class=\"empty\">{$spec['dash']['empty']}</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
");
$statExprs = '';
foreach ($spec['stats'] as [$label, $expr]) $statExprs .= '                ' . var_export($label, true) . " => $expr,\n";
$out('app/Http/Controllers/DashboardController.php', "<?php

namespace App\\Http\\Controllers;

" . ($spec['uses'] ?? '') . "
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
$statExprs            ],
            'rows'  => {$spec['dash']['query']},
        ]);
    }
}
");

// ---- Auth controller (identical every app)
@mkdir("$root/app/Http/Controllers/Auth", 0777, true);
$out('app/Http/Controllers/Auth/LoginController.php', file_get_contents(__DIR__ . '/gym/app/Http/Controllers/Auth/LoginController.php'));

// ---- Routes
$routes = '';
foreach ($spec['modules'] as $uri => $m) {
    $routes .= "    Route::resource('$uri', \\App\\Http\\Controllers\\{$m['model']}Controller::class)->only(['index', 'store', 'update', 'destroy']);\n";
}
$routes .= $spec['extra_routes'] ?? '';
$out('routes/web.php', "<?php

use App\\Http\\Controllers\\Auth\\LoginController;
use App\\Http\\Controllers\\DashboardController;
use Illuminate\\Support\\Facades\\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
$routes});
");

// ---- Seeder
$seed = "        \\App\\Models\\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \\Illuminate\\Support\\Facades\\Hash::make('admin123')]);\n";
foreach ($spec['seed'] as $model => $rows) {
    $seed .= "        \\App\\Models\\$model::insert(array_map(fn(\$r) => \$r + ['created_at' => now(), 'updated_at' => now()], " . var_export($rows, true) . "));\n";
}
$out('database/seeders/DatabaseSeeder.php', "<?php

namespace Database\\Seeders;

use Illuminate\\Database\\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
$seed    }
}
");

// ---- .env app name
$env = file_get_contents("$root/.env");
$env = preg_replace('/APP_NAME=.*/', 'APP_NAME="' . $spec['name'] . '"', $env);
file_put_contents("$root/.env", $env);

echo "✓ $slug generated\n";
