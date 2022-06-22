<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Reply;


class RepliesTableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        Reply::factory()->times(1000)->create();
    }
}

