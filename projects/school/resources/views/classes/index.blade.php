@extends('layouts.app')
@section('title', 'Classs')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Class' : 'Add Class' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('classes.update', $edit) : route('classes.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Class Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Section</label><input type="text" name="section" value="{{ old('section', $edit->section ?? '') }}"></div>
                <div class="form-row"><label>Class Teacher</label>
                    <select name="teacher_id"><option value="">— Select —</option>
                        @foreach($teachers as $id => $n)<option value="{{ $id }}" @selected(old('teacher_id', $edit->teacher_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Room No</label><input type="text" name="room" value="{{ old('room', $edit->room ?? '') }}"></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Class</button>
            @if($edit)<a class="btn" href="{{ route('classes.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Classs ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Class</th><th>Teacher</th><th>Room</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }} {{ $r->section }}</strong></td>
                    <td>{{ $r->teacher->name ?? "—" }}</td>
                    <td>{{ $r->room }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('classes.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('classes.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
