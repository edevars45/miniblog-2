<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserRoleController;
// use App\Http\Controllers\Admin\RoleController;

/** FRONT (public) */
// Accueil (liste publique)
Route::get('/', [PostController::class, 'publicIndex'])->name('home');

// Liste publique + détail par slug
Route::get('/posts', [PostController::class, 'publicIndex'])->name('posts.public');
// Détail public par SLUG
Route::get('/posts/{post:slug}', [PostController::class, 'publicShow'])->name('posts.public.show');

/** BACK (privé) */
Route::prefix('dashboard')
    ->name('posts.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/posts', [PostController::class, 'index'])->name('index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('create')
            ->middleware('permission:posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('store')
            ->middleware('permission:posts.create');

        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('destroy');

        Route::post('/posts/{post}/publish', [PostController::class, 'publish'])->name('publish')
            ->middleware('permission:posts.publish');
        Route::post('/posts/{post}/unpublish', [PostController::class, 'unpublish'])->name('unpublish')
            ->middleware('permission:posts.publish');
    });

//groupe admin (autorisé aux admins ou aux détenteurs de `users.manage`) :
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'permission:users.manage']) // ou 'role:admin'
    ->group(function () {
        // Gestion des rôles assignés aux utilisateurs
        Route::get('users', [UserRoleController::class, 'index'])->name('users.index');
        Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])->name('users.roles.edit');
        Route::put('users/{user}/roles', [UserRoleController::class, 'update'])->name('users.roles.update');

        // (optionnel) CRUD simple des rôles
        // Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        // Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
        // Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

/** Dashboard / Profil / Admin / Auth */
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', fn() => 'Zone admin : accès réservé')
    ->middleware(['auth', 'role:admin'])->name('admin.home');

require __DIR__ . '/auth.php';
