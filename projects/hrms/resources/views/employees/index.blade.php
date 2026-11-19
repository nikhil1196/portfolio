@extends('layouts.app')
@section('title', 'Employees')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Employee' : 'Add Employee' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('employees.update', $edit) : route('employees.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Emp Code</label><input type="text" name="emp_code" value="{{ old('emp_code', $edit->emp_code ?? '') }}"></div>
                <div class="form-row"><label>Full Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Department</label>
                    <select name="dept_id"><option value="">— Select —</option>
                        @foreach($departments as $id => $n)<option value="{{ $id }}" @selected(old('dept_id', $edit->dept_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Designation</label><input type="text" name="designation" value="{{ old('designation', $edit->designation ?? '') }}"></div>
                <div class="form-row"><label>Email</label><input type="email" name="email" value="{{ old('email', $edit->email ?? '') }}"></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Joining Date</label><input type="date" name="joining_date" value="{{ old('joining_date', $edit->joining_date ?? '') }}"></div>
                <div class="form-row"><label>Salary (₹/mo)</label><input type="number" name="salary" value="{{ old('salary', $edit->salary ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'On Notice',
  2 => 'Exited',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Employee</button>
            @if($edit)<a class="btn" href="{{ route('employees.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Employees ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Code</th><th>Name</th><th>Dept</th><th>Joined</th><th>Salary</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->emp_code }}</code></td>
                    <td><strong>{{ $r->name }}</strong><br><span class="note">{{ $r->designation }}</span></td>
                    <td>{{ $r->department->name ?? "—" }}</td>
                    <td>{{ $r->joining_date }}</td>
                    <td>₹{{ number_format($r->salary) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('employees.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('employees.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
