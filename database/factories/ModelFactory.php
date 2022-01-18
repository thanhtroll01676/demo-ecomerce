<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    $name = $faker->name;
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'order' => rand(-100, 100),
        'parent' => 0,
    ];
});

$factory->define(App\Tag::class, function(Faker\Generator $faker){
    $name = $faker->name;
    return [
        'name' => str_slug($name),
        'slug' => str_slug($name)
    ];
});

$factory->define(App\Order::class, function(Faker\Generator $faker){
    return [
        'user_id' => rand(1, 8),
        'name' => $faker->name,
        'address' => $faker->text(80),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {

    $random_productName = Array("Bộ bàn ghế mỹ nghệ","Bộ tủ,kệ bằng gỗ cao cấp",
        "Cuốn thư câu đối bằng bằng gỗ",
        "Bộ giường gỗ cao cấp",
        "Tranh gỗ cao cấp",
        "Bộ bàn gỗ đinh hương cao cấp"
    );
    $random_productImage = Array(
        "2022-01/1b5159b9164e6315bd3dba3831deeb15.jpg",
        "2022-01/8cbf8da579b54fcea4ee308b3c1e996d.jpg",
        "2022-01/11f83c2c32af08c1d659fae15de1227c.jpg",
        "2022-01/24ba8963d13f8f06f17dba3c4b5c2709.jpg",
        "2022-01/85e94d5f820fd3e12b90abb777b7a844.jpg",
        "2022-01/789d9ee07b08ed50136da47faa19b279.jpg",
        "2022-01/2171b51ff00b59ebff51595d60044155.jpg",
        "2022-01/67345f468ac35ccd6cdfd1c2f99a53db.jpg",
        "2022-01/ab8f1d3467580ee451922f62e062cb41.jpg",
        "2022-01/b7a1bd5ebee53958444021d66f65a703.jpg",
        "2022-01/dbeb7aae38aab53f5c4e584e8c42be9b.jpg",
        "2022-01/f03da6045df269938b2a3029c227dbf8.jpg"
    );
    $random_productContent = Array(
        "Vật liệu gỗ có tính xốp, vừa mềm vừa cứng. ... Độ bền kéo và nén của gỗ dọc thớ cao hơn, nhưng độ bền kéo và nén của thớ ngang thấp hơn. Độ bền của gỗ cũng thay đổi theo loài cây và bị ảnh hưởng bởi các khuyết tật của gỗ, thời gian chịu tải, độ ẩm và nhiệt độ",
        "Gỗ đinh hương là loại gỗ rất được nhiều người ưa chuộng rộng rãi trên thị trường hiện nay. Gỗ đinh hương là gỗ nằm trong top 4 loại gỗ chất lượng ở Việt Nam đó là lim – đinh – sến – táu và chúng có mầu đỏ vàng đặc trưng, tựa như gỗ hương nhưng thật chất chúng là hai loại gỗ khác nhau. Chúng là loại gỗ có mùi hương dịu nhẹ do dầu gỗ tiết ra"
    );
    return [
        'name' => $random_productName[array_rand($random_productName)],
        'code' => strtoupper(str_random(6)),
        'content' => $random_productContent[array_rand($random_productContent)],
        'regular_price' => rand(1500000, 3000000),
        'sale_price' => rand(1200000, 2000000),
        'original_price' => rand(100000, 1000000),
        'quantity' => rand(1, 100),
        'attributes' => '',
        'image' => $random_productImage[array_rand($random_productImage)],
        'user_id' => rand(1, 8),
//        'category_id' => rand(1, 50),

        // các chuyên mục có sẵn có id từ 1 -> 21
        // các sản phẩm mẫu chỉ có thể có category_id khác (2, 7, 12, 16)
        // Vì sao? Vì category có id là (2, 7, 12, 16) rất chung chung,
        // Xem thêm bên CategoriesTableSeeder.php
        'category_id' => ! in_array($category_id = rand(1, 21), [2, 7, 12, 16]) ? $category_id : 1,
    ];
});
