<header>
    <div>
        <div>
            <a href="{{ route('web.home.index') }}" title="{{ $tenant->label() }}">
                <img src="{{ $tenant->logoFileUrl() }}" alt="{{ $tenant->label() }}" style="width:300px;" />
            </a>
        </div>
        <div>

        </div>
        <div style="display: flex; align-items: center;">
            @auth
                <span>@if(Auth::user()->name) Hello {{ Auth::user()->name }} @else Hello. @endif</span>
                <span style="margin: 0 10px;">|</span>
                <a href="{{ route('web.portal.index') }}" title="Portal">Portal</a>
                <span style="margin: 0 10px;">|</span>
                <form method="post" action="{{ route('web.auth.sign-out.post') }}">
                    @csrf
                    <button type="submit" title="Sign out">Sign out</button>
                </form>
            @endauth
        </div>
    </div>
</header>

<hr style="margin:25px 0;" />
