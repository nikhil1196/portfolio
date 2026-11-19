@extends('layouts.app')
@section('title', 'Members')
@section('content')
@php $edit = request('edit') ? $members->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Member' : 'Add Member' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
        <div class="form-row"><label>Emergency Contact</label><input name="emergency_name" value="{{ old('emergency_name', $edit->emergency_name ?? '') }}"></div>
        <div class="form-row"><label>Emergency Phone</label><input name="emergency_phone" value="{{ old('emergency_phone', $edit->emergency_phone ?? '') }}"></div>
        <div class="form-row"><label>Membership Expiry</label><input type="date" name="expiry_date" value="{{ old('expiry_date', $edit->expiry_date ?? '') }}"></div>
        <div class="form-row"><label>Photo</label><input type="file" name="photo" accept="image/*"></div>
        <div class="form-row"><label>Notes</label><textarea name="notes">{{ old('notes', $edit->notes ?? '') }}</textarea></div>
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'members') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="{{ $edit ? route('members.update', $edit) : route('members.store') }}">
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
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'members', 'id' => $m->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('members.index', ['edit' => $m->id]) }}">Edit</a>
                        <form method="POST" enctype="multipart/form-data" action="{{ route('members.destroy', $m) }}" class="inline" onsubmit="return confirm('Delete this member?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="empty">No members yet</td></tr>
            @endforelse
        </table>
        {{ $members->links() }}
    </div>
</div>
@endsection
