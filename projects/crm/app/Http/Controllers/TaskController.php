<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $rows = Task::with(['contact'])->latest();
        if ($q = request('q')) { $rows->where(function ($w) use ($q) { $w->Where('title', 'like', "%$q%"); }); }
        $rows = $rows->paginate(15)->withQueryString();
        return view('tasks.index', array_merge(compact('rows'), [
            'contacts' => \App\Models\Contact::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_id' => 'nullable|exists:contacts,id',
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:High,Medium,Low',
            'status' => 'required|in:Open,Done,Cancelled',
        ]);

        Task::create($data);
        return back()->with('ok', 'Task added.');
    }

    public function update(Request $request, Task $row)
    {
        $row->update($request->validate([
            'contact_id' => 'nullable|exists:contacts,id',
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:High,Medium,Low',
            'status' => 'required|in:Open,Done,Cancelled',
        ]));
        return redirect()->route('tasks.index')->with('ok', 'Task updated.');
    }

    public function destroy(Task $row)
    {
        $row->delete();
        return back()->with('ok', 'Task deleted.');
    }
}
