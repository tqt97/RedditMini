<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory([
            'is_admin' => true,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'username' => 'Tu Quoc Tuan',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->create();
        \App\Models\User::factory(100)->create();
        $this->call(TopicSeeder::class);
        \App\Models\Community::factory(100)->create();
        \App\Models\Post::factory(100)->create();
        \App\Models\PostVote::factory(300)->create();
    }
}
