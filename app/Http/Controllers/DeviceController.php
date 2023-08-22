<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\DeviceServiceInterface;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\DeviceType;
use App\Services\Interfaces\DeviceTypeServiceInterface;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    protected $deviceService;
    protected $deviceTypeService;

    public function __construct(DeviceServiceInterface $deviceService,DeviceTypeServiceInterface $deviceTypeService)
    {
        $this->deviceService = $deviceService;
        $this->deviceTypeService = $deviceTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->deviceService->paginate(2,$request);
        $devicetypes = $this->deviceTypeService->all($request);
        return view('devices.index', compact('items','devicetypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devicetypes = DeviceType::get();
        return view('devices.create',compact('devicetypes'));
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
        $devicetypes = DeviceType::get();

        // dd($item);
        return view('devices.edit', compact('item','devicetypes'));
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
            $this->deviceService->restore($id);
            return redirect()->route('devices.index')->with('success', 'Khôi phục thiết bị thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('devices.index')->with('error', 'Khôi phục không thành công!');
        }
    }
    public function forceDelete($id)
    {

        try {
            $this->deviceService->forceDelete($id);
            return redirect()->route('devices.index')->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('devices.index')->with('error', 'Xóa không thành công!');
        }
}

}
