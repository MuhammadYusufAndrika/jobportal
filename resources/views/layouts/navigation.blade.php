<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-xl border-b border-white/20 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                                <span class="text-white font-bold text-xl">
                                    <img src="/assets/logo.png" alt="">
                                </span>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full animate-pulse"></div>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-2xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                JobVibe
                            </h1>
                            <p class="text-xs text-gray-500 -mt-1">Oku Timur Portal</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    @auth
                        @if(Auth::user()->hasRole('company'))
                            <a href="/company" class="nav-link-modern {{ request()->is('company*') ? 'active' : '' }}">
                                <span class="mr-2">🏢</span>
                                Company Dashboard
                            </a>
                        @elseif(Auth::user()->hasRole('admin'))
                            <a href="/admin" class="nav-link-modern {{ request()->is('admin*') ? 'active' : '' }}">
                                <span class="mr-2">⚡</span>
                                Admin Dashboard
                            </a>
                        @else
                            <a href="/user" class="nav-link-modern {{ request()->is('user*') ? 'active' : '' }}">
                                <span class="mr-2">🎯</span>
                                Dashboard
                            </a>
                        @endif
                    @endauth
                    
                    <a href="{{ route('jobs.index') }}" class="nav-link-modern {{ request()->routeIs('jobs.*') ? 'active' : '' }}">
                        <span class="mr-2">💼</span>
                        Jobs
                    </a>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                @auth
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="group inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-2xl text-gray-700 bg-white/50 hover:bg-white/80 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 hover:scale-105">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-3">
                                    <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="text-left">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</div>
                                </div>
                                <svg class="ml-2 h-4 w-4 group-hover:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                                <span class="mr-2">👤</span>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="flex items-center text-red-600">
                                    <span class="mr-2">🚪</span>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @else
                <div class="hidden sm:flex sm:items-center sm:space-x-3">
                    <a href="{{ route('login') }}" class="auth-btn-secondary">
                        <span class="mr-2">🔐</span>
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="auth-btn-primary">
                        <span class="mr-2">✨</span>
                        Register
                    </a>
                </div>
                @endauth

                <!-- Mobile menu button -->
                <div class="sm:hidden">
                    <button @click="open = ! open" class="mobile-menu-btn">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 backdrop-blur-xl border-t border-white/20">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @auth
                @if(Auth::user()->hasRole('company'))
                    <a href="/company" class="mobile-nav-link {{ request()->is('company*') ? 'active' : '' }}">
                        <span class="mr-2">🏢</span>
                        Company Dashboard
                    </a>
                @elseif(Auth::user()->hasRole('admin'))
                    <a href="/admin" class="mobile-nav-link {{ request()->is('admin*') ? 'active' : '' }}">
                        <span class="mr-2">⚡</span>
                        Admin Dashboard
                    </a>
                @else
                    <a href="/user" class="mobile-nav-link {{ request()->is('user*') ? 'active' : '' }}">
                        <span class="mr-2">🎯</span>
                        Dashboard
                    </a>
                @endif
            @endauth
            
            <a href="{{ route('jobs.index') }}" class="mobile-nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}">
                <span class="mr-2">💼</span>
                Jobs
            </a>
        </div>

        @auth
        <!-- Mobile User Menu -->
        <div class="pt-4 pb-1 border-t border-white/20">
            <div class="px-4 pb-3">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-3">
                        <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
                    <span class="mr-2">👤</span>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="mobile-nav-link text-red-600">
                        <span class="mr-2">🚪</span>
                        Log Out
                    </a>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-white/20">
            <div class="px-4 space-y-2">
                <a href="{{ route('login') }}" class="mobile-nav-link">
                    <span class="mr-2">🔐</span>
                    Login
                </a>
                <a href="{{ route('register') }}" class="mobile-nav-link">
                    <span class="mr-2">✨</span>
                    Register
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav>

<style>
.nav-link-modern {
    @apply inline-flex items-center px-4 py-2 text-sm font-medium rounded-2xl transition-all duration-200 hover:scale-105;
    @apply text-gray-700 hover:text-purple-600 hover:bg-white/50;
}

.nav-link-modern.active {
    @apply bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg;
}

.auth-btn-primary {
    @apply inline-flex items-center px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-2xl hover:from-purple-700 hover:to-pink-700 transition-all duration-200 hover:scale-105 shadow-lg;
}

.auth-btn-secondary {
    @apply inline-flex items-center px-6 py-2 text-purple-600 font-semibold rounded-2xl border-2 border-purple-200 hover:border-purple-400 hover:bg-purple-50 transition-all duration-200 hover:scale-105;
}

.mobile-menu-btn {
    @apply inline-flex items-center justify-center p-2 rounded-2xl text-gray-400 hover:text-purple-600 hover:bg-white/50 focus:outline-none focus:bg-white/50 focus:text-purple-600 transition-all duration-200;
}

.mobile-nav-link {
    @apply flex items-center px-3 py-2 rounded-xl text-base font-medium text-gray-700 hover:text-purple-600 hover:bg-white/50 transition-all duration-200;
}

.mobile-nav-link.active {
    @apply bg-gradient-to-r from-purple-600 to-pink-600 text-white;
}
</style>
