<?php
namespace App\Repositories\Eloquents;

use App\Models\Group;
use App\Models\Role;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;

class GroupRepository extends EloquentRepository implements GroupRepositoryInterface {
    public function getModel()
    {
        return Group::class;
    }

    public function restore($id)
    {
        
    }

    public function forceDelete($id)
    {
        $group = $this->model->withTrashed()->findOrFail($id);
        if ($group) {
            $group->roles()->detach(); // Xóa quan hệ với các bản ghi khác
            return $group->delete(); // Thực hiện xóa cứng
        }
        return false;
    }
    public function detail($id)
    {
        $group = Group::find($id);
        $userRoles = $group->roles->pluck('id','name')->toArray();
        $roles = Role::all()->toArray();
        $group_name = [];

        //laays ten nhom quyen
        foreach($roles as $role) {
            $group_names[$role['group_name']][] = $role;
        }
        $params =
            [
                'group' => $group,
                'useRoles' => $userRoles,
                'roles' => $roles,
                'group_names' => $group_names
            ];
            return $params;
    }
    public function save_roles($id,$request)
    {
        $group = Group::find($id);
        $group->roles()->detach();
        $group->roles()->attach($request->roles);
        return true;
    }


}
