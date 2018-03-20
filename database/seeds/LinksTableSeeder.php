<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('links')->insert([
            'link_name' => '后盾网',
            'link_title' => '后盾网，人人做后盾',
            'link_url' => 'http://bbs/houdunwang.com',
            'link_order' => 2,
        ]);
    }
}
