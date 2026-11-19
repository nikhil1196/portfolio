@extends('layouts.app')
@section('title', 'Complaints')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Complaint' : 'Add Complaint' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('complaints.update', $edit) : route('complaints.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Resident</label>
                    <select name="resident_id"><option value="">— Select —</option>
                        @foreach($residents as $id => $n)<option value="{{ $id }}" @selected(old('resident_id', $edit->resident_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Category</label>
                    <select name="category">@foreach(array (
  0 => 'Plumbing',
  1 => 'Electrical',
  2 => 'Security',
  3 => 'Cleaning',
  4 => 'Parking',
  5 => 'Other',
) as $s)<option @selected(old('category', $edit->category ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Subject</label><input type="text" name="subject" value="{{ old('subject', $edit->subject ?? '') }}" required></div>
                <div class="form-row"><label>Description</label><textarea name="description">{{ old('description', $edit->description ?? '') }}</textarea></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Open',
  1 => 'In Progress',
  2 => 'Resolved',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Complaint</button>
            @if($edit)<a class="btn" href="{{ route('complaints.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Complaints ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Flat</th><th>Resident</th><th>Subject</th><th>Category</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->resident->unit->flat_no ?? "—" }}</td>
                    <td><strong>{{ $r->resident->name ?? "—" }}</strong></td>
                    <td>{{ $r->subject }}</td>
                    <td>{{ $r->category }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        @if($r->status === 'Open')
                            <form method="POST" action="{{ route('complaints.status', $r) }}" class="inline">@csrf @method('PATCH')
                                <input type="hidden" name="status" value="In Progress"><button class="btn btn-sm" type="submit">Start</button>
                            </form>
                        @elseif($r->status === 'In Progress')
                            <form method="POST" action="{{ route('complaints.status', $r) }}" class="inline">@csrf @method('PATCH')
                                <input type="hidden" name="status" value="Resolved"><button class="btn btn-sm" type="submit">Resolve</button>
                            </form>
                        @endif
                        <a class="btn btn-sm" href="{{ route('complaints.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('complaints.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
