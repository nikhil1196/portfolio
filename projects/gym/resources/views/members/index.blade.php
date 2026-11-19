@extends('layouts.app')
@section('title', 'Members')
@section('content')
@php $edit = request('edit') ? $members->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Member' : 'Add Member' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('members.update', $edit) : route('members.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Full Name *</label><input name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Email</label><input type="email" name="email" value="{{ old('email', $edit->email ?? '') }}"></div>
                <div class="form-row"><label>Phone</label><input name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Plan</label>
                    <select name="plan_id"><option value="">— No plan —</option>
                        @foreach($plans as $id => $name)<option value="{{ $id }}" @selected(old('plan_id', $edit->plan_id ?? '') == $id)>{{ $name }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Trainer</label>
                    <select name="trainer_id"><option value="">— No trainer —</option>
                        @foreach($trainers as $id => $name)<option value="{{ $id }}" @selected(old('trainer_id', $edit->trainer_id ?? '') == $id)>{{ $name }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Join Date</label><input type="date" name="join_date" value="{{ old('join_date', $edit->join_date ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">
                        @foreach(['Active','Inactive','Expired'] as $s)<option @selected(old('status', $edit->status ?? 'Active') === $s)>{{ $s }}</option>@endforeach
                    </select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update Member' : 'Add Member' }}</button>
            @if($edit)<a class="btn" href="{{ route('members.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Members ({{ $members->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>#</th><th>Name</th><th>Contact</th><th>Plan</th><th>Trainer</th><th>Joined</th><th>Status</th><th></th></tr>
            @forelse($members as $m)
                <tr>
                    <td>{{ $m->id }}</td>
                    <td><strong>{{ $m->name }}</strong></td>
                    <td>{{ $m->phone }}<br><span class="note">{{ $m->email }}</span></td>
                    <td>{{ $m->plan->name ?? '—' }}</td>
                    <td>{{ $m->trainer->name ?? '—' }}</td>
                    <td>{{ $m->join_date ? \Carbon\Carbon::parse($m->join_date)->format('d M Y') : '—' }}</td>
                    <td><span class="badge">{{ $m->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('members.index', ['edit' => $m->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('members.destroy', $m) }}" class="inline" onsubmit="return confirm('Delete this member?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="empty">No members yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
