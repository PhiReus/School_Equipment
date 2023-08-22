<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\DeviceServiceInterface;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use Illuminate\Support\Facades\Auth;

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
        if(!Auth::user()->hasPermission('Device_viewAny')){
            abort(403);
        }
        $items = $this->deviceService->paginate(2,$request);

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
    public function store(StoreDeviceRequest $request)
    {

        $data = $request->except(['_token', '_method']);
        $this->deviceService->store($data);
        return redirect()->route('devices.index')->with('success', 'Thêm thiết bị thành công');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->deviceService->find($id);
        return view('devices.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = $this->deviceService->find($id);
        // dd($item);
        return view('devices.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceRequest $request, string $id)
    {
        // dd(123);
        $data = $request->except(['_token', '_method']);
        $this->deviceService->update($id, $data);
        return redirect()->route('devices.index')->with('success', 'Cập nhật thiết bị thành công');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        $this->deviceService->destroy($id);
            return redirect()->route('devices.index')->with('success', 'Xóa thiết bị thành công');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }


    public function trash()
    {
        $items = $this->deviceService->trash();
        return view('devices.trash', compact('items'));
    }
    public function restore($id)
    {
        try {
            $items = $this->deviceService->restore($id);
            return redirect()->route('devices.index')->with('success', 'Khôi phục thiết bị thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('devices.index')->with('error', 'Khôi phục không thành công!');
        }
    }
    public function forceDelete($id)
    {

        try {
            $items = $this->deviceService->forceDelete($id);
            return redirect()->route('devices.index')->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('devices.index')->with('error', 'Xóa không thành công!');
        }
}

}
