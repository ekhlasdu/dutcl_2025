<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <!-- Logo / Brand -->
        <!-- Mobile Menu Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
               
                <li class="nav-item">
                    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('') }}">
                        <img src="{{ asset('images/du-logo.png') }}" 
                        alt="DU Logo" 
                        style="height: 40px; width: auto; margin-right: 10px;">
                    </a>
                </li>

                <li class="nav-item">
                            <a class="nav-link btn btn-warning px-3 ms-2" href="{{ url('player_list') }}" style="color:white">Player List</a>
                </li>

                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">Dashboard</a>
                </li>
                @endauth

                
            </a>
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- User Dropdown -->
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('players') ? 'active' : '' }}" href="{{ url('players') }}" style="color:white">Player List</a>
                    </li>
                    @if ($user->email =='admin_user@admin.com')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('operateAuction/Pool') ? 'active' : '' }}" href="{{ url('operateAuction/Pool') }}" style="color:white">Pool</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('operateAuction/Non-Pool') ? 'active' : '' }}" href="{{ url('operateAuction/Non-Pool') }}" style="color:white">Non Pool</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('unsold-players') ? 'active' : '' }}" href="{{ url('unsold-players') }}" style="color:white">Unsold Players</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('sold-players') ? 'active' : '' }}" href="{{ url('sold-players') }}" style="color:white">Sold Players</a>
                    </li>
                    @endif


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false" style="color:white">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <!-- <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}" >
                                    {{ __('Profile') }}
                                </a>
                            </li> -->
                            <!-- <li>
                                <hr class="dropdown-divider">
                            </li> -->
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Login / Register Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
