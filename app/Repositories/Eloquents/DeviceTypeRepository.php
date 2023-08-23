<?php
namespace App\Repositories\Eloquents;

use App\Models\DeviceType;
use App\Repositories\Interfaces\DeviceTypeRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;

class DeviceTypeRepository extends EloquentRepository implements DeviceTypeRepositoryInterface {
    public function getModel()
    {
        return DeviceType::class;
    }
    public function all($request = null)
    {
        $query = $this->model->select('*');

        if ($request->searchname) {
            $query->where('name', 'like', '%' . $request->searchname . '%');
        }
        if ($request->id) {
            $query->where('id', $request->id);
        }
        return $query->orderBy('id', 'DESC')->paginate(10);
    }

    public function trash()
    {
        return $this->model->onlyTrashed()->get();
    }
    public function restore($id)
    {
        return DeviceType::withTrashed()->find($id)->restore();
    }
    public function forceDelete($id)
    {
        return $this->model->onlyTrashed()->find($id)->forceDelete();

    }
}
