<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topic::create(['name' => 'General',]);
        Topic::create(['name' => 'Laravel',]);
        Topic::create(['name' => 'PHP',]);
        Topic::create(['name' => 'JavaScript',]);
        Topic::create(['name' => 'CSS',]);
        Topic::create(['name' => 'Python',]);
        Topic::create(['name' => 'Java',]);
    }
}
