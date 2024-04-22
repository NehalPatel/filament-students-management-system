<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Stream;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        $bba = Stream::create([
            'name' => 'Bachelor of Business Administration(BBA)',
            'short_name' => 'BBA'
        ]);

        foreach( range('A', 'C') as $division) {
            Division::create([
                'stream_id'=>$bba->id,
                'name' => $division
            ]);
        }

        $bca = Stream::create([
            'name' => 'Bachelor of Computer Aplication(BCA)',
            'short_name' => 'BCA'
        ]);

        foreach( range('A', 'J') as $division) {
            Division::create([
                'stream_id'=>$bca->id,
                'name' => $division
            ]);
        }

        $bcom = Stream::create([
            'name' => 'Bachelor of Commerce(BCom)',
            'short_name' => 'BCom'
        ]);

        foreach( range('A', 'C') as $division) {
            Division::create([
                'stream_id'=>$bcom->id,
                'name' => $division
            ]);
        }

        // $this->call([
        //     //StreamSeeder::class,
        // ]);
    }
}
