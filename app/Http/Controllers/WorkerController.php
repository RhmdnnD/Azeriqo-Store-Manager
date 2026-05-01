<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Display a listing of the workers.
     */
    public function index(Request $request)
    {
        // Based on your DB trace, workers are stored in the users table with a role
        $query = User::where('role', 'worker');

        // Apply Search Filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Apply Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Fetch paginated results (10 per page) instead of ->get()
        $workers = $query->latest()->paginate(10);

        return view('pages.workers', compact('workers'));
    }

    /**
     * Show the form for creating a new worker.
     */
    public function create()
    {
        return view('pages.input');
    }

    /**
     * Store a newly created worker in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'worker',
            'status' => 'active',
        ]);

        return redirect()->route('workers.index')->with('success', 'Worker created successfully.');
    }

    /**
     * Show the form for editing the specified worker.
     */
    public function edit(User $worker)
    {
        return view('pages.input', compact('worker'));
    }

    /**
     * Update the specified worker in storage.
     */
    public function update(Request $request, User $worker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $worker->id,
        ]);

        $worker->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status ?? $worker->status,
        ]);

        return redirect()->route('workers.index')->with('success', 'Worker updated successfully.');
    }

    /**
     * Remove the specified worker from storage.
     */
    public function destroy(User $worker)
    {
        $worker->delete();
        return redirect()->route('workers.index')->with('success', 'Worker deleted successfully.');
    }
}