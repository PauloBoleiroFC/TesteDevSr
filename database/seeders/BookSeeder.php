<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert(
            [
                'title' => 'Dom Quixote',
                'year' => '1612'
            ],
            [
                'title' => 'Um Conto de Duas Cidades',
                'year' => '1859'
            ],
            [
                'title' => 'O Senhor dos Anéis',
                'year' => '1954'
            ],
            [
                'title' => 'O Pequeno Príncipe',
                'year' => '1943'
            ],
            [
                'title' => 'Harry Potter e a Pedra Filosofal',
                'year' => '1997'
            ],
        );
    }
}
