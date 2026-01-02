@extends('layout')

@section('content')

<div style="max-width: 1000px; margin: 0 auto;">

    <div style="margin-bottom: 30px;">
        <h1 class="page-title">Log Aktivitas</h1>
        <p class="page-subtitle">Pantau riwayat penambahan akun oleh seluruh tim.</p>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--border);">
                    <th style="padding: 16px 24px; font-weight: 600; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                        Waktu & Tanggal
                    </th>
                    <th style="padding: 16px 24px; font-weight: 600; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                        Worker / Pengirim
                    </th>
                    <th style="padding: 16px 24px; font-weight: 600; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                        Aktivitas
                    </th>
                    <th style="padding: 16px 24px; font-weight: 600; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                        Detail Akun
                    </th>
                </tr>
            </thead>
            <tbody style="background: white;">
                @forelse($logs as $log)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    
                    <td style="padding: 16px 24px; vertical-align: middle;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="background: #e0e7ff; color: var(--primary); padding: 8px; border-radius: 50%;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">
                                    {{ $log->created_at->format('H:i') }}
                                </div>
                                <div style="font-size: 0.8rem; color: #94a3b8;">
                                    {{ $log->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td style="padding: 16px 24px; vertical-align: middle;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; background: var(--text-main); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem;">
                                {{ substr($log->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">
                                    {{ $log->user->name }}
                                </div>
                                <div style="font-size: 0.75rem; color: #64748b;">
                                    {{ $log->user->role == 'admin' ? 'Administrator' : 'Staff Worker' }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td style="padding: 16px 24px; vertical-align: middle;">
                        <span style="background: #ecfdf5; color: #059669; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            INPUT DATA
                        </span>
                        <div style="margin-top: 5px; font-size: 0.85rem; font-weight: 500; color: var(--text-main);">
                            {{ $log->title }}
                        </div>
                    </td>

                    <td style="padding: 16px 24px; vertical-align: middle;">
                        <div style="font-family: 'Courier New', monospace; font-size: 0.9rem; color: #475569; background: #f1f5f9; padding: 4px 8px; border-radius: 4px; display: inline-block;">
                            {{ $log->username }}
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 50px;">
                        <div style="color: #cbd5e1; margin-bottom: 10px;">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div style="font-weight: 600; color: #94a3b8;">Belum ada aktivitas tercatat.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($logs->hasPages())
        <div style="padding: 15px 24px; border-top: 1px solid var(--border); background: #f8fafc;">
            {{ $logs->links() }} 
            </div>
        @endif

    </div>
</div>

@endsection