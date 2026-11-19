@extends('layouts.app')
@section('title', 'Membership Plans')
@section('content')
@php $edit = request('edit') ? $plans->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Plan' : 'Add Plan' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('plans.update', $edit) : route('plans.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Plan Name *</label><input name="name" value="{{ old('name', $edit->name ?? '') }}" required placeholder="e.g. Annual"></div>
                <div class="form-row"><label>Duration (months) *</label><input type="number" name="duration_months" value="{{ old('duration_months', $edit->duration_months ?? 1) }}" min="1" required></div>
                <div class="form-row"><label>Price (₹) *</label><input type="number" step="0.01" name="price" value="{{ old('price', $edit->price ?? '') }}" required></div>
                <div class="form-row"><label>Features</label><input name="features" value="{{ old('features', $edit->features ?? '') }}" placeholder="Gym + classes + diet plan"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(['Active','Inactive'] as $s)<option @selected(old('status', $edit->status ?? 'Active') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update Plan' : 'Add Plan' }}</button>
            @if($edit)<a class="btn" href="{{ route('plans.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Plans ({{ $plans->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Plan</th><th>Duration</th><th>Price</th><th>Features</th><th>Members</th><th>Status</th><th></th></tr>
            @forelse($plans as $p)
                <tr>
                    <td><strong>{{ $p->name }}</strong></td>
                    <td>{{ $p->duration_months }} mo</td>
                    <td>₹{{ number_format($p->price) }}</td>
                    <td class="note">{{ $p->features }}</td>
                    <td>{{ $p->members_count }}</td>
                    <td><span class="badge">{{ $p->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('plans.index', ['edit' => $p->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('plans.destroy', $p) }}" class="inline" onsubmit="return confirm('Delete this plan?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No plans yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
