<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Size;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'              => 'DOG FOOD',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'             => 'CAT FOOD',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
           
        ];

        $sizes = [
            [
                'name'              => 'M',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'              => 'L',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'              => 'XL',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
           
        ];

        Size::insert($sizes);
        Category::insert($categories);
    }
}
