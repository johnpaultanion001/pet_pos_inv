<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [   
                'image'           => 'p1.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'unit_price'           => '100',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p2.png',
                'name'            => 'Sample Product',
                'category_id'     => '2',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'unit_price'           => '115',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p1.png',
                'name'            => 'Sample Product',
                'category_id'     => '2',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p2.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p2.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-02-28',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p2.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-03-28',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'image'           => 'p3.png',
                'name'            => 'Sample Products',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-04-28',
                'unit_price'           => '115',
                'retailed_price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],


            

        ];

     
        
        Product::insert($products);
    }
}
