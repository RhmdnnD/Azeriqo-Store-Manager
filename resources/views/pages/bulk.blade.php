@extends('layout')

@section('content')

<div style="max-width: 900px; margin: 0 auto;">

    <div class="page-header">
        <h1 class="page-title">Import & Export Data</h1>
        <p class="page-subtitle">Manage large quantities of stock at once.</p>
    </div>

    <div class="grid-responsive">
        
        <div class="card" style="border-top: 4px solid var(--success);">
            <h3 style="margin-bottom: 15px; color: var(--text-main); display: flex; align-items: center; gap: 10px;">
                <svg width="24" height="24" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                IMPORT ACCOUNTS (Upload)
            </h3>
            
            <form action="{{ route('bulk.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">1. Select Destination Category</label>
                    <select name="title" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: #f8fafc;">
                        <option value="" disabled selected>-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">2. Upload File (.txt)</label>
                    <input type="file" name="file" required accept=".txt,.csv" style="width: 100%; padding: 10px; border: 1px dashed var(--border); border-radius: 6px; background: #f1f5f9;">
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 5px;">
                        Row format: <code>username|password</code> or <code>username,password</code>
                    </div>
                </div>

                <button type="submit" style="width: 100%; background: var(--success); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    UPLOAD DATA
                </button>
            </form>
        </div>

        <div class="card" style="border-top: 4px solid var(--primary);">
            <h3 style="margin-bottom: 15px; color: var(--text-main); display: flex; align-items: center; gap: 10px;">
                <svg width="24" height="24" fill="none" stroke="var(--primary)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                EXPORT ACCOUNTS (Download)
            </h3>
            
            <form action="{{ route('bulk.export') }}" method="GET">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Select Category to Download</label>
                    <select name="category" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: #f8fafc;">
                        <option value="all">ALL CATEGORIES (Full Backup)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" style="width: 100%; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    DOWNLOAD .TXT
                </button>
            </form>
            
            <div style="margin-top: 20px; padding: 15px; background: #eef2ff; border-radius: 8px; font-size: 0.85rem; color: #4338ca;">
                <strong>Info:</strong> This Export feature is useful for backing up data or when you want to send a stock list to buyers (Resellers).
            </div>
        </div>

    </div>
</div>
@endsection