<div class="navbar bg-base-100 border-b border-base-200 sticky top-0 z-30 h-16">
    
    <!-- Mobile Hamburger Menu Toggle -->
    <div class="flex-none lg:hidden">
        <label for="main-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </label>
    </div>
    
    <!-- Mobile Branding (Visible only on small screens) -->
    <div class="flex-1 px-2 mx-2 lg:hidden font-bold tracking-widest text-lg uppercase">
        Azeriqo
    </div>

    <!-- Desktop Spacer -->
    <div class="flex-1 hidden lg:block"></div>

    <!-- User Profile Dropdown -->
    <div class="flex-none pr-2 sm:pr-4">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost hover:bg-base-200 flex items-center gap-2">
                <div class="font-medium">{{ Auth::user()->name }}</div>
                <svg class="fill-current h-4 w-4 opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
            
            <ul tabindex="0" class="menu dropdown-content z-[1] p-2 shadow-lg bg-base-300 rounded-box w-52 mt-4 border border-base-200">
                <li>
                    <a href="{{ route('profile.edit') }}" class="hover:bg-base-200">Profile Settings</a>
                </li>
                <div class="divider my-0"></div>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full p-0">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-error hover:bg-error/10 rounded-lg">
                            Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>