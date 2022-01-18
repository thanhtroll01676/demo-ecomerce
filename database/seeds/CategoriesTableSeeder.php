<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // tạo 1 record theo ý mình
        // "Không thuộc chuyên mục nào" có id = 1
        Category::create([
            'name'  =>  'Uncategorized',
            'slug' =>  'uncategorized',
            'order'  =>  0,
            'parent' => 0,
        ]);

        // Tạo 50 cái mẫu, cấu hình ở file ModelFactory.php
//        factory(Category::class, 50)->create();

        /* Tạo cái khác, có ý nghĩa hơn */
        //        Đồ đồng cao cấp - có id = 2
        $m = Category::create([
            'name' => 'Bộ bàn ghế cao cấp gỗ đinh hương',
            'slug' => str_slug('Bộ bàn ghế cao cấp gỗ đinh hương'),
            'order' => 0,
            'parent' => 0
        ]);

        Category::create([
            'name' => 'Tủ gỗ gỗ dổi',
            'slug' => str_slug('Tủ gỗ gỗ dổi'),
            'order' => 0,
            'parent' => $m->id
        ]);

        Category::create([
            'name' => 'Kệ,Đồ thờ gỗ cao cấp',
            'slug' => str_slug('Kệ,Đồ thờ gỗ cao cấp'),
            'order' => 1,
            'parent' => $m->id
        ]);

        Category::create([
            'name' => 'Quà tặng gỗ cao cấp',
            'slug' => str_slug('Quà tặng gỗ cao cấp'),
            'order' => 2,
            'parent' => $m->id
        ]);
        //Đồ đồng phong thủy
        $t = Category::create([
            'name' => 'Đồ gỗ phong thủy',
            'slug' => str_slug('Đồ gỗ phong thủy'),
            'order' => 1,
            'parent' => 0
        ]);

        Category::create([
            'name' => 'Bộ bàn ghế đồ gỗ phong thuỷ',
            'slug' => str_slug('Bộ bàn ghế đồ gỗ phong thuỷ'),
            'order' => 0,
            'parent' => $t->id
        ]);

        Category::create([
            'name' => 'Giường,Tủ gỗ mỹ nghệ cao cấp',
            'slug' => str_slug('Giường,Tủ gỗ mỹ nghệ cao cấp'),
            'order' => 1,
            'parent' => $t->id
        ]);

        // Đồ đồng quà tặng
        $l = Category::create([
            'name' => 'Đồ gỗ quà tặng',
            'slug' => str_slug('Đồ gỗ quà tặng'),
            'order' => 2,
            'parent' => 0
        ]);

        Category::create([
            'name' => 'Đồ gỗ đúc nguyên khối',
            'slug' => str_slug('Đồ gỗ đúc nguyên khối'),
            'order' => 0,
            'parent' => $l->id
        ]);

        Category::create([
            'name' => 'Bộ bàn ghế ăn cao cấp',
            'slug' => str_slug('Bộ bàn ghế ăn cao cấp'),
            'order' => 1,
            'parent' => $l->id
        ]);

        // Đồ thờ bằng đồng
        $ac= Category::create([
            'name' => 'Đồ thờ bằng gỗ tinh xảo',
            'slug' => str_slug('Đồ thờ bằng gỗ tinh xảo'),
            'order' => 3,
            'parent' => 0
        ]);

        Category::create([
            'name' => 'Bát hương gỗ cao cấp',
            'slug' => str_slug('Bát hương gỗ cao cấp'),
            'order' => 0,
            'parent' => $ac->id
        ]);

        Category::create([
            'name' => 'Tranh gỗ',
            'slug' => str_slug('Tranh gỗ'),
            'order' => 1,
            'parent' => $ac->id
        ]);

        Category::create([
            'name' => 'Đồ gỗ tinh xảo',
            'slug' => str_slug('Đồ gỗ tinh xảo'),
            'order' => 2,
            'parent' => $ac->id
        ]);

        Category::create([
            'name' => 'Đài thờ bằng gỗ tinh xảo',
            'slug' => str_slug('Đài thờ bằng gỗ tinh xảo'),
            'order' => 3,
            'parent' => $ac->id
        ]);
        Category::create([
            'name' => 'Đèn thờ bằng gỗ',
            'slug' => str_slug('èn thờ bằng gỗ'),
            'order' => 3,
            'parent' => $ac->id
        ]);
        Category::create([
            'name' => 'Đỉnh đồng bằng gỗ',
            'slug' => str_slug('Đỉnh đồng bằng gỗ'),
            'order' => 3,
            'parent' => $ac->id
        ]);
        Category::create([
            'name' => 'Hạc thờ bằng gỗ tinh xảo',
            'slug' => str_slug('Hạc thờ bằng gỗ'),
            'order' => 3,
            'parent' => $ac->id
        ]);
        Category::create([
            'name' => 'Tranh gỗ tinh xảo',
            'slug' => str_slug('Tranh gỗ tinh xảo'),
            'order' => 3,
            'parent' => $ac->id
        ]);
        Category::create([
            'name' => 'Kệ gỗ giá rẻ',
            'slug' => str_slug('Kệ gỗ giá rẻ'),
            'order' => 3,
            'parent' => $ac->id
        ]);
        // Tranh đồng
        Category::create([
            'name' => 'Tranh gỗ kiệt tác',
            'slug' => str_slug('Tranh gỗ kiệt tác'),
            'order' => 4,
            'parent' => $ac->id
        ]);
    }
}
