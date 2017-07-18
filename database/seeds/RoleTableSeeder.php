<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = new Role();
        $adminRole->display_name = '超级管理员';
        $adminRole->name = 'admin';
        $adminRole->description = '超级管理员角色';
        $adminRole->save();

        $moderatorRole = new Role();
        $moderatorRole->display_name = '管理组';
        $moderatorRole->name = 'Moderator';
        $moderatorRole->description = '管理组角色';
        $moderatorRole->save();

        $agentRole = new Role();
        $agentRole->display_name = '对账组';
        $agentRole->name = 'check';
        $agentRole->description = '对账组角色';
        $agentRole->save();
    }
}
