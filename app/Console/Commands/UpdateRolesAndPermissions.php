<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jtg:update-roles-and-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $role_abilities = [
            'Member' => [
                'view-forum',
                'view-giving',
            ],

            'Responder' => [
                'respond-to-chatters',
            ],

            'Admin' => [
                'view-forum',
                'view-giving',
                'respond-to-chatters',
                'manage-events',
                'manage-series',
                'manage-roles-and-permissions',
            ]
        ];

        foreach ($role_abilities as $role => $abilities) {
            $role = Role::firstOrCreate(['name' => $role]);
            foreach ($abilities as $ability) {
                $permission = Permission::firstOrCreate(['name' => $ability]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
