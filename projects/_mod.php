<?php
// _mod.php <app-slug> <fragment-spec.php>
// Non-destructively adds modules (model+migration+controller+view+route+nav)
// and seed data to an existing generated Laravel app.
[$slug, $file] = [$argv[1] ?? null, $argv[2] ?? null];
$root = __DIR__ . "/$slug";
if (!$slug || !$file || !is_dir($root)) { fwrite(STDERR, "usage: php _mod.php <app> <spec.php>\n"); exit(1); }
$frag = require $file;

$snake  = fn($s) => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $s));
$plural = function ($s) use ($snake) {
    $sn = $snake($s);
    return preg_match('/[^aeiou]y$/', $sn) ? substr($sn, 0, -1) . 'ies' : $sn . 's';
};

$colTypes = [
    'string'        => fn($n) => "\$table->string('$n');",
    'stringNullable'=> fn($n) => "\$table->string('$n')->nullable();",
    'text'          => fn($n) => "\$table->text('$n');",
    'textNullable'  => fn($n) => "\$table->text('$n')->nullable();",
    'integer'       => fn($n) => "\$table->integer('$n')->nullable();",
    'decimal'       => fn($n) => "\$table->decimal('$n', 10, 2)->default(0);",
    'date'          => fn($n) => "\$table->date('$n');",
    'dateNullable'  => fn($n) => "\$table->date('$n')->nullable();",
    'datetime'      => fn($n) => "\$table->dateTime('$n')->nullable();",
    'datetimeNullable' => fn($n) => "\$table->dateTime('$n')->nullable();",
    'time'          => fn($n) => "\$table->time('$n')->nullable();",
    'bool'          => fn($n) => "\$table->boolean('$n')->default(false);",
    'intNullable'   => fn($n) => "\$table->integer('$n')->nullable();",
    'index'         => fn($n) => "\$table->string('$n')->unique();",
    'statusActive'  => fn($n) => "\$table->string('$n')->default('Active');",
];

$out = fn($path, $content) => file_put_contents("$root/$path", $content) !== false
    ? print("  + $path\n") : print("  ! FAILED $path\n");

$tableOf = $frag['base_tables'] ?? [];
foreach (array_merge(array_values($frag['modules'] ?? []), $frag['extra_models'] ?? []) as $mm) {
    $tableOf[$mm['model']] = $mm['table'] ?? $plural($mm['model']);
}

// migration timestamps: continue after the max existing numeric prefix
$maxTs = 20261119000000;
foreach (glob("$root/database/migrations/*.php") as $mig) {
    if (preg_match('/^(\d{4})_(\d{2})_(\d{2})_(\d{6})_/', basename($mig), $mm)) {
        $maxTs = max($maxTs, (int)($mm[1] . $mm[2] . $mm[3] . $mm[4]));
    }
}
$nextTs = $maxTs + 1;

