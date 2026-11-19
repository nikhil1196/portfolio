@extends('layouts.app')
@section('title', 'Employee Documents')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Employee Document' : 'Add Employee Document' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('documents.update', $edit) : route('documents.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Employee</label>
                    <select name="employee_id"><option value="">— Select —</option>
                        @foreach($employees as $id => $n)<option value="{{ $id }}" @selected(old('employee_id', $edit->employee_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Document Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Type</label>
                    <select name="type" required>@foreach(array (
  0 => 'ID Proof',
  1 => 'Contract',
  2 => 'Certificate',
  3 => 'Offer Letter',
  4 => 'Other',
) as $s)<option @selected(old('type', $edit->type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>File / Link</label><input type="text" name="file_path" value="{{ old('file_path', $edit->file_path ?? '') }}"></div>
                <div class="form-row"><label>Expiry</label><input type="date" name="expiry" value="{{ old('expiry', $edit->expiry ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Expired',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Employee Document</button>
            @if($edit)<a class="btn" href="{{ route('documents.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Employee Documents ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Employee</th><th>Document</th><th>Type</th><th>Expiry</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->employee->name }}</strong></td>
                    <td>{{ $r->title }}</td>
                    <td><span class="badge">{{ $r->type }}</span></td>
                    <td>{{ $r->expiry ?? "—" }}</td>
                    <td>{{ $r->status }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('documents.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('documents.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
