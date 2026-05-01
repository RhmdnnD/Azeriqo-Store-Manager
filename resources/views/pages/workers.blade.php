@extends('layout')

@section('content')

<div style="max-width: 1000px; margin: 0 auto;">

    <div class="header-responsive">
        <div>
            <h1 class="page-title">Manage Workers</h1>
            <p class="page-subtitle">Add or remove staff worker access.</p>
        </div>
    </div>

    <div class="card" style="margin-bottom: 30px; border-left: 4px solid var(--primary);">
        <h3 style="font-size: 1rem; color: var(--text-main); margin-bottom: 15px;">+ Add New Worker</h3>
        <form action="{{ route('workers.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                
                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 5px; display: block; color: var(--text-main);">Full Name</label>
                    <input type="text" name="name" required placeholder="Staff Name" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg-main); color: var(--text-main);">
                </div>

                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 5px; display: block; color: var(--text-main);">Login Email</label>
                    <input type="email" name="email" required placeholder="staff@azeriqo.com" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg-main); color: var(--text-main);">
                </div>

                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 5px; display: block; color: var(--text-main);">Password</label>
                    <input type="text" name="password" required placeholder="Minimum 8 characters" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg-main); color: var(--text-main);">
                </div>

            </div>
            <button type="submit" style="margin-top: 15px; background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%;">
                SAVE WORKER
            </button>
        </form>
    </div>

    <h3 style="margin-bottom: 20px; font-size: 1.1rem; color: var(--text-sub);">Active Staff List ({{ $workers->count() }})</h3>
    
    <div class="grid-workers">
        @forelse($workers as $worker)
        <div style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px; display: flex; flex-direction: column; gap: 15px; transition: transform 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="width: 45px; height: 45px; background: var(--active-bg); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem;">
                    {{ substr($worker->name, 0, 1) }}
                </div>
                <div style="flex: 1; overflow: hidden;">
                    <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $worker->name }}</h4>
                    <div style="font-size: 0.85rem; color: var(--text-sub); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $worker->email }}</div>
                </div>
            </div>

            <div style="border-top: 1px solid var(--border); padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.75rem; background: var(--bg-main); padding: 4px 10px; border-radius: 20px; font-weight: 600; color: var(--text-sub);">
                    Role: Worker
                </span>

                <button type="button" 
                    onclick="confirmDelete('{{ route('workers.delete', $worker->id) }}')"
                    style="background: var(--bg-surface); border: 1px solid #fecaca; color: var(--danger); padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    DELETE
                </button>
            </div>

        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-sub); background: var(--bg-main); border-radius: 12px; border: 2px dashed var(--border);">
            No workers added yet.
        </div>
        @endforelse
    </div>

</div>
@endsection