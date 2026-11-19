<?php
// _sys.php <app-slug> — adds roles+permissions, team users, reports to an app.
$slug = $argv[1] ?? null;
$root = __DIR__ . "/$slug";
if (!$slug || !is_dir($root)) { fwrite(STDERR, "usage: php _sys.php <app>\n"); exit(1); }
$out = fn($p, $c) => file_put_contents("$root/$p", $c) !== false ? print("  + $p\n") : print("  ! FAIL $p\n");

// Discover modules: slug => Model from Route::resource lines
$routes = file_get_contents("$root/routes/web.php");
preg_match_all("/Route::resource\\('([^']+)',\\s*(?:\\\\?App\\\\Http\\\\Controllers\\\\)?(\\w+)Controller::class/", $routes, $mm, PREG_SET_ORDER);
$mods = [];
foreach ($mm as $m) $mods[$m[1]] = $m[2];
if (empty($mods)) { echo "  ! no resources found\n"; exit(1); }

// ---- 1. migrations: roles + role_id on users
$ts = time();
$next = fn() => date('Y_m_d_His', $ts = $ts + 61);
$out("database/migrations/" . $next() . "_create_roles_table.php", "<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('roles', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->text('perms')->nullable();
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('roles'); }
};
");
$out("database/migrations/" . $next() . "_add_role_id_to_users_table.php", "<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint \$table) {
            \$table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('users', fn(Blueprint \$table) => \$table->dropConstrainedForeignId('role_id'));
    }
};
");

