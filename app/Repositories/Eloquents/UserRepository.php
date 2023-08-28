<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;



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
        if ($request->searchGroup) {
            $query->where('group_id', $request->searchGroup);
        }
        return $query->orderBy('id', 'DESC')->paginate(5);
    }
    public function store($data)
    {
        if (isset($data['image']) && $data['image']->isValid()) {
            $path = $data['image']->store('public/users');
            $url = Storage::url($path);
            $data['image'] = $url;
        } else {
            $data['image'] = 'storage/default/image.jpg';
        }

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        if (isset($data['image']) && $data['image']->isValid()) {
            $path = $data['image']->store('public/users');
            $url = Storage::url($path);
            $data['image'] = $url;
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']); // Loại bỏ trường password khỏi mảng data
        }


        return $this->model->where('id', $id)->update($data);
    }

    public function trash($request = null)
    {
        $query = $this->model->onlyTrashed();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        return $query->orderBy('id', 'DESC')->paginate(3);
    }

    public function forceDelete($id)
    {
        return $this->model->onlyTrashed()->find($id)->forceDelete();
    }
    public function restore($id)
    {
        return User::withTrashed()->find($id)->restore();
    }

    public function login()
    {
        // dd(Auth::check());
        return Auth::check();
    }
    public function postLogin($request)
    {

        $dataUser = $request->only('email', 'password');
        $remember = $request->has('remember');
        return Auth::attempt($dataUser, $remember);
    }
    public function logout()
    {
        return Auth::logout();
    }
    public function getInfoUser()
    {
        return  Auth::user();
    }

    public function forgotPassword($request)
    {
        $user = $this->model->where('email', $request->email)->first(); // Tìm người dùng dựa trên địa chỉ email yêu cầu

        if ($user) {
            $pass = Str::random(6);
            $user->password = bcrypt($pass);
            $user->save();

            $data = [
                'name' => $user->name,
                'pass' => $pass,
                'email' => $user->email,
            ];

            return  Mail::send('includes.SendMail', compact('data'), function ($email) use ($user) {
                $email->from($user->email, 'Quan tri vien'); // Địa chỉ email và tên người gửi là email của người dùng
                $email->subject('Đặt lại mật khẩu');
                $email->to($user->email, $user->name);
            });
        }
    }
}
