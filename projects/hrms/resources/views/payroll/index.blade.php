@extends('layouts.app')
@section('title', 'Payroll Entrys')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Payroll Entry' : 'Add Payroll Entry' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('payroll.update', $edit) : route('payroll.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Employee</label>
                    <select name="emp_id"><option value="">— Select —</option>
                        @foreach($employees as $id => $n)<option value="{{ $id }}" @selected(old('emp_id', $edit->emp_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Month</label><input type="month" name="month" value="{{ old('month', $edit->month ?? '') }}" required></div>
                <div class="form-row"><label>Basic (₹)</label><input type="number" name="basic" value="{{ old('basic', $edit->basic ?? '') }}" required></div>
                <div class="form-row"><label>Allowances (₹)</label><input type="number" name="allowances" value="{{ old('allowances', $edit->allowances ?? '') }}"></div>
                <div class="form-row"><label>Deductions (₹)</label><input type="number" name="deductions" value="{{ old('deductions', $edit->deductions ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Processed',
  1 => 'Paid',
  2 => 'On Hold',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Payroll Entry</button>
            @if($edit)<a class="btn" href="{{ route('payroll.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Payroll Entrys ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
            <select name="status"><option value="">All</option><option @selected(request('status')==='Processed')>Processed</option><option @selected(request('status')==='Paid')>Paid</option></select>
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'payroll') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Employee</th><th>Month</th><th>Basic</th><th>Net Pay</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->employee->name ?? "—" }}</strong><br><span class="note">{{ $r->employee->emp_code ?? "" }}</span></td>
                    <td>{{ $r->month }}</td>
                    <td>₹{{ number_format($r->basic) }}</td>
                    <td><strong>₹{{ number_format($r->net) }}</strong></td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'payroll', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('payroll.index', ['edit' => $r->id]) }}">Edit</a>
                        <a class="btn btn-sm" href="{{ route('payroll.payslip', $r) }}" target="_blank">Payslip</a>
                        @if($r->status !== 'Paid')<form method="POST" action="{{ route('payroll.paid', $r) }}" style="display:inline">@csrf<button class="btn btn-sm">Mark Paid</button></form>@endif
                        <form method="POST" action="{{ route('payroll.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
