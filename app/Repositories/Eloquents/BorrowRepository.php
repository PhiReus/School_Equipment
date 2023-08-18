<?php
namespace App\Repositories\Eloquents;

use App\Models\Borrow;
use App\Repositories\Interfaces\BorrowRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Support\Facades\Storage;
class BorrowRepository extends EloquentRepository implements BorrowRepositoryInterface
{
    public function getModel()
    {
        return Borrow::class;
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
    public function paginate($limit, $request = null)
    {
        $query = $this->model->with('user');
        // Thay đổi từ 'user_id' thành 'user.name'
        if ($request && $request->searchName) {
         $query->whereHas('user', function ($query) use ($request) {
        $query->where('name', 'LIKE', '%' . $request->searchName . '%');
    });
}

        if ($request && $request->searchBorrow_date) {
            $query->where('borrow_date', 'LIKE', '%' . $request->searchBorrow_date . '%');
        }
        $query->orderBy('id', 'desc');
        $items = $query->paginate($limit);
        // dd($items);
        return $items;
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
    public function update($id, $data)
    {
        return $this->find($id)->update($data);
    }
    
}