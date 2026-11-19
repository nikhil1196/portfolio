<?php
namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
class RoleController extends Controller
{
    public const MODULES = array (
  'members' => 'Member',
  'plans' => 'Plan',
  'trainers' => 'Trainer',
  'payments' => 'Payment',
);
    public function index()
    {
        $rows = Role::withCount('users')->latest()->paginate(15)->withQueryString();
        return view('roles.index', ['rows' => $rows, 'modules' => array_keys(self::MODULES)]);
    }
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:50', 'perms' => 'nullable|array']);
        Role::create(['name' => $data['name'], 'perms' => implode(',', $data['perms'] ?? [])]);
        return back()->with('ok', 'Role created.');
    }
    public function update(Request $request, Role $row)
    {
        $data = $request->validate(['name' => 'required|string|max:50', 'perms' => 'nullable|array']);
        $row->update(['name' => $data['name'], 'perms' => implode(',', $data['perms'] ?? [])]);
        return redirect()->route('roles.index')->with('ok', 'Role updated.');
    }
    public function destroy(Role $row)
    {
        $row->delete();
        return back()->with('ok', 'Role deleted.');
    }
}
