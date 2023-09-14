<?php
namespace App\Repositories\Eloquents;

use App\Models\BorrowDevice;
use App\Repositories\Interfaces\BorrowDeviceRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Support\Facades\Storage;
class BorrowDeviceRepository extends EloquentRepository implements  BorrowDeviceRepositoryInterface
{
    public function getModel()
    {
        return BorrowDevice::class;
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
        $query = $this->model->with('device');
        // Thay đổi từ 'user_id' thành 'user.name'
        if ($request && $request->searchName) {
            $query->whereHas('device', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchName . '%');
            });
        }
        if($request->searchSession){
            $query->where('session', 'LIKE', '%' . $request->searchSession . '%');
        }
        if($request->searchQuantity){
            $query->where('quantity', 'LIKE', '%' . $request->searchQuantity . '%');
        }
        if ($request->searchTeacher) {
            $query->whereHas('borrow.user', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchTeacher . '%');
            });
        }
        if ($request->searchBorrow_date) {
            $query->whereHas('borrow', function ($query) use ($request) {
                $query->where('borrow_date', '=', $request->searchBorrow_date );
            });
        }

        if ($request->searchBorrow_date_to) {
            $query->whereHas('borrow', function ($query) use ($request) {
                $query->where('borrow_date','<=', $request->searchBorrow_date_to );
            });
        }

        if($request->searchStatus !== null){
            $query->where('status',$request->searchStatus);
        }
        if ($request->searchNest) {
            $query->whereHas('borrow.user', function ($query) use ($request) {
                $query->where('nest_id', $request->searchNest);
            });
        }

        $query->orderBy('id','desc');
        $items = $query->paginate($limit);
        return $items;
    }

    // public function store($data)
    // {
    //     if( isset( $data['image']) && $data['image']->isValid() ){
    //         $path = $data['image']->store('public/devices');
    //         $url = Storage::url($path);
    //         $data['image'] = $url;
    //     }
    //     return $this->model->create($data);
    // }

    // public function update($id,$data)
    // {
    //      if( isset( $data['image']) && $data['image']->isValid() ){
    //         $path = $data['image']->store('public/devices');
    //         $url = Storage::url($path);
    //         $data['image'] = $url;
    //     }
    //     return $this->model->where('id',$id)->update($data);
    // }

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

            $result = $this->model->onlyTrashed()->find($id);
            $result->forceDelete();
            return $result;

    }

}
