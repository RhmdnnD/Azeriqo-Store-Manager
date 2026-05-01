@extends('layout')

@section('content')

<div style="max-width: 800px; margin: 0 auto;">

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Store Settings</h1>
            <p class="page-subtitle">Manage account categories to keep them organized.</p>
        </div>
    </div>

    <div class="grid-responsive">
        
        <div class="card" style="height: fit-content;">
            <h3 style="margin-bottom: 15px; font-size: 1rem; color: var(--text-main);">Add New Category</h3>
            
            <form action="{{ route('settings.store') }}" method="POST">
                @csrf
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.85rem; color: var(--text-main);">Category Name</label>
                <input type="text" name="name" placeholder="Example: ACCOUNT 35 BEE" required
                       style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; margin-bottom: 15px; background: var(--bg-main); color: var(--text-main);">
                
                <button type="submit" style="width: 100%; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    + SAVE CATEGORY
                </button>
            </form>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 15px; font-size: 1rem; color: var(--text-main);">Active Categories List ({{ $categories->count() }})</h3>
            
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @forelse($categories as $cat)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: var(--bg-main); border: 1px solid var(--border); border-radius: 8px;">
                    <span style="font-weight: 600; color: var(--text-main);">{{ $cat->name }}</span>
                    
                    <button type="button" 
                        onclick="confirmDelete('{{ route('settings.delete', $cat->id) }}')"
                        style="background: var(--bg-surface); border: 1px solid #fecaca; color: var(--danger); padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.75rem; font-weight: 600;">
                        DELETE
                    </button>
                </div>
                @empty
                <div style="text-align: center; color: var(--text-sub); padding: 20px;">No categories yet.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection