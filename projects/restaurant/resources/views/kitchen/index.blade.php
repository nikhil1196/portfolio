@extends('layouts.app')
@section('title', 'Kitchen Display')
@section('content')
<div class="kds-grid">
    @foreach($columns as $status => $orders)
        <div class="kds-col">
            <h2>{{ $status === 'Pending' ? 'New Orders' : ($status === 'Preparing' ? 'Preparing' : 'Ready to Serve') }}
                <span class="badge badge-err">{{ $orders->count() }}</span></h2>
            @forelse($orders as $o)
                <div class="kds-ticket">
                    <div class="kds-head">
                        <strong>{{ $o->order_no }}</strong>
                        <span>{{ $o->diningTable->name ?? '—' }} · {{ $o->created_at->format('h:i A') }}</span>
                    </div>
                    <ul>
                        @foreach($o->items as $it)<li>{{ $it->qty }} × {{ $it->item_name }}</li>@endforeach
                    </ul>
                    <form method="POST" action="{{ route('kitchen.advance', $o) }}">
                        @csrf
                        <button class="btn btn-acc btn-sm" type="submit">
                            {{ $status === 'Pending' ? 'Start Preparing' : ($status === 'Preparing' ? 'Mark Ready' : 'Mark Served') }}
                        </button>
                    </form>
                </div>
            @empty
                <p class="empty">Nothing here</p>
            @endforelse
        </div>
    @endforeach
</div>
@endsection
