@extends('layouts.app')
@section('title', 'Students')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Student' : 'Add Student' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('students.update', $edit) : route('students.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Student Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Roll No</label><input type="text" name="roll_no" value="{{ old('roll_no', $edit->roll_no ?? '') }}"></div>
                <div class="form-row"><label>Class</label>
                    <select name="class_id"><option value="">— Select —</option>
                        @foreach($school_classes as $id => $n)<option value="{{ $id }}" @selected(old('class_id', $edit->class_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Guardian Name</label><input type="text" name="guardian" value="{{ old('guardian', $edit->guardian ?? '') }}"></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Date of Birth</label><input type="date" name="dob" value="{{ old('dob', $edit->dob ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
  2 => 'Alumni',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Student</button>
            @if($edit)<a class="btn" href="{{ route('students.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Students ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Roll</th><th>Name</th><th>Class</th><th>Guardian</th><th>Phone</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->roll_no }}</code></td>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->schoolClass->name ?? "—" }}</td>
                    <td>{{ $r->guardian }}</td>
                    <td>{{ $r->phone }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('students.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('students.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
