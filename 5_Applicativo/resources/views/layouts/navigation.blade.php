<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Search Bar -->
                <!-- Search Bar -->
{{--                <div class="mb-4 w-100">--}}
{{--                    <form class="d-flex">--}}
{{--                        <input class="form-control rounded-2" id="search" type="search" placeholder="Search Product"--}}
{{--                               aria-label="Search">--}}
{{--                    </form>--}}
{{--                </div>--}}

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <form class="d-flex">
                        <input class="form-control rounded-2 mt-3 h-9" id="search" type="search" placeholder="Search Product"
                               aria-label="Search">
                    </form>
                    @if(Route::currentRouteName() === 'home' || Route::currentRouteName() === 'catalog')
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('catalog')" :active="request()->routeIs('catalog')">
                            {{ __('Catalog') }}
                        </x-nav-link>
                        @if (Route::has('login') && Auth::check())
                            @if(Auth::user()->role->name === 'admin')
                                <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')">
                                    {{ __('Admin') }}
                                </x-nav-link>
                            @elseif(Auth::user()->role->name === 'vendor')
                                <x-nav-link :href="route('vendor')" :active="request()->routeIs('vendor')">
                                    {{ __('Vendor') }}
                                </x-nav-link>
                            @endif
                        @endif
                    @else
                        @if (Route::has('login') && Auth::check())
                            @if(Auth::user()->role->name === 'admin')
                                <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')">
                                    {{ __('Admin') }}
                                </x-nav-link>
                            @elseif(Auth::user()->role->name === 'vendor')
                                <x-nav-link :href="route('vendor')" :active="request()->routeIs('vendor')">
                                    {{ __('Products') }}
                                </x-nav-link>
                                <x-nav-link :href="route('vendor.add')" :active="request()->routeIs('vendor.add')">
                                    {{ __('Add Product') }}
                                </x-nav-link>
                                <x-nav-link :href="route('vendor.sales')" :active="request()->routeIs('vendor.sales')">
                                    {{ __('Sales') }}
                                </x-nav-link>
                            @endif
                        @endif
                    @endif
                </div>
            </div>

            @if (Route::has('login') && Auth::check())
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->username }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                            <x-dropdown-link :href="route('cart.index')">
                                {{ __('Cart') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

            @elseif(Route::has('login') && !Auth::check())
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <button type="button" class="btn me-3" style="color:whitesmoke; background-color: #D0A1FF;">
                        <a href="{{ route('login') }}">Login</a>
                    </button>
                    <button type="button" class="btn" style="color:whitesmoke; background-color: #D0A1FF;"
                            href="{{ route('register') }}">
                        <a href="{{ route('register') }}">Sign Up</a>
                    </button>
                </div>
            @endif

            <!-- Menu Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Route::currentRouteName() === 'home' || Route::currentRouteName() === 'catalog')
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('catalog')" :active="request()->routeIs('catalog')">
                    {{ __('Catalog') }}
                </x-responsive-nav-link>
                @if (Route::has('login') && Auth::check())
                    @if(Auth::user()->role->name === 'admin')
                        <x-responsive-nav-link :href="route('admin')" :active="request()->routeIs('admin')">
                            {{ __('Admin') }}
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->role->name === 'vendor')
                        <x-responsive-nav-link :href="route('vendor')" :active="request()->routeIs('vendor')">
                            {{ __('Vendor') }}
                        </x-responsive-nav-link>
                    @endif
                @endif
            @else
                @if (Route::has('login') && Auth::check())
                    @if(Auth::user()->role->name === 'admin')
                        <x-responsive-nav-link :href="route('admin')" :active="request()->routeIs('admin')">
                            {{ __('Admin') }}
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->role->name === 'vendor')
                        <x-responsive-nav-link :href="route('vendor')" :active="request()->routeIs('vendor')">
                            {{ __('Products') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('vendor.add')" :active="request()->routeIs('vendor.add')">
                            {{ __('Add Product') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Sales') }}
                        </x-responsive-nav-link>
                    @endif
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @if (Route::has('login') && Auth::check())
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>

                    <x-responsive-nav-link :href="route('cart.index')">
                        {{ __('Cart') }}
                    </x-responsive-nav-link>

                    </div>
                </div>
            @elseif(Route::has('login') && !Auth::check())
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('login') }}">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('register') }}">
                        {{ __('Sign Up') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        </div>
    </div>

</nav>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var searchTimer;

        $('#search').on('keyup', function() {
            clearTimeout(searchTimer);
            var keyword = $(this).val().trim();

            // Avvia il timer solo se la keyword ha almeno 3 caratteri
            if(keyword.length >= 3) {
                searchTimer = setTimeout(function() {
                    redirectToCatalog(keyword);
                }, 800); // Ritardo di 800ms dopo l'ultimo tasto premuto
            }
        });

        // Se si preme Invio, esegue subito la ricerca
        $('#search').on('keypress', function(e) {
            if(e.which === 13) { // 13 = tasto enter
                e.preventDefault();
                var keyword = $(this).val().trim();
                if(keyword.length > 0) {
                    redirectToCatalog(keyword);
                }
            }
        });

        function redirectToCatalog(keyword) {
            // Costruzione URL
            var url = '{{ route("catalog") }}?search=' + encodeURIComponent(keyword) + '&page=2';
            window.location.href = url;
        }
    });
</script>
