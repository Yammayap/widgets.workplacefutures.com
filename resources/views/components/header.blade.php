<header>
    <div>
        <div>
            <a href="{{ route('web.home.index') }}" title="{{ $tenant->label() }}">
                <img src="{{ $tenant->logoFileUrl() }}" alt="{{ $tenant->label() }}" style="width:300px;" />
            </a>
        </div>
        <div>

        </div>
        <div style="display: flex;">
            @auth
                @if(Auth::user()->name) Hello {{ Auth::user()->name }} Not you? @else Hello. @endif
                <form method="post" action="{{ route('web.auth.sign-out.post') }}">
                    @csrf
                    <button type="submit" title="Sign out">Sign out</button>
                </form>
            @endauth
        </div>
    </div>
</header>

<hr style="margin:25px 0;" />
