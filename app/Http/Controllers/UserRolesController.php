<?php

namespace App\Http\Controllers;

use App\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class UserRolesController extends Controller
{
    public function index()
    {
        $this->authorize('manage-roles-and-permissions');

        $users = User::with('roles')->get();

        $roles = Role::all();

        $activities = Activity::inLog('user-roles')->take(50)->latest()->get();

        return view('permissions.index', compact('users', 'roles', 'activities'));
    }

    public function assign(User $user, Role $role)
    {
        $this->authorize('manage-roles-and-permissions');

        $user->assignRole($role);

        $activity = activity('user-roles')
            ->performedOn($user)
            ->withProperties([
                'role_id' => $role->id,
                'role_name' => $role->name,
            ])
            ->log(':causer.name assigned the :properties.role_name role to :subject.name');

        return [
            'activity' => $activity,
        ];
    }

    public function remove(User $user, Role $role)
    {
        $this->authorize('manage-roles-and-permissions');

        $user->removeRole($role);

        $activity = activity('user-roles')
            ->performedOn($user)
            ->withProperties([
                'role_id' => $role->id,
                'role_name' => $role->name,
            ])
            ->log(':causer.name removed the :properties.role_name role from :subject.name');

        return [
            'activity' => $activity,
        ];
    }
}
