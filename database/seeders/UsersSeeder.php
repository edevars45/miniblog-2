<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'devarsesther@gmail.com',
                'name' => 'esther',
                'password' => '123456789',
                'role' => 'admin',
            ],
            [
                'email' => 'hello@miniblog.test',
                'name' => 'esther',
                'password' => '123456789',
                'role' => 'admin',
            ],
            [
                'email' => 'titi@mail.com',
                'name' => 'Titi Editor',
                'password' => 'titititi',
                'role' => 'editor',
            ],
            [
                'email' => 'tata@mail.com',
                'name' => 'Tata Author',
                'password' => 'tatatata',
                'role' => 'author',
            ],
            [
                'email' => 'tutu@mail.com',
                'name' => 'Tutu Author',
                'password' => 'tutututu',
                'role' => 'viewer',
            ],

            [
                'email' => 'toto@mail.com',
                'name' => 'Toto Author',
                'password' => 'totototo',
                'role' => 'admin',
            ],
        ];

        foreach ($users as $u) {
            $newUser = User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make($u['password']),
                    'email_verified_at' => now(),
                ]
            );

            // Requiert que les rôles existent déjà (Spatie)
            $newUser->syncRoles([$u['role']]);
        }
        // ⬇ Ajout : créer 6 articles rattachés à cet utilisateur
        Post::factory(10)->for($newUser)->create();
    }
}
