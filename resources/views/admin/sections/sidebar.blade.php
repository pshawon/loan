<div class="bg-gray-800 text-white w-64 px-6 py-8">
    <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
    <ul class="mt-8">
        <li class="my-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center {{ is_active_route('admin.dashboard') }} hover:text-white">
                Dashboard
            </a>
        </li>
        <li class="my-3">
            <div x-data="{ open: {{ are_active_routes(['admin.all.users']) }} }">
                <button @click="open = !open" class="flex items-center text-gray-300 hover:text-white">
                    Users Management
                    <svg x-show="!open" class="ml-auto h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <svg x-show="open" class="ml-auto h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
                <ul x-show="open" class="ml-4 mt-2 space-y-2">
                    <li><a href="{{ route('admin.all.users') }}" class="{{ is_active_route('admin.all.users') }} hover:text-white">All User</a></li>
                </ul>
            </div>
        </li>
        <li class="my-3">
            <div x-data="{ open: {{ are_active_routes(['admin.all.loan-types']) }} }">
                <button @click="open = !open" class="flex items-center text-gray-300 hover:text-white">
                    Loan Type Management
                    <svg x-show="!open" class="ml-auto h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <svg x-show="open" class="ml-auto h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
                <ul x-show="open" class="ml-4 mt-2 space-y-2">
                    <li><a href="{{ route('admin.all.loan-types') }}" class="{{ is_active_route('admin.all.loan-types') }} hover:text-white">View Loan Types</a></li>
                </ul>
            </div>
        </li>
        <li class="my-3">
            <div x-data="{ open: {{ are_active_routes(['admin.all.loan-applications', 'admin.all.approved.loans']) }} }">
                <button @click="open = !open" class="flex items-center text-gray-300 hover:text-white">
                    Loan Management
                    <svg x-show="!open" class="ml-auto h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <svg x-show="open" class="ml-auto h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
                <ul x-show="open" class="ml-4 mt-2 space-y-2">
                    <li><a href="{{ route('admin.all.loan-applications') }}" class="{{ is_active_route('admin.all.loan-applications') }} hover:text-white">View Loan Application</a></li>
                    <li><a href="{{ route('admin.all.approved.loans') }}" class="{{ is_active_route('admin.all.approved.loans') }} hover:text-white">View Approved Loan</a></li>
                </ul>
            </div>
        </li>
        <!-- Add more menu items here -->
    </ul>
</div>
