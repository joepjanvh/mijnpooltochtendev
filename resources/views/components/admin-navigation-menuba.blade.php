<div class="fixed left-0 top-0 w-64 h-full bg-[#f8f4f3] p-4 z-50 sidebar-menu transition-transform">
    <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
        <x-application-logo />
    </a>
    <ul class="mt-4">
        <span class="text-gray-400 font-bold">ADMIN</span>
        
        <!-- Dashboard -->
        <li class="mb-1 group">
            <a href=" " class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                <i class="ri-home-2-line mr-3 text-lg"></i>
                <span class="text-sm">Dashboard</span>
            </a>
        </li>

        <!-- Users Management -->
        <li class="mb-1 group">
            <a href="#" class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md sidebar-dropdown-toggle">
                <i class='bx bx-user mr-3 text-lg'></i>
                <span class="text-sm">Users</span>
                <i class="ri-arrow-right-s-line ml-auto"></i>
            </a>
            <ul class="pl-7 mt-2 hidden">
                <li class="mb-4">
                    <a href=" " class="text-gray-900 text-sm flex items-center hover:text-[#f84525]">All Users</a>
                </li>
                <li class="mb-4">
                    <a href=" " class="text-gray-900 text-sm flex items-center hover:text-[#f84525]">Roles & Permissions</a>
                </li>
            </ul>
        </li>

        <!-- Hike Management -->
        <li class="mb-1 group">
            <a href="#" class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md sidebar-dropdown-toggle">
                <i class='bx bxl-hiking mr-3 text-lg'></i>
                <span class="text-sm">Hike Management</span>
                <i class="ri-arrow-right-s-line ml-auto"></i>
            </a>
            <ul class="pl-7 mt-2 hidden">
                <li class="mb-4">
                    <a href=" " class="text-gray-900 text-sm flex items-center hover:text-[#f84525]">Alle Hikes</a>
                </li>
                <li class="mb-4">
                    <a href=" " class="text-gray-900 text-sm flex items-center hover:text-[#f84525]">Puntenoverzicht</a>
                </li>
                <li class="mb-4">
                    <a href=" " class="text-gray-900 text-sm flex items-center hover:text-[#f84525]">Koppel Beheer</a>
                    <ul class="pl-5 mt-2 hidden">
                        <li><a href=" " class="text-sm">Toevoegen</a></li>
                        <li><a href=" " class="text-sm">Bewerken</a></li>
                        <li><a href=" " class="text-sm">Importeren</a></li>
                    </ul>
                </li>
                <li class="mb-4">
                    <a href=" " class="text-gray-900 text-sm flex items-center hover:text-[#f84525]">Posten Beheer</a>
                </li>
            </ul>
        </li>

        <!-- Edition Manager -->
        <li class="mb-1 group">
            <a href="#" class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md sidebar-dropdown-toggle">
                <i class='bx bx-edit mr-3 text-lg'></i>
                <span class="text-sm">Edition Manager</span>
                <i class="ri-arrow-right-s-line ml-auto"></i>
            </a>
            <ul class="pl-7 mt-2 hidden">
                <li class="mb-4">
                    <a href=" " class="text-gray-900 text-sm flex items-center hover:text-[#f84525]">Overzicht</a>
                </li>
                <li class="mb-4">
                    <a href=" " class="text-gray-900 text-sm flex items-center hover:text-[#f84525]">Toevoegen</a>
                </li>
            </ul>
        </li>

        <!-- Activities -->
        <li class="mb-1 group">
            <a href=" " class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                <i class='bx bx-list-ul mr-3 text-lg'></i>
                <span class="text-sm">Activities</span>
            </a>
        </li>

        <!-- Archive -->
        <li class="mb-1 group">
            <a href=" " class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                <i class='bx bx-archive mr-3 text-lg'></i>
                <span class="text-sm">Archive</span>
            </a>
        </li>

        <!-- Personal -->
        <span class="text-gray-400 font-bold">PERSONAL</span>
        <li class="mb-1 group">
            <a href=" " class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                <i class='bx bx-bell mr-3 text-lg'></i>
                <span class="text-sm">Notifications</span>
                <span class="md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-red-600 bg-red-200 rounded-full">5</span>
            </a>
        </li>
        <li class="mb-1 group">
            <a href=" " class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                <i class='bx bx-envelope mr-3 text-lg'></i>
                <span class="text-sm">Messages</span>
                <span class="md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-green-600 bg-green-200 rounded-full">2 New</span>
            </a>
        </li>
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
