<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Stream;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class StreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stream::factory()
            ->count(10)
            ->sequence(fn($sequence) => ['name' => 'Stream ' . $sequence->index + 1])
            ->has(
                Division::factory()
                    ->count(2)
                    ->state(
                        new Sequence(
                            ['name' => 'Division A'],
                            ['name' => 'Division B'],
                        )
                    )
                    ->has(
                        Student::factory()
                            ->count(5)
                            ->state(
                                function (array $attributes, Division $section) {
                                    return ['stream_id' => $section->stream_id];
                                }
                            )
                    )
            )
            ->create();
    }
}
