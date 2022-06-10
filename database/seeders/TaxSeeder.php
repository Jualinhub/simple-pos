<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::create([
            'name' => 'PPN',
            'percent' => 11
        ]);

        Tax::create([
            'name' => 'PPh 23',
            'percent' => 3
        ]);
    }
}
