<?php
namespace App\Repositories\Eloquents;

use App\Models\Device;
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Support\Facades\Storage;
class DeviceRepository extends EloquentRepository implements DeviceRepositoryInterface
{
    public function getModel()
    {
        return Device::class;
    }

    /*
    - Do PostRepository đã kế thừa EloquentRepository nên không cần triển khai
    các phương thức trừu tượng của PostRepositoryInterface
    - Có thể ghi đè phương thức ở đây
    - Nếu muốn thêm phương thức mới cần:
        + Khai báo thêm ở PostRepositoryInterface
        + Triển khai lại ở đây
    - Ví dụ: paginate() không có sẵn trong RepositoryInterface, để thêm chúng ta thêm:
        + Khai báo paginate() ở PostRepositoryInterface
        + Triển khai lại ở PostRepository
    */
    public function paginate($limit,$request=null)
    {
        $query = $this->model->query(true);
        if($request->searchName){
            $query->where('name', 'LIKE', '%' . $request->searchName . '%');
        }
        if($request->searchQuantity){
            $query->where('quantity', 'LIKE', '%' . $request->searchQuantity . '%');
        }
        $query->orderBy('id','desc');
        $items = $query->paginate($limit);
        return $items;
    }

    public function store($data)
    {
        if( isset( $data['image']) && $data['image']->isValid() ){
            $path = $data['image']->store('public/devices');
            $url = Storage::url($path);
            $data['image'] = $url;
        }
        return $this->model->create($data);
    }

    public function update($id,$data)
    {
         if( isset( $data['image']) && $data['image']->isValid() ){
            $path = $data['image']->store('public/devices');
            $url = Storage::url($path);
            $data['image'] = $url;
        }    
        return $this->model->where('id',$id)->update($data);
    }

    public function trash()
    {
        $result = $this->model->onlyTrashed()->get();
        return $result;
    }
    public function restore($id)
    {
        $result = $this->model->withTrashed()->find($id)->restore();
        return $result;
    }

    public function forceDelete($id)
    {
        // try {

            $result = $this->model->onlyTrashed()->find($id);
            $result->forceDelete();
            return $result;

    }
    
}