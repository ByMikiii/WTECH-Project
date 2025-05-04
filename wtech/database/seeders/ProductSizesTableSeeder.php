<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $products = DB::table('products')->get();

    foreach ($products as $product) {
      $sizes = [36, 38, 39, 40, 41, 42, 43, 44];

      foreach ($sizes as $size) {
        DB::table('product_sizes')->insert([
          'product_id' => $product->id,
          'size' => $size,
          'stock' => rand(4, 12),
        ]);
      }
    }
  }
}
