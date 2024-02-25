<div>
    <h2>Capacity types</h2>
    <ul>
        @foreach($capacityTypes as $result)
            <li><strong>{{ $result->capacityType }}</strong>: {{ $result->quantity }}</li>
        @endforeach
    </ul>
</div>
