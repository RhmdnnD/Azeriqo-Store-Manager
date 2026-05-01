@extends('layout')

@section('content')

<style>
    /* Fix Pagination Dark Mode */
    nav[role="navigation"] svg { width: 20px !important; height: 20px !important; }
    nav[role="navigation"] > div { display: flex; align-items: center; justify-content: space-between; }
    
    /* Table Responsive Colors */
    .table-header { background: var(--bg-main); border-bottom: 1px solid var(--border); }
    .table-th { padding: 16px 24px; font-weight: 600; font-size: 0.75rem; color: var(--text-sub); text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap; }
    .table-tr { border-bottom: 1px solid var(--border); transition: 0.2s; }
    .table-tr:hover { background: var(--hover-bg); }
    .table-td { padding: 16px 24px; vertical-align: middle; white-space: nowrap; color: var(--text-main); }
</style>

<div style="max-width: 1000px; margin: 0 auto;">

    <div class="header-responsive">
        <div>
            <h1 class="page-title">Activity Log</h1>
            <p class="page-subtitle">Monitor account addition history.</p>
        </div>

        @if(Auth::user()->role == 'admin' && $logs->count() > 0)
        <button type="button" 
            onclick="confirmDelete('{{ route('log.clear') }}')"
            style="background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; padding: 10px 16px; border-radius: 8px; font-weight: 700; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: 0.2s; font-size: 0.85rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            CLEAR LOG
        </button>
        @endif
    </div>

    <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
        
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 600px;">
                <thead>
                    <tr class="table-header">
                        <th class="table-th">Time</th>
                        <th class="table-th">Worker</th>
                        <th class="table-th">Activity</th>
                        <th class="table-th">Account Details</th>
                    </tr>
                </thead>
                <tbody style="background: var(--bg-surface);">
                    @forelse($logs as $log)
                    <tr class="table-tr">
                        <td class="table-td">
                            <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">{{ $log->created_at->format('H:i') }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-sub);">{{ $log->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td class="table-td">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">{{ $log->user->name ?? 'Deleted User' }}</div>
                            </div>
                        </td>
                        <td class="table-td">
                            <span style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 700;">INPUT DATA</span>
                            <div style="margin-top: 5px; font-size: 0.8rem; font-weight: 500; color: var(--text-main);">{{ $log->title }}</div>
                        </td>
                        <td class="table-td">
                            <div style="font-family: monospace; font-size: 0.85rem; color: var(--text-sub); background: var(--bg-main); padding: 6px 10px; border-radius: 6px; display: inline-block; border: 1px solid var(--border);">
                                {{ $log->username }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px;">
                            <div style="color: var(--text-sub);">No activity recorded yet.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div style="padding: 15px 24px; border-top: 1px solid var(--border); background: var(--bg-main);">
            {{ $logs->links('pagination.custom') }} 
        </div>
        @endif

    </div>
</div>
@endsection