<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 100; $i++) {
            DB::table('tasks')->insert([
                'content' => 'タスク' . $i,
                'status' => '未達' . $i
            ]);
        }
    }
}
