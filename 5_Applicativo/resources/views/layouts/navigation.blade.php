<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center px-6">
                    <a href="/">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                    </a>
                </div>

                <!-- Navigation Links - Visibile sopra 750px -->
                <div class="hidden md:flex space-x-8 ms-10">
                    @if(Route::currentRouteName() === 'home' || Route::currentRouteName() === 'catalog' || Route::currentRouteName() === 'cart.index' || Route::currentRouteName() === 'profile.edit' || Route::currentRouteName() === 'product.get')
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
                    @if(Route::currentRouteName() === 'home' || Route::currentRouteName() === 'catalog' || Route::currentRouteName() === 'cart.index' || Route::currentRouteName() === 'profile.edit' || Route::currentRouteName() === 'product.get')
                        <x-nav-link class="flex items-center" style="width: 30vw">
                            <!-- NAVBAR -->
                            <input
                                class="form-control rounded-2 h-9 px-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                id="search" type="search" placeholder="Search Product" aria-label="Search"
                                style="background-color: #f0f0f0"
                                value="{{ trim(implode(' ', array_filter([
                                   $searchTerm ?? '',
                                   request('price') ? 'price:'.request('price') : '',
                                   request('priceRange') ? 'priceRange:'.request('priceRange') : '',
                                   request('dateFilter') ? 'date:'.request('dateFilter') : '',
                                   request('size') ? 'size:'.request('size') : ''
                               ]))) }}">
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Cart and Profile - Visibile sopra 750px -->
            <div class="hidden md:flex items-center space-x-5 mr-6">
                @if (Route::has('login') && Auth::check())
                    <!-- Shopping Cart Icon-->
                    @if(Auth::user()->role->name === 'user')
                        <div class="px-6">
                            <a href="{{ route('cart.index') }}"
                               class="flex items-center text-gray-600 hover:text-gray-900">
                                <i class="fas fa-shopping-cart text-xl"></i>
                            </a>
                        </div>
                    @endif
                    <!-- Settings Dropdown -->
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
                            <div class="p-1 px-4 border-b border-gray-200">
                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500 break-words">
                                    {{ Auth::user()->email }}</div>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            @if(Auth::user()->role->name === 'user')
                                <x-dropdown-link :href="route('cart.showOrders')">
                                    {{ __('Orders') }}
                                </x-dropdown-link>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @elseif(Route::has('login') && !Auth::check())
                    <div class="hidden sm:flex sm:items-center space-x-3">
                        <a href="{{ route('login') }}"
                           class="btn text-white px-3 py-1 rounded-md m-1"
                           style="background-color: #D0A1FF;">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="btn text-white px-3 py-1 rounded-md m-1"
                           style="background-color: #D0A1FF;">
                            Sign Up
                        </a>
                    </div>
                @endif
            </div>

            <!-- Search Bar - Visibile sotto 750px -->
            <div class="-me-2 flex items-center md:hidden">
                @if(Route::currentRouteName() === 'home' || Route::currentRouteName() === 'catalog' || Route::currentRouteName() === 'cart.index' || Route::currentRouteName() === 'profile.edit' || Route::currentRouteName() === 'product.get')
                    <form class="flex items-center">
                        <input
                            class="form-control rounded-2 h-9 px-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500"
                            id="search" type="search" placeholder="Search Product" aria-label="Search"
                            style="background-color: #f0f0f0">
                    </form>
                @endif
            </div>

            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <!-- Responsive Navigation Menu - Visibile sotto 750px quando aperto -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
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
                    <x-responsive-nav-link :href="route('vendor.add')" :active="request()->routeIs('vendor.add')">
                        {{ __('Add Product') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('vendor.sales')" :active="request()->routeIs('vendor.sales')">
                        {{ __('Sales') }}
                    </x-responsive-nav-link>
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
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    @if(Auth::user()->role->name === 'user')
                        <x-responsive-nav-link :href="route('cart.showOrders')" :active="request()->routeIs('cart.showOrders')">
                            {{ __('Orders') }}
                        </x-responsive-nav-link>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
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
    $(document).ready(function () {
        var searchTimer;

        $('#search').on('keyup', function () {
            clearTimeout(searchTimer);
            var keyword = $(this).val().trim();

            if (keyword.length >= 3) {
                searchTimer = setTimeout(function () {
                    redirectToCatalog(keyword);
                }, 800);
            }
        });

        $('#search').on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                var keyword = $(this).val().trim();
                if (keyword.length > 0) {
                    redirectToCatalog(keyword);
                }
            }
        });

        function redirectToCatalog(keyword) {
            var url = '{{ route("catalog") }}?search=' + encodeURIComponent(keyword);
            window.location.href = url;
        }
    });
</script>
