<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ConfigurationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalUsers = User::count();
        $recentUsers = User::latest()->take(5)->get();
        
        return view('configuration.index', compact('user', 'totalUsers', 'recentUsers'));
    }
    
    public function profile()
    {
        $user = Auth::user();
        
        return view('configuration.profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        return redirect()->route('configuration.profile')->with('success', 'Profil mis à jour avec succès.');
    }
    
    public function users()
    {
        $users = User::latest()->paginate(10);
        
        return view('configuration.users', compact('users'));
    }
    
    public function createUser()
    {
        return view('configuration.create-user');
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);
        
        return redirect()->route('configuration.users')->with('success', 'Utilisateur créé avec succès.');
    }
    
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        $user->delete();
        
        return redirect()->route('configuration.users')->with('success', 'Utilisateur supprimé avec succès.');
    }
    
    public function system()
    {
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => config('database.default'),
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug') ? 'Activé' : 'Désactivé',
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
        ];
        
        return view('configuration.system', compact('systemInfo'));
    }
}
