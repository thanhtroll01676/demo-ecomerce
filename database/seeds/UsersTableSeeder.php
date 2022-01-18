<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // tạo 1 record theo ý mình
        $user = User::create([
            'name'  =>  'Ngoc Thien',
            'email' =>  'ngocthienk61@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user->roles()->sync([1,1]); // array of role ids
        $user1 = User::create([
            'name'  =>  'Nam Nhi',
            'email' =>  'namnhi@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user1->roles()->sync([1,1]); // array of role ids
        $user2 = User::create([
            'name'  =>  'Văn Bách',
            'email' =>  'vanbach@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user2->roles()->sync([1,1]); // array of role ids
        $user3 = User::create([
            'name'  =>  'Trần Thành',
            'email' =>  'tranthanh@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user3->roles()->sync([1,1]); // array of role ids
        $user4 = User::create([
            'name'  =>  'Đức Tài',
            'email' =>  'ductai@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user4->roles()->sync([1,1]);
        $user5 = User::create([
            'name'  =>  'Minh Tuấn',
            'email' =>  'minhtuan@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user5->roles()->sync([1,1]); // array of role ids // array of role ids
        $user6 = User::create([
            'name'  =>  'Văn Thành',
            'email' =>  'vanthanh@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user6->roles()->sync([1,1]); // array of role ids
        $user7 = User::create([
            'name'  =>  'Linh Nhi',
            'email' =>  'linhnhi@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user7->roles()->sync([1,1]); // array of role ids
        $user8 = User::create([
            'name'  =>  'Quang Định',
            'email' =>  'quangdinh@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user8->roles()->sync([1,1]); // array of role ids
        $user9 = User::create([
            'name'  =>  'Đức Thái',
            'email' =>  'ducthai@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user9->roles()->sync([1,1]); // array of role ids
        $user10 = User::create([
            'name'  =>  'Quang Học',
            'email' =>  'quanghoc@gmail.com',
            'password'  =>  bcrypt('123456'),
            'remember_token' => str_random('10'),
        ]);
        $user10->roles()->sync([1,1]); // array of role ids
        //factory(User::class, 50)->create();
    }
}
