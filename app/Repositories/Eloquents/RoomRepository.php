<?php
namespace App\Repositories\Eloquents;

use App\Models\Room;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;

class RoomRepository extends EloquentRepository implements RoomRepositoryInterface {
    public function getModel()
    {
        return Room::class;
    }

    public function search($request)
    {
        $search = $request->input('search');
        if (!$search) {
            return Room::get();
        }
            return Room::where('name', 'LIKE', '%' . $search . '%')->paginate(2);       
    }

    public function trash()
    {
        return $this->model->onlyTrashed()->get();
    }

    public function restore($id)
    {
        return Room::withTrashed()->find($id)->restore();
    }

    public function forceDelete($id)
    {
        return $this->model->onlyTrashed()->find($id)->forceDelete();
            
    }
}
