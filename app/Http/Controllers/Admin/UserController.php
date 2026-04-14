<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalActive = User::where('is_active', true)->count();

        $usersByRole = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();

        $recentActivity = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalActive',
            'usersByRole',
            'recentActivity'
        ));
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->appends($request->query());
        $totalActive = User::where('is_active', true)->count();

        return view('admin.users', compact('users', 'totalActive'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,staff_gudang,staff_logistik',
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'users',
            'description' => "Membuat user baru: {$user->name} ({$user->role})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.users')
            ->with('success', "User {$user->name} berhasil dibuat.");
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,manager,staff_gudang,staff_logistik',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'users',
            'description' => "Mengupdate user: {$user->name}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.users')
            ->with('success', "User {$user->name} berhasil diupdate.");
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'module' => 'users',
            'description' => "Menghapus user: {$userName}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "User {$userName} berhasil dihapus.");
    }
}
