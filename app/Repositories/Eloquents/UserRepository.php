<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }
   
    public function all($request = null)
    {
        $query = $this->model->select('*');

        if ($request->searchname) {
            $query->where('name', 'like', '%' . $request->searchname . '%');
        }
        if ($request->searchphone) {
            $query->where('phone', 'like', '%' . $request->searchphone . '%');
        }
        if ($request->searchemail) {
            $query->where('email', 'like', '%' . $request->searchemail . '%');
        }
        if ($request->id) {
            $query->where('id', $request->id);
        }
        return $query->orderBy('id', 'DESC')->paginate(10);
    }
    public function store($data)
    {
        if( isset( $data['image']) && $data['image']->isValid() ){
            $path = $data['image']->store('public/users');
            $url = Storage::url($path);
            $data['image'] = $url;
        }
        if( isset( $data['password'])) {
            $data['password']=bcrypt($data['password']);
        };
        return $this->model->create($data);
    }
    public function update($id,$data)
    {
         if( isset( $data['image']) && $data['image']->isValid() ){
            $path = $data['image']->store('public/users');
            $url = Storage::url($path);
            $data['image'] = $url;
        }
        if( isset( $data['password'])) {
            $data['password']=bcrypt($data['password']);
        };
        return $this->model->where('id',$id)->update($data);
    }
    public function trash()
    {
        return $this->model->onlyTrashed()->get();
    }
    public function forceDelete($id)
    {
        return $this->model->onlyTrashed()->find($id)->forceDelete();
    }
    public function restore($id)
    {
        return User::withTrashed()->find($id)->restore();
    }
}
