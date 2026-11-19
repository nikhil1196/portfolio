<?php
namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class TeamController extends Controller
{
    public function index()
    {
        return view('team.index', [
            'rows'  => User::with('role')->latest()->paginate(15)->withQueryString(),
            'roles' => Role::orderBy('name')->pluck('name', 'id'),
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6', 'role_id' => 'nullable|exists:roles,id',
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return back()->with('ok', 'User added.');
    }
    public function update(Request $request, User $row)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email,' . $row->id,
            'password' => 'nullable|string|min:6', 'role_id' => 'nullable|exists:roles,id',
        ]);
        if (empty($data['password'])) { unset($data['password']); } else { $data['password'] = Hash::make($data['password']); }
        $row->update($data);
        return redirect()->route('team.index')->with('ok', 'User updated.');
    }
    public function destroy(User $row)
    {
        abort_if($row->id === auth()->id(), 422, 'Cannot delete yourself.');
        $row->delete();
        return back()->with('ok', 'User removed.');
    }
}
