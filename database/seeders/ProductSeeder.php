<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSizePrice;

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
                'id'              => '1',
                'image'           => 'p1.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '2',
                'image'           => 'p2.png',
                'name'            => 'Sample Product',
                'category_id'     => '2',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '3',
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '4',
                'image'           => 'p1.png',
                'name'            => 'Sample Product',
                'category_id'     => '2',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '5',
                'image'           => 'p2.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '6',
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '7',
                'image'           => 'p2.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '8',
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2023-09-21',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '9',
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2022-10-06',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '10',
                'image'           => 'p2.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2022-11-06',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [   
                'id'              => '11',
                'image'           => 'p3.png',
                'name'            => 'Sample Product',
                'category_id'     => '1',
                'description'     => 'This is sample product',
                'expiration'      => '2022-12-06',
                'price'           => '150',
                'stock'           => '50',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],


            

        ];

     
        
        Product::insert($products);
    }
}
