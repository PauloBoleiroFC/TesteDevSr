<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert(
            [
                'name' => 'Miguel de Cervantes',
                'birth_date' => '	1981-10-21'
            ],
            [
                'name' => 'Charles Dickens',
                'birth_date' => '	1981-10-21'
            ],
            [
                'name' => 'J. K. Rowling',
                'birth_date' => '	1981-10-21'
            ],

        );
    }
}
