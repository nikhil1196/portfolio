@extends('layouts.app')
@section('title', 'Patients')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Patient' : 'Add Patient' }}</h2></div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="{{ $edit ? route('patients.update', $edit) : route('patients.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Full Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Date of Birth</label><input type="date" name="dob" value="{{ old('dob', $edit->dob ?? '') }}"></div>
                <div class="form-row"><label>Gender</label>
                    <select name="gender">@foreach(array (
  0 => 'Male',
  1 => 'Female',
  2 => 'Other',
) as $s)<option @selected(old('gender', $edit->gender ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Blood Group</label><input type="text" name="blood" value="{{ old('blood', $edit->blood ?? '') }}"></div>
                <div class="form-row"><label>Address</label><textarea name="address">{{ old('address', $edit->address ?? '') }}</textarea></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
                <div class="form-row"><label>Medical History</label><textarea name="medical_history">{{ old('medical_history', $edit->medical_history ?? '') }}</textarea></div>
                <div class="form-row"><label>Document</label><input type="file" name="document"></div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Patient</button>
            @if($edit)<a class="btn" href="{{ route('patients.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Patients ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'patients') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Name</th><th>Phone</th><th>Gender</th><th>Blood</th><th>DOB</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->phone }}</td>
                    <td>{{ $r->gender }}</td>
                    <td>{{ $r->blood }}</td>
                    <td>{{ $r->dob }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'patients', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('patients.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" enctype="multipart/form-data" action="{{ route('patients.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
