<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo các role mẫu
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Người quản trị',
            'description' => 'Quản trị hệ thống'
        ]);
        $writer = Role::create([
            'name' => 'writer',
            'display_name' => 'Người quản lý bài viết',
            'description' => 'Quản trị bài viết bên trong hệ thống'
        ]);
        $seller = Role::create([
            'name' => 'seller',
            'display_name' => 'Người bán',
            'description' => 'Quản trị đơn hàng'
        ]);
        $buyer = Role::create([
            'name' => 'buyer',
            'display_name' => 'Khách hàng',
            'description' => 'Người mua hàng ở website của ta'
        ]);

        // Tạo các permission mẫu
        $createUser = Permission::create([
            'name' => 'create-user',
            'display_name' => 'Tạo user'
        ]);
        $editUser = Permission::create([
            'name' => 'edit-user',
            'display_name' => 'Sửa user'
        ]);
        $deleteUser = Permission::create([
            'name' => 'delete-user',
            'display_name' => 'Xóa user'
        ]);
        $uploadFile = Permission::create([
            'name' => 'upload-file',
            'display_name' => 'Tải file/ảnh lên hệ thống'
        ]);

        // Assign cho role (các) permission
        $admin->attachPermissions(array($createUser, $editUser, $deleteUser, $uploadFile));
    }
}
