<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 200)->create()->each(function ($product){
            /* Tags */
            // mỗi product sẽ có từ 1 đến 3 tag,
            // giá trị tag là id (từ 1 đến 50, do mình tạo ở DatabaseSeeder)
            $arr = [];
            for ($i = 0; $i <= rand(0, 2); $i++){
                if($i == 0){
                    $arr[] = rand(1, 15);
                }
                if($i == 1){
                    $arr[] = rand(16, 35);
                }
                if($i == 2){
                    $arr[] = rand(36, 50);
                }
            }
            // Dòng này muốn chạy cần cho seeder tags chạy trước
            $product->tags()->sync($arr);

            /*
            // -------Orders-------
            // Mỗi product có thể có từ 1 đến 3 order (thuộc 1 đến 50 chọn ra 3 cái)
            // Và đi kèm theo là số lượng hàng quantity của mỗi đơn hàng order
            $arr = [];
            // $arr[14] = ['quantity' => 69]
            //  (order_id) -> mà cái này là random, nên sẽ có tr hợp k dính!
            for ($i = 0; $i <= rand(0, 2); $i++){
                if($i == 0){
                    $arr[rand(1, 15)] = ['quantity' => rand(1, 99)];
                }
                if($i == 1){
                    $arr[rand(16, 35)] = ['quantity' => rand(1, 99)];
                }
                if($i == 2){
                    $arr[rand(36, 50)] = ['quantity' => rand(1, 99)];
                }
            }
            $product->orders()->sync($arr);
             */
        });
    }
}
