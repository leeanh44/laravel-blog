<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'GitLee',
            'email' => 'it.leanh@gmail.com',
            'password' => bcrypt('it.leanh@gmail.com')
        ]);

        Post::factory(5)->create([
            'user_id' => $user->id
        ]);
    }
}
