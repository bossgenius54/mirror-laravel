<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysPositionStatusAddSold extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sys_position_status')->insert([
            'id' => 7,
            'name' => 'Продано',
        ]);
    }
}
