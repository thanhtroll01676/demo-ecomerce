<?php

use Illuminate\Database\Seeder;
use App\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 50)->create()->each(function($order){
            // -------Orders-------
            // Mỗi order có thể có từ 1 đến 3 product (thuộc 1 đến 50 chọn ra 3 cái)
            // Và đi kèm theo là số lượng hàng quantity của mỗi đơn hàng order
            $arr = [];
            // $arr[14] = ['quantity' => 69]
            //  (product_id) -> cái này là random
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
            // Dòng này muốn chạy cần cho seeder product chạy trước
            $order->products()->sync($arr);
        });
    }
}
