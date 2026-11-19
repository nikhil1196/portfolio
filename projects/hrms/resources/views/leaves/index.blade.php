@extends('layouts.app')
@section('title', 'Leaves')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Leave' : 'Add Leave' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('leaves.update', $edit) : route('leaves.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Employee</label>
                    <select name="emp_id"><option value="">— Select —</option>
                        @foreach($employees as $id => $n)<option value="{{ $id }}" @selected(old('emp_id', $edit->emp_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Leave Type</label>
                    <select name="type">@foreach(array (
  0 => 'Casual',
  1 => 'Sick',
  2 => 'Earned',
  3 => 'Unpaid',
) as $s)<option @selected(old('type', $edit->type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>From</label><input type="date" name="from_date" value="{{ old('from_date', $edit->from_date ?? '') }}" required></div>
                <div class="form-row"><label>To</label><input type="date" name="to_date" value="{{ old('to_date', $edit->to_date ?? '') }}" required></div>
                <div class="form-row"><label>Reason</label><textarea name="reason">{{ old('reason', $edit->reason ?? '') }}</textarea></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Pending',
  1 => 'Approved',
  2 => 'Rejected',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Leave</button>
            @if($edit)<a class="btn" href="{{ route('leaves.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Leaves ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Employee</th><th>Type</th><th>From</th><th>To</th><th>Reason</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->employee->name ?? "—" }}</strong></td>
                    <td>{{ $r->type }}</td>
                    <td>{{ $r->from_date }}</td>
                    <td>{{ $r->to_date }}</td>
                    <td>{{ Str::limit($r->reason, 40) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        @if($r->status === 'Pending')
                            <form method="POST" action="{{ route('leaves.status', $r) }}" class="inline">@csrf @method('PATCH')
                                <input type="hidden" name="status" value="Approved"><button class="btn btn-sm" type="submit">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('leaves.status', $r) }}" class="inline">@csrf @method('PATCH')
                                <input type="hidden" name="status" value="Rejected"><button class="btn btn-sm btn-danger" type="submit">Reject</button>
                            </form>
                        @endif
                        <a class="btn btn-sm" href="{{ route('leaves.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('leaves.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
