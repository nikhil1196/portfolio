@extends('layouts.app')
@section('title', 'Doctors')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Doctor' : 'Add Doctor' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('doctors.update', $edit) : route('doctors.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Doctor Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Specialty</label><input type="text" name="specialty" value="{{ old('specialty', $edit->specialty ?? '') }}"></div>
                <div class="form-row"><label>Clinic</label>
                    <select name="clinic_id"><option value="">— Select —</option>
                        @foreach($clinics as $id => $n)<option value="{{ $id }}" @selected(old('clinic_id', $edit->clinic_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Email</label><input type="email" name="email" value="{{ old('email', $edit->email ?? '') }}"></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Consultation Fee (₹)</label><input type="number" name="fee" value="{{ old('fee', $edit->fee ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Doctor</button>
            @if($edit)<a class="btn" href="{{ route('doctors.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Doctors ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'doctors') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Name</th><th>Specialty</th><th>Clinic</th><th>Phone</th><th>Fee</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->specialty }}</td>
                    <td>{{ $r->clinic->name ?? "—" }}</td>
                    <td>{{ $r->phone }}</td>
                    <td>₹{{ number_format($r->fee) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'doctors', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('doctors.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('doctors.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
