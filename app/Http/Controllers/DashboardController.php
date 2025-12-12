<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostra o dashboard baseado no role do usuário
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin', compact('user'));
            case 'technician':
                return view('dashboard.technician', compact('user'));
            case 'client':
                return view('dashboard.client', compact('user'));
            default:
                return view('dashboard', compact('user'));
        }
    }
}
