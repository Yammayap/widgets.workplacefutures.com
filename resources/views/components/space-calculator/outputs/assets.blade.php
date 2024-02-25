<div>
    <h2>Assets</h2>
    @foreach($assets as $result)
        <li><strong>{{ $result->asset }}</strong>: {{ $result->quantity }}</li>
    @endforeach
</div>
