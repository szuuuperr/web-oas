<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('module') && $request->module !== 'all') {
            $query->where('module', $request->module);
        }

        if ($request->filled('action') && $request->action !== 'all') {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(20)->appends($request->query());

        $modules = ActivityLog::distinct()->pluck('module')->filter()->values();
        $actions = ['create', 'update', 'delete', 'approve', 'reject'];

        $totalLogs = ActivityLog::count();
        $users = \App\Models\User::where('is_active', true)->orderBy('name')->get();
        $todayUsers = ActivityLog::whereDate('created_at', today())->distinct()->count('user_id');

        return view('admin.logs', compact('logs', 'modules', 'actions', 'totalLogs', 'users', 'todayUsers'));
    }
}
