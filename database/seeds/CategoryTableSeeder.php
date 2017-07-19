<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createCategory = new Category();
        $createCategory->name = '技术';
        $createCategory->save();

        $createCategory = new Category();
        $createCategory->name = '错误';
        $createCategory->save();

        $createCategory = new Category();
        $createCategory->name = '销售';
        $createCategory->save();
    }
}
