<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    // Liste des utilisateurs avec leurs rôles
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // Formulaire d’édition des rôles d’un utilisateur
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        $userRoleNames = $user->getRoleNames()->toArray();

        return view('admin.users.edit-roles', compact('user', 'roles', 'userRoleNames'));
    }

    // Sauvegarde : on remplace les rôles par la sélection (assigner/retirer)
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'roles' => ['array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user->syncRoles($data['roles'] ?? []);
        
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Rôles mis à jour pour {$user->name}.");
    }
}