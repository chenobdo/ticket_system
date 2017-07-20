<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createPermission = new Permission();
        $createPermission->display_name = '角色管理';
        $createPermission->name = 'manage-roles';
        $createPermission->description = '角色管理的权限';
        $createPermission->save();

        $createPermission = new Permission();
        $createPermission->display_name = '工单管理';
        $createPermission->name = 'manage-tickets';
        $createPermission->description = '工单管理的权限';
        $createPermission->save();

        $createPermission = new Permission();
        $createPermission->display_name = '用户管理';
        $createPermission->name = 'manage-users';
        $createPermission->description = '用户管理的权限';
        $createPermission->save();

        $createPermission = new Permission();
        $createPermission->display_name = '后台面板';
        $createPermission->name = 'view-backend';
        $createPermission->description = '后台面板的权限';
        $createPermission->save();

        $createPermission = new Permission();
        $createPermission->display_name = '权限管理';
        $createPermission->name = 'manage-permissions';
        $createPermission->description = '权限管理的权限';
        $createPermission->save();

        $createPermission = new Permission();
        $createPermission->display_name = '配置管理';
        $createPermission->name = 'manage-settings';
        $createPermission->description = '配置管理的权限';
        $createPermission->save();

        $createPermission = new Permission();
        $createPermission->display_name = '对账管理';
        $createPermission->name = 'manage-check';
        $createPermission->description = '对账管理的权限';
        $createPermission->save();

        $createPermission = new Permission();
        $createPermission->display_name = '客户管理';
        $createPermission->name = 'manage-clients';
        $createPermission->description = '客户管理的权限';
        $createPermission->save();
    }
}
