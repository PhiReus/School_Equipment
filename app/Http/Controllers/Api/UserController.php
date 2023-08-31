<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->userService->all($request);
        //định dạng danh sách người dùng dưới dạng JSON
        return UserResource::collection($items);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->userService->store($data);
        return response()->json([
            "success" => true,
            "message" => "Thêm thành công",
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->userService->find($id);
        //UserResource là một resource class (lớp tài nguyên) được sử dụng để định dạng dữ liệu người dùng khi trả về.
        return new UserResource($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $this->userService->update($id, $data);
        return response()->json([
            "success" => true,
            "message" => "Cập nhật thành công",
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->destroy($id);
        return response()->json([
            "success" => true,
            "message" => "Xóa thành công",
        ]);
    }
}
