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
    public function paginate($limit,$request=null)
    {
        $query = $this->model->query(true);
        if($request->search){
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $query->orderBy('id','desc');
        $items = $query->paginate($limit);
        return $items;
    }

    public function trash($limit,$request)
    {
        $query = $this->model->onlyTrashed();

        if ($request->searchName != null) {
            $query->where('name', 'LIKE', '%' . $request->searchName . '%');
        }


         
        return $query->paginate($limit);
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
