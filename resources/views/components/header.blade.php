<header>
    <div>
        <div>
            <a href="/" title="{{ $tenant->label() }}">
                <img src="{{ $tenant->logoFileUrl() }}" alt="{{ $tenant->label() }}" />
            </a>
        </div>
        <div>
            {{-- space for menu here? (based on MPMR layout) --}}
        </div>
        <div>
            @auth {{-- todo: real text here for when designs are done --}}
                Hello {{ Auth::user()->name }}! Not you? <a href="{{ route('web.sign-out.index') }}" title="Sign Out">Sign Out</a>.
            @endauth
        </div>
    </div>
</header>