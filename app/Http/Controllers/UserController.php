<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\GroupServiceInterface;

class UserController extends Controller
{
    protected $userService;
    protected $groupService;

    public function __construct(UserServiceInterface $userService, GroupServiceInterface $groupService)
    {
        $this->groupService = $groupService;
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $items = $this->userService->all($request);
        $param =
            [
                'items' => $items
            ];
        return view('users.index', $param);
    }
    public function create()
    {

        $groups = Group::get();
        $items = User::get();
        $params =
            [
                'groups' => $groups,
                'items' => $items,
            ];
        return view('users.create', $params);
    }
    public function store(StoreUserRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->userService->store($data);
        return redirect()->route('users.index')->with('success', 'Thêm mới thành công!');
    }
    public function edit($id)
    {
        $groups = Group::get();
        $item = $this->userService->find($id);
        $params =
            [
                'groups' => $groups,
                'item' => $item,
            ];
        return view('users.edit', $params);
    }
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $this->userService->update($id, $data);
        return redirect()->route('users.index')->with('success', 'Cập Nhật thành công!');
    }
    public function destroy($id)
    {
        try {
            $this->userService->destroy($id);
            return redirect()->route('users.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }
    public function show($id)
    {
        $item = $this->userService->find($id);
        // dd($item);
        return view('users.show', compact('item'));
    }
    public function trash()
    {
        $users = $this->userService->trash();
        return view('users.trash', compact('users'));
    }
    public function restore($id)
    {
        try {
            $user = $this->userService->restore($id);
            return redirect()->route('users.trash')->with('success', 'Khôi phục thành công!');
        } catch (err) {
            return redirect()->route('users.trash')->with('error', 'Khôi phục thất bại!');
        }
    }
    public function force_destroy($id)
    {
        try {
            $user = $this->userService->find($id);
            return redirect()->route('users.trash')->with('success', 'Xóa thành công!');
        } catch (err) {
            return redirect()->route('users.trash')->with('success', 'Xóa thất bại!');
        }
    }
}
