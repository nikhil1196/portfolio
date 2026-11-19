@extends('layouts.app')
@section('title', 'Fees')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Fee' : 'Add Fee' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('fees.update', $edit) : route('fees.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Student</label>
                    <select name="student_id"><option value="">— Select —</option>
                        @foreach($students as $id => $n)<option value="{{ $id }}" @selected(old('student_id', $edit->student_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Term</label>
                    <select name="term">@foreach(array (
  0 => 'Term 1',
  1 => 'Term 2',
  2 => 'Term 3',
  3 => 'Annual',
) as $s)<option @selected(old('term', $edit->term ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" name="amount" value="{{ old('amount', $edit->amount ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Paid',
  1 => 'Pending',
  2 => 'Overdue',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Date</label><input type="date" name="paid_at" value="{{ old('paid_at', $edit->paid_at ?? '') }}"></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Fee</button>
            @if($edit)<a class="btn" href="{{ route('fees.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Fees ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Receipt</th><th>Student</th><th>Term</th><th>Amount</th><th>Date</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->receipt_no }}</code></td>
                    <td><strong>{{ $r->student->name }}</strong><br><span class="note">{{ $r->student->roll_no }}</span></td>
                    <td>{{ $r->term }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td>{{ $r->paid_at }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        @if($r->status === 'Pending')
                            <form method="POST" action="{{ route('fees.pay', $r) }}" class="inline">@csrf @method('PATCH')
                                <button class="btn btn-sm" type="submit">Mark Paid</button>
                            </form>
                        @endif
                        <a class="btn btn-sm" href="{{ route('fees.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('fees.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