// ---- 2. Role model + patch User model
$out("app/Models/Role.php", "<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Role extends Model
{
    protected \$fillable = ['name', 'perms'];
    public function users() { return \$this->hasMany(User::class); }
    public function permsList(): array { return array_filter(array_map('trim', explode(',', (string)\$this->perms))); }
}
");
$uf = "$root/app/Models/User.php";
$uc = file_get_contents($uf);
if (!str_contains($uc, 'role_id')) {
    $uc = preg_replace("/('password')\s*(,?)/", "$1$2'role_id',\n        ", $uc, 1);
    $uc = preg_replace("/(protected function casts|}\s*$)/s", "\n    public function role()\n    {\n        return \$this->belongsTo(Role::class);\n    }\n\n    public function hasPerm(string \$perm): bool\n    {\n        return \$this->role && in_array(\$perm, \$this->role->permsList(), true);\n    }\n$1", $uc, 1);
    file_put_contents($uf, $uc);
}

// ---- 3. Permission middleware + alias registration
@mkdir("$root/app/Http/Middleware", 0777, true);
$out("app/Http/Middleware/EnsurePermission.php", "<?php
namespace App\\Http\\Middleware;
use Closure;
use Illuminate\\Http\\Request;
class EnsurePermission
{
    public function handle(Request \$request, Closure \$next, string \$perm)
    {
        \$u = \$request->user();
        if (\$u && (\$u->hasPerm('*') || \$u->hasPerm(\$perm) || \$request->isMethod('GET'))) {
            return \$next(\$request);
        }
        abort(403, 'No permission for this module.');
    }
}
");
$bs = "$root/bootstrap/app.php";
$bc = file_get_contents($bs);
if (!str_contains($bc, 'EnsurePermission')) {
    $bc = preg_replace(
        '/->withMiddleware\(function \(Middleware \$middleware\)\s*(?::\s*void)?\s*\{/',
        "->withMiddleware(function (Middleware \$middleware) {\n        \$middleware->alias(['perm' => \\App\\Http\\Middleware\\EnsurePermission::class]);",
        $bc, 1);
    file_put_contents($bs, $bc);
}

// ---- 4. apply perm middleware to every resource route
$routes = preg_replace(
    "/(Route::resource\\('([^']+)',[^;]+?->only\\(\\[[^\\]]*\\]\\))/",
    "$1->middleware('perm:$2')",
    $routes);
// append system routes before last "});"
$sysRoutes = "\n    Route::resource('roles', \\App\\Http\\Controllers\\RoleController::class)->only(['index','store','update','destroy']);\n"
    . "    Route::resource('team', \\App\\Http\\Controllers\\TeamController::class)->only(['index','store','update','destroy']);\n"
    . "    Route::get('reports', [\\App\\Http\\Controllers\\ReportController::class, 'index'])->name('reports');\n";
$routes = preg_replace('/\n\}\);\s*$/', "\n$sysRoutes});", $routes);
file_put_contents("$root/routes/web.php", $routes);

// ---- 5. Controllers
$modsArr = var_export($mods, true);
$out("app/Http/Controllers/RoleController.php", "<?php
namespace App\\Http\\Controllers;
use App\\Models\\Role;
use Illuminate\\Http\\Request;
class RoleController extends Controller
{
    public const MODULES = $modsArr;
    public function index()
    {
        \$rows = Role::withCount('users')->latest()->get();
        return view('roles.index', ['rows' => \$rows, 'modules' => array_keys(self::MODULES)]);
    }
    public function store(Request \$request)
    {
        \$data = \$request->validate(['name' => 'required|string|max:50', 'perms' => 'nullable|array']);
        Role::create(['name' => \$data['name'], 'perms' => implode(',', \$data['perms'] ?? [])]);
        return back()->with('ok', 'Role created.');
    }
    public function update(Request \$request, Role \$row)
    {
        \$data = \$request->validate(['name' => 'required|string|max:50', 'perms' => 'nullable|array']);
        \$row->update(['name' => \$data['name'], 'perms' => implode(',', \$data['perms'] ?? [])]);
        return redirect()->route('roles.index')->with('ok', 'Role updated.');
    }
    public function destroy(Role \$row)
    {
        \$row->delete();
        return back()->with('ok', 'Role deleted.');
    }
}
");
$out("app/Http/Controllers/TeamController.php", "<?php
namespace App\\Http\\Controllers;
use App\\Models\\Role;
use App\\Models\\User;
use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Hash;
class TeamController extends Controller
{
    public function index()
    {
        return view('team.index', [
            'rows'  => User::with('role')->latest()->get(),
            'roles' => Role::orderBy('name')->pluck('name', 'id'),
        ]);
    }
    public function store(Request \$request)
    {
        \$data = \$request->validate([
            'name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6', 'role_id' => 'nullable|exists:roles,id',
        ]);
        \$data['password'] = Hash::make(\$data['password']);
        User::create(\$data);
        return back()->with('ok', 'User added.');
    }
    public function update(Request \$request, User \$row)
    {
        \$data = \$request->validate([
            'name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email,' . \$row->id,
            'password' => 'nullable|string|min:6', 'role_id' => 'nullable|exists:roles,id',
        ]);
        if (empty(\$data['password'])) { unset(\$data['password']); } else { \$data['password'] = Hash::make(\$data['password']); }
        \$row->update(\$data);
        return redirect()->route('team.index')->with('ok', 'User updated.');
    }
    public function destroy(User \$row)
    {
        abort_if(\$row->id === auth()->id(), 422, 'Cannot delete yourself.');
        \$row->delete();
        return back()->with('ok', 'User removed.');
    }
}
");
$sections = '';
foreach ($mods as $uri => $model) {
    $sections .= "        ['$uri', \\App\\Models\\$model::class],\n";
}
$out("app/Http/Controllers/ReportController.php", "<?php
namespace App\\Http\\Controllers;
class ReportController extends Controller
{
    public function index()
    {
        \$sections = [
$sections        ];
        \$reports = [];
        foreach (\$sections as [\$uri, \$model]) {
            \$byStatus = [];
            try {
                \$byStatus = \$model::selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status')->toArray();
            } catch (\\Throwable \$e) {}
            \$reports[] = [
                'uri' => \$uri, 'title' => ucfirst(\$uri),
                'total' => \$model::count(),
                'month' => \$model::where('created_at', '>=', now()->startOfMonth())->count(),
                'byStatus' => \$byStatus,
            ];
        }
        return view('reports.index', compact('reports'));
    }
}
");

// ---- 6. Views
@mkdir("$root/resources/views/roles", 0777, true);
@mkdir("$root/resources/views/team", 0777, true);
@mkdir("$root/resources/views/reports", 0777, true);
$out("resources/views/roles/index.blade.php", "@extends('layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
@php \$edit = request('edit') ? \$rows->firstWhere('id', request('edit')) : null; @endphp
<div class=\"card\">
    <div class=\"card-head\"><h2>{{ \$edit ? 'Edit Role' : 'Add Role' }}</h2></div>
    <div class=\"card-body\">
        <form method=\"POST\" action=\"{{ \$edit ? route('roles.update', \$edit) : route('roles.store') }}\">
            @csrf @if(\$edit) @method('PUT') @endif
            <div class=\"form-row\"><label>Role Name</label><input name=\"name\" value=\"{{ old('name', \$edit->name ?? '') }}\" required style=\"max-width:300px\"></div>
            <div class=\"form-row mt\"><label>Module Permissions (write access — everyone can view)</label>
                <div style=\"display:flex;flex-wrap:wrap;gap:10px 18px\">
                @php \$cur = \$edit ? \$edit->permsList() : []; @endphp
                @foreach(array_merge(['*'], \$modules) as \$pm)
                    <label style=\"font-weight:400;display:flex;gap:6px;align-items:center\">
                        <input type=\"checkbox\" name=\"perms[]\" value=\"{{ \$pm }}\" @checked(in_array(\$pm, \$cur))> {{ \$pm }}
                    </label>
                @endforeach
                </div>
            </div>
            <button class=\"btn btn-acc mt\" type=\"submit\">{{ \$edit ? 'Update' : 'Add' }} Role</button>
            @if(\$edit)<a class=\"btn\" href=\"{{ route('roles.index') }}\">Cancel</a>@endif
        </form>
    </div>
</div>
<div class=\"card\">
    <div class=\"card-head\"><h2>All Roles ({{ \$rows->count() }})</h2></div>
    <div class=\"card-body\" style=\"padding:0\">
        <table class=\"tbl\">
            <tr><th>Role</th><th>Permissions</th><th>Users</th><th></th></tr>
            @forelse(\$rows as \$r)
                <tr>
                    <td><strong>{{ \$r->name }}</strong></td>
                    <td>@foreach(\$r->permsList() as \$p)<span class=\"badge\">{{ \$p }}</span> @endforeach</td>
                    <td>{{ \$r->users_count }}</td>
                    <td>
                        <a class=\"btn btn-sm\" href=\"{{ route('roles.index', ['edit' => \$r->id]) }}\">Edit</a>
                        <form method=\"POST\" action=\"{{ route('roles.destroy', \$r) }}\" class=\"inline\" onsubmit=\"return confirm('Delete?')\">
                            @csrf @method('DELETE')<button class=\"btn btn-sm btn-danger\" type=\"submit\">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan=\"4\" class=\"empty\">No roles yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
");
$out("resources/views/team/index.blade.php", "@extends('layouts.app')
@section('title', 'Team Users')
@section('content')
@php \$edit = request('edit') ? \$rows->firstWhere('id', request('edit')) : null; @endphp
<div class=\"card\">
    <div class=\"card-head\"><h2>{{ \$edit ? 'Edit User' : 'Add User' }}</h2></div>
    <div class=\"card-body\">
        <form method=\"POST\" action=\"{{ \$edit ? route('team.update', \$edit) : route('team.store') }}\">
            @csrf @if(\$edit) @method('PUT') @endif
            <div class=\"form-grid\">
                <div class=\"form-row\"><label>Name</label><input name=\"name\" value=\"{{ old('name', \$edit->name ?? '') }}\" required></div>
                <div class=\"form-row\"><label>Email</label><input type=\"email\" name=\"email\" value=\"{{ old('email', \$edit->email ?? '') }}\" required></div>
                <div class=\"form-row\"><label>Password{{ \$edit ? ' (blank = keep)' : '' }}</label><input type=\"password\" name=\"password\" {{ \$edit ? '' : 'required' }}></div>
                <div class=\"form-row\"><label>Role</label>
                    <select name=\"role_id\"><option value=\"\">— No role —</option>
                        @foreach(\$roles as \$id => \$n)<option value=\"{{ \$id }}\" @selected(old('role_id', \$edit->role_id ?? '') == \$id)>{{ \$n }}</option>@endforeach
                    </select></div>
            </div>
            <button class=\"btn btn-acc\" type=\"submit\">{{ \$edit ? 'Update' : 'Add' }} User</button>
            @if(\$edit)<a class=\"btn\" href=\"{{ route('team.index') }}\">Cancel</a>@endif
        </form>
    </div>
</div>
<div class=\"card\">
    <div class=\"card-head\"><h2>All Users ({{ \$rows->count() }})</h2></div>
    <div class=\"card-body\" style=\"padding:0\">
        <table class=\"tbl\">
            <tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th></th></tr>
            @forelse(\$rows as \$r)
                <tr>
                    <td><strong>{{ \$r->name }}</strong></td>
                    <td>{{ \$r->email }}</td>
                    <td><span class=\"badge\">{{ \$r->role->name ?? '—' }}</span></td>
                    <td>{{ \$r->created_at->format('d M Y') }}</td>
                    <td>
                        <a class=\"btn btn-sm\" href=\"{{ route('team.index', ['edit' => \$r->id]) }}\">Edit</a>
                        @if(\$r->id !== auth()->id())
                        <form method=\"POST\" action=\"{{ route('team.destroy', \$r) }}\" class=\"inline\" onsubmit=\"return confirm('Remove this user?')\">
                            @csrf @method('DELETE')<button class=\"btn btn-sm btn-danger\" type=\"submit\">Del</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan=\"5\" class=\"empty\">No users</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
");
$out("resources/views/reports/index.blade.php", "@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<div class=\"stats-row\">
    @foreach(\$reports as \$r)
        <div class=\"stat-card\"><div class=\"stat-label\">{{ \$r['title'] }}</div>
            <div class=\"stat-value\">{{ \$r['total'] }}</div>
            <div class=\"stat-sub\">+{{ \$r['month'] }} this month</div></div>
    @endforeach
</div>
<div class=\"card\">
    <div class=\"card-head\"><h2>Status Breakdown</h2></div>
    <div class=\"card-body\" style=\"padding:0\">
        <table class=\"tbl\">
            <tr><th>Module</th><th>Total</th><th>New This Month</th><th>By Status</th></tr>
            @foreach(\$reports as \$r)
                <tr>
                    <td><a href=\"{{ url('/' . \$r['uri']) }}\"><strong>{{ \$r['title'] }}</strong></a></td>
                    <td>{{ \$r['total'] }}</td>
                    <td>{{ \$r['month'] }}</td>
                    <td>@foreach(\$r['byStatus'] as \$st => \$c)<span class=\"badge\">{{ \$st }}: {{ \$c }}</span> @endforeach</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
");

// ---- 7. nav
$lay = "$root/resources/views/layouts/app.blade.php";
$c = file_get_contents($lay);
if (!str_contains($c, 'team.index')) {
    $links = "            <a href=\"{{ route('reports') }}\" class=\"{{ request()->routeIs('reports') ? 'active' : '' }}\">@include(\"partials.icon\", [\"i\" => \"chart\"])Reports</a>\n"
        . "            <a href=\"{{ route('team.index') }}\" class=\"{{ request()->routeIs('team.*') ? 'active' : '' }}\">@include(\"partials.icon\", [\"i\" => \"users\"])Team</a>\n"
        . "            <a href=\"{{ route('roles.index') }}\" class=\"{{ request()->routeIs('roles.*') ? 'active' : '' }}\">@include(\"partials.icon\", [\"i\" => \"shield\"])Roles</a>\n";
    $c = str_replace('        </nav>', "$links        </nav>", $c);
    file_put_contents($lay, $c);
    echo "  + nav\n";
}

// ---- 8. seed roles + assign admin role
$ds = "$root/database/seeders/DatabaseSeeder.php";
$c = file_get_contents($ds);
if (!str_contains($c, 'Role::')) {
    $c = preg_replace('/(public function run\(\): void\s*\n\s*\{)/',
        "$1\n        \\App\\Models\\Role::insert([\n            ['name' => 'Admin', 'perms' => '*', 'created_at' => now(), 'updated_at' => now()],\n            ['name' => 'Manager', 'perms' => '" . implode(',', array_keys($mods)) . "', 'created_at' => now(), 'updated_at' => now()],\n            ['name' => 'Viewer', 'perms' => '', 'created_at' => now(), 'updated_at' => now()],\n        ]);",
        $c, 1);
    $c = preg_replace("/(\\\\App\\\\Models\\\\User::create\(\[[^\]]*'password'[^;]+\);)/s", "$1\n        \\App\\Models\\User::where('email', 'admin@demo.local')->update(['role_id' => 1]);", $c, 1);
    file_put_contents($ds, $c);
    echo "  + seeder\n";
}
echo "✓ $slug system modules added\n";
