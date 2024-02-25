<div>
    <h2>Area types</h2>
    <ul>
        @foreach($areaTypes as $result)
            <li><strong>{{ $result->areaType }}</strong>: {{ $result->quantity }}</li>
        @endforeach
    </ul>
</div>
