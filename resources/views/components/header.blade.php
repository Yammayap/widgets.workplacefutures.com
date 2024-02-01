<header>
    <div>
        <div>
            <a href="/" title="{{ $tenant->label() }}">
                <img src="{{ $tenant->logoFilePath() }}" alt="{{ $tenant->label() }}" />
            </a>
        </div>
        <div>
            {{-- space for menu here? (based on MPMR layout) --}}
        </div>
        <div>
            @if(\Auth::check())
                Hello {{ Auth::user()->name }}!
            @endif
        </div>
    </div>
</header>