@extends('layouts.app')
@section('title', 'Trainers')
@section('content')
@php $edit = request('edit') ? $trainers->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Trainer' : 'Add Trainer' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'trainers') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('trainers.update', $edit) : route('trainers.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Trainer Name *</label><input name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Specialty</label><input name="specialty" value="{{ old('specialty', $edit->specialty ?? '') }}" placeholder="e.g. Strength & Conditioning"></div>
                <div class="form-row"><label>Phone</label><input name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(['Active','Inactive'] as $s)<option @selected(old('status', $edit->status ?? 'Active') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update Trainer' : 'Add Trainer' }}</button>
            @if($edit)<a class="btn" href="{{ route('trainers.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Trainers ({{ $trainers->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Name</th><th>Specialty</th><th>Phone</th><th>Assigned Members</th><th>Status</th><th></th></tr>
            @forelse($trainers as $t)
                <tr>
                    <td><strong>{{ $t->name }}</strong></td>
                    <td>{{ $t->specialty }}</td>
                    <td>{{ $t->phone }}</td>
                    <td>{{ $t->members_count }}</td>
                    <td><span class="badge">{{ $t->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'trainers', 'id' => $t->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('trainers.index', ['edit' => $t->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('trainers.destroy', $t) }}" class="inline" onsubmit="return confirm('Delete this trainer?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">No trainers yet</td></tr>
            @endforelse
        </table>
        {{ $trainers->links() }}
    </div>
</div>
@endsection
