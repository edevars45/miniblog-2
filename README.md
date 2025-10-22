# README — MiniPress (Laravel 12 + Breeze + Spatie)

## Objectifs

MiniPress est une mini-application de blog pour apprendre :

- l’authentification avec Breeze,
- les rôles & permissions avec Spatie,
- les Policies Laravel (autorisations par ressource),
- un CRUD simple d’articles (Post) + publication.


## Prérequis

- PHP ≥ 8.2, Composer 2.x
- Node ≥ 18, npm ≥ 9
- Base de données (MySQL/MariaDB ou SQLite)
- Laravel 12.x


## Installation (depuis zéro)

```bash
# 1) Projet
composer create-project laravel/laravel:"^12.0" minipress
cd minipress
cp .env.example .env
php artisan key:generate

# 2) DB (ex. SQLite)
mkdir -p database && touch database/database.sqlite
# .env :
# DB_CONNECTION=sqlite
# DB_DATABASE=./database/database.sqlite

# 3) Migrations par défaut
php artisan migrate

# 4) Breeze (auth Blade + Tailwind)
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run dev  # laissez tourner
php artisan migrate

# 5) Spatie Permission
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

## Seed des rôles et permissions

- `database/seeders/RolesAndPermissionsSeeder.php` crée :
    - Rôles : _admin_, _editor_, _author_, _viewer_
    - Permissions : _posts.view_, _posts.create_, _posts.edit_, _posts.delete_, _posts.publish_, _users.manage_

- `database/seeders/UsersSeeder.php` crée :
    - Utilisateurs : _toto_, _titi_, _tata_, _tutu_.

- `database/seeders/DatabaseSeeder.php` :
    - appelle `RolesAndPermissionsSeeder`,
    - appelle `UsersSeeder`

Exécuter :

```bash
php artisan migrate --seed
```

### Identifiants de test

Les utilisateurs suivants sont créés par les seeders :

- toto (rôle _admin_): 
    - mail: toto@mail.com
    - pass: totototo
- titi (rôle _editor_): 
    - mail: titi@mail.com
    - pass: titititi
- tata (rôle _author_): 
    - mail: tata@mail.com
    - pass: tatatata
- tutu (rôle _viewer_): 
    - mail: tutu@mail.com
    - pass: tutututu

## Lancement

Pour le back :

```
php artisan serve
```

Pour le front  en parallèle :
```
npm run dev
```

Les pages disponibles sont les suivantes :
- Page publique (liste des articles publiés) : `/`
- Auth : `/login`, `/register`
- Dashboard : `/dashboard`
- Gestion des posts (dashboard) : `/dashboard/posts`
- Admin rôles utilisateurs : `/admin/users`


## Fonctionnalités pédagogiques

- **Posts :**
    - Attributs : `title`, `slug` (unique), `body`, `status` (`draft`|`published`), `published_at`, `user_id`.
    - Page publique de lecture : `/posts/{slug}`
    - Policy `view` : public si `published`, sinon auteur/éditeur/admin.
    - Dashboard : création/édition/suppression, publication/dépublication.
    - Permissions utilisées :
        - `posts.create`, `posts.edit`, `posts.delete`, `posts.publish`.

- **Rôles et Permissions (Spatie) :**
    - Stockées dans `roles`, `permissions`, `model_has_roles`, `role_has_permissions`, `model_has_permissions`.
    - Lien user <-> rôles via la pivot `model_has_roles`.

- **Policies :**
    - `PostPolicy` : `create`, `update`, `delete`, `publish`, `view`.
    - Utilisation via `$this->authorize(...)`, `@can(...)`, middleware `can:`.


## Navigation et liens utiles

- Accueil public : `route('home')`
- Voir un article public : `route('posts.public.show', $post->slug)`
- Dashboard posts : `route('posts.index')`
- Espace admin : `route('admin.home')` -> redirige vers `admin.users.index`


## Mémo de commandes (cheat-sheet)

```
# Générations
php artisan make:model Post -mfcr        # modèle + migration + factory + controller resource
php artisan make:policy PostPolicy --model=Post
php artisan make:controller Admin/UserRoleController
php artisan make:controller Admin/RoleController

# Migrations / seed
php artisan migrate
php artisan migrate:status
php artisan migrate:fresh --seed          # ATTENTION : vide la base

# Cache & autoload
php artisan optimize:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
composer dump-autoload

# Spatie : reset du cache d'autorisations
php artisan permission:cache-reset

# Vérifier les rôles d’un user (Tinker)
php artisan tinker
>>> \App\Models\User::first()->getRoleNames();
```

## Dépannage (FAQ rapide)

### `No publishable resources` lors de `vendor:publish`

- Vérifiez l’installation : `composer show spatie/laravel-permission`

- Essayez sans tag :
`php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`

- Vérifiez que les fichiers existent :
    - `config/permission.php`
    - `database/migrations/xxxx_create_permission_tables.php`

- Si nécessaire, copiez les fichiers depuis `vendor/spatie/...` (plan B).

### `Call to undefined method ...Controller::authorize()`

- Assurez-vous que votre Controller de base utilise :
    ```php
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    class Controller extends BaseController { 
        use AuthorizesRequests; // <-- Utilisation du trait AuthorizesRequests
    }
    ```
- Et que vos contrôleurs étendent cette classe `Controller`.

### Conflits de base : SQLite vs MySQL

- Vérifiez `.env` : la base utilisée par l’appli et vos migrations/seed doit être la même.

- Si vous passez de SQLite à MySQL, relancez `migrate:fresh --seed`.


## Structure (Seulement des fichiers modifiés dans le tutoriel)

```
app/
    Http/
        Controllers/
            Admin/
                UserRoleController.php
            PostController.php
    Models/
        Post.php
    Policies/
        PostPolicy.php
database/
    factories/
        PostFactory.php
    seeders/
        DatabaseSeeder.php
        RolesAndPermissionsSeeder.php
resources/
    views/
        admin/
            users/
                edit-roles.blade.php
                index.blade.php
        layouts/
            navigation.blade.php
        posts/
            _form.blade.php
            create.blade.php
            edit.blade.php  
            index.blade.php
            public-index.blade.php
            public-show.blade.php
        dashboard.blade.php
```
