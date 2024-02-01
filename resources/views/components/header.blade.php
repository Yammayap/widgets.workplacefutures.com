<header>
    <div>
        <div> {{-- todo: discuss - would it be better to just link to the space calculator for now or leave it like this? (eventually this would redirect to the space calculator) --}}
            <a href="/" title="{{ $tenant->label() }}">
                <img src="{{ $tenant->logoFilePath() }}" alt="{{ $tenant->label() }}" />
            </a>
        </div>
        <div>
            {{-- space for menu here? (based on MPMR layout) --}}
        </div>
        <div>
            @if(\Auth::check())
                Hello {{ \Auth::user()->name }}!
            @endif
        </div>
    </div>
</header>