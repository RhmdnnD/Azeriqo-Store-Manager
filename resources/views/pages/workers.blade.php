<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-2xl text-base-content leading-tight">
                {{ __('Workers Management') }}
            </h2>
            <!-- Add New Button with Hover Transition -->
            <button class="btn btn-primary shadow-sm hover:shadow-md transition-shadow duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Add Worker
            </button>
        </div>
    </x-slot>

    <!-- Advanced Filter Section -->
    <div class="card bg-base-200 shadow-sm mb-6 border border-base-300">
        <div class="card-body p-4 sm:p-6">
            <form method="GET" action="{{ url('/workers') }}" class="flex flex-col sm:flex-row gap-4">
                
                <!-- Search Input -->
                <div class="form-control flex-1">
                    <div class="flex w-full">
                        <input type="text" name="search" placeholder="Search workers by name..." class="input input-bordered w-full rounded-r-none focus:outline-none focus:border-primary transition-colors duration-200" value="{{ request('search') }}" />
                        <button type="submit" class="btn btn-primary rounded-l-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </button>
                    </div>
                </div>

                <!-- Status Filter Dropdown -->
                <div class="form-control w-full sm:w-48">
                    <select name="status" class="select select-bordered w-full focus:outline-none focus:border-primary transition-colors duration-200" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </form>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card bg-base-100 shadow-xl border border-base-300 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <!-- Table Head -->
                <thead class="bg-base-300 text-base-content text-sm uppercase tracking-wider">
                    <tr>
                        <th class="rounded-none">ID</th>
                        <th>Profile Info</th>
                        <th>Role / Title</th>
                        <th>Status</th>
                        <th class="text-right rounded-none">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @if(isset($workers) && $workers->count() > 0)
                        @foreach($workers as $worker)
                        <!-- Smooth row hover transition -->
                        <tr class="hover transition-colors duration-200 ease-in-out">
                            <td class="font-medium text-base-content/70">#{{ $worker->id }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-neutral text-neutral-content rounded-full w-10">
                                            <span class="text-xs uppercase">{{ substr($worker->name, 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $worker->name }}</div>
                                        <div class="text-sm opacity-50">{{ $worker->email ?? 'No email provided' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="font-medium">{{ $worker->position ?? 'Staff' }}</span>
                            </td>
                            <td>
                                @if(($worker->status ?? 'active') === 'active')
                                    <div class="badge badge-success badge-outline gap-1 p-3">Active</div>
                                @else
                                    <div class="badge badge-error badge-outline gap-1 p-3">Inactive</div>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <!-- Edit Action -->
                                    <button class="btn btn-sm btn-ghost btn-square text-info hover:bg-info/20 transition-colors duration-200" title="Edit Worker">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <!-- Delete Action -->
                                    <button class="btn btn-sm btn-ghost btn-square text-error hover:bg-error/20 transition-colors duration-200" title="Delete Worker">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <!-- Empty State UI -->
                        <tr>
                            <td colspan="5" class="bg-base-100">
                                <div class="flex flex-col items-center justify-center py-16 text-base-content/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    <p class="text-lg font-medium">No workers found</p>
                                    <p class="text-sm mt-1">Try adjusting your filters or add a new worker to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
        
        <!-- Pagination Link Area -->
        @if(isset($workers) && $workers->hasPages())
        <div class="border-t border-base-300 p-4 bg-base-200/50">
            <!-- Appending the current search queries to the pagination links so filters aren't lost when changing pages -->
            {{ $workers->appends(request()->query())->links('pagination.custom') }} 
        </div>
        @endif
    </div>
</x-app-layout>