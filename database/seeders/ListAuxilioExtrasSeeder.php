<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListAuxilioExtrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Auxilio de alimentación', 'code' => '118'],
            ['name' => 'Auxilio educativo', 'code' => '615'],
            ['name' => 'Auxilio de celular', 'code' => '070'],
        ];

        DB::table('list_auxilio_extras')->insert($data);
    }
}
