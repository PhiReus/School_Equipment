<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\DeviceServiceInterface;

class DeviceController extends Controller
{
    protected $deviceService;

    public function __construct(DeviceServiceInterface $deviceService)
    {
        $this->deviceService = $deviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->deviceService->all($request);

        return view('devices.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $data = [
            'name' => $request->input('name'),
            'quantity' => $request->input('quantity'),
        ];

        // Kiểm tra xem người dùng có tải lên hình ảnh không
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $this->deviceService->store($data);

        return redirect()->route('devices.index')->with('success', 'Tạo thiết bị thành công');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo thiết bị');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = $this->deviceService->find($id);

        return view('devices.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = [
                'name' => $request->input('name'),
                'quantity' => $request->input('quantity'),
            ];

            // Kiểm tra xem người dùng có tải lên hình ảnh mới không
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('images', 'public');
            }

            $this->deviceService->update($id, $data);

            return redirect()->route('devices.index')->with('success', 'Cập nhật thông tin thiết bị thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật thông tin thiết bị');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