$emitMigration = function ($table, $columns) use (&$nextTs, $colTypes, $snake, $plural, $out, $tableOf) {
    $cols = '';
    foreach ($columns as [$name, $type]) {
        if (str_starts_with($type, 'default:')) {
            $cols .= "            \$table->string('$name')->default('" . substr($type, 8) . "');\n";
        } elseif (str_starts_with($type, 'fk')) {
            $p = explode(':', $type);
            $req = $p[0] === 'fkreq';
            $ref = $tableOf[$p[1]] ?? $plural($p[1]);
            $col = $p[2] ?? $snake($p[1]) . '_id';
            $cols .= "            \$table->foreignId('$col')" . ($req ? "->constrained('$ref')->cascadeOnDelete()" : "->nullable()->constrained('$ref')->nullOnDelete()") . ";\n";
        } else {
            $cols .= '            ' . $colTypes[$type]($name) . "\n";
        }
    }
    $n  = (string)$nextTs++;
    $ts = substr($n, 0, 4) . '_' . substr($n, 4, 2) . '_' . substr($n, 6, 2) . '_' . substr($n, 8);
    $out("database/migrations/{$ts}_create_{$table}_table.php", "<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
};

// ---- extra models (no UI)
foreach (($frag['extra_models'] ?? []) as $em) {
    $model = $em['model']; $table = $em['table'] ?? $plural($model);
    $rels = '';
    foreach (($em['rels'] ?? []) as $rname => $rdef) {
        $p = explode(':', $rdef);
        $rels .= "\n    public function $rname()\n    {\n        return \$this->{$p[0]}(\\App\\Models\\{$p[1]}::class" . (isset($p[2]) ? ", '{$p[2]}'" : '') . ");\n    }\n";
    }
    $out("app/Models/$model.php", "<?php\n\nnamespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass $model extends Model\n{\n" .
        (isset($em['table']) ? "    protected \$table = '{$em['table']}';\n" : '') .
        "    protected \$fillable = ['" . implode("', '", $em['fillable']) . "'];\n$rels}\n");
    $emitMigration($table, $em['columns']);
}

// ---- modules
foreach (($frag['modules'] ?? []) as $uri => $m) {
    $model = $m['model']; $table = $m['table'] ?? $plural($model); $ctrl = "{$model}Controller";
    @mkdir("$root/resources/views/$uri", 0777, true);

    $rels = '';
    foreach (($m['rels'] ?? []) as $rname => $rdef) {
        $p = explode(':', $rdef);
        $rels .= "\n    public function $rname()\n    {\n        return \$this->{$p[0]}(\\App\\Models\\{$p[1]}::class" . (isset($p[2]) ? ", '{$p[2]}'" : '') . ");\n    }\n";
    }
    $out("app/Models/$model.php", "<?php\n\nnamespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass $model extends Model\n{\n" .
        (isset($m['table']) ? "    protected \$table = '{$m['table']}';\n" : '') .
        "    protected \$fillable = ['" . implode("', '", $m['fillable']) . "'];\n$rels}\n");
    $emitMigration($table, $m['columns']);

    $opts = '';
    foreach ($m['fields'] as $f) {
        if (($f[2] ?? '') === 'select' && is_string($f[3] ?? null) && str_starts_with($f[3], '@')) {
            $rp = explode(':', substr($f[3], 1));
            $var = lcfirst($plural($rp[0]));
            $opts .= "            '$var' => \\App\\Models\\{$rp[0]}::orderBy('" . ($rp[1] ?? 'name') . "')->pluck('" . ($rp[1] ?? 'name') . "', 'id'),\n";
        }
    }
    $val = '';
    foreach ($m['validation'] as $f => $r) $val .= "            '$f' => '$r',\n";
    $query = !empty($m['with'])
        ? "{$model}::with(['" . implode("','", $m['with']) . "'])->latest()->get()"
        : "{$model}::latest()->get()";
    $out("app/Http/Controllers/$ctrl.php", "<?php

namespace App\\Http\\Controllers;

use App\\Models\\$model;
use Illuminate\\Http\\Request;

class $ctrl extends Controller
{
    public function index()
    {
        \$rows = $query;
        return view('$uri.index', array_merge(compact('rows'), [
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

    $form = '';
    foreach ($m['fields'] as $f) {
        [$fn, $fl, $ft] = [$f[0], $f[1], $f[2] ?? 'text'];
        $req = !empty($f[4]) ? ' required' : '';
        $old = "old('$fn', \$edit->{$fn} ?? '')";
        if ($ft === 'select') {
            if (is_string($f[3] ?? null) && str_starts_with($f[3], '@')) {
                $var = lcfirst($plural(explode(':', substr($f[3], 1))[0]));
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
    $tcols = ''; foreach ($m['cols'] as $h => $cell) $tcols .= "                    <td>$cell</td>\n";
    $thead = ''; foreach (array_keys($m['cols']) as $h) $thead .= "<th>$h</th>";
    $out("resources/views/$uri/index.blade.php", "@extends('layouts.app')
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

    $routes = file_get_contents("$root/routes/web.php");
    if (!str_contains($routes, "Route::resource('$uri'")) {
        $line = "    Route::resource('$uri', \\App\\Http\\Controllers\\$ctrl::class)->only(['index', 'store', 'update', 'destroy']);\n";
        $routes = preg_replace('/\n\}\);\s*$/', "\n$line});", $routes);
        file_put_contents("$root/routes/web.php", $routes);
        echo "  + route $uri\n";
    }
}

// ---- nav links appended before </nav>
if (!empty($frag['nav'])) {
    $lay = "$root/resources/views/layouts/app.blade.php";
    $c = file_get_contents($lay);
    $links = '';
    foreach ($frag['nav'] as [$label, $route, $icon]) {
        if (str_contains($c, "route('$route')")) continue; // idempotent
        $rpat = str_replace('.index', '.*', $route);
        $links .= "            <a href=\"{{ route('$route') }}\" class=\"{{ request()->routeIs('$rpat') ? 'active' : '' }}\">@include(\"partials.icon\", [\"i\" => \"$icon\"])$label</a>\n";
    }
    $c = str_replace('        </nav>', "$links        </nav>", $c);
    file_put_contents($lay, $c);
    echo "  + nav\n";
}

// ---- seed data → cumulative data_mods.php + ModsSeeder (wired once)
if (!empty($frag['seed'])) {
    $dmPath = "$root/database/seeders/data_mods.php";
    $existing = is_file($dmPath) ? require $dmPath : [];
    $merged = array_merge($existing, $frag['seed']);
    file_put_contents($dmPath, "<?php\nreturn " . var_export($merged, true) . ";\n");
    $msPath = "$root/database/seeders/ModsSeeder.php";
    if (!is_file($msPath)) {
        file_put_contents($msPath, "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\n\nclass ModsSeeder extends Seeder\n{\n    public function run(): void\n    {\n        \$data = require __DIR__ . '/data_mods.php';\n        foreach (\$data as \$model => \$rows) {\n            \$cls = \"App\\\\Models\\\\\$model\";\n            \$cls::insert(array_map(fn(\$r) => \$r + ['created_at' => now(), 'updated_at' => now()], \$rows));\n        }\n    }\n}\n");
        $ds = "$root/database/seeders/DatabaseSeeder.php";
        $c = file_get_contents($ds);
        $c = preg_replace('/(\r?\n    \}\r?\n\})\s*$/', "\n        \$this->call(ModsSeeder::class);\$1", $c);
        file_put_contents($ds, $c);
    }
    echo "  + seeds\n";
}
echo "✓ $slug modules added\n";
