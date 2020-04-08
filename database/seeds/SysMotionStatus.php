<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysMotionStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sys_motion_status')->insert([
            'id' => 4,
            'name' => 'Подтверждено',
        ]);
    }
}
