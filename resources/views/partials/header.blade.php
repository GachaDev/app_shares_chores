<header class="body__header">
    <div class="header__div_logo">
        LOGO HOME
    </div>
    <nav class="header__navigation">
        @if (isset($user))
            <span>{{ $user->name }}</span>
            <a href="{{ route('user.showLogin') }}" class="navigation__a">
                LOGOUT
            </a>
        @else
            <a href="{{ route('user.showLogin') }}" class="navigation__a">
                LOGIN
            </a>
            <a href="{{ route('user.showRegister') }}" class="navigation__a">
                REGISTER
            </a>
        @endif
    </nav>
</header>