<?php

namespace App\Http\Controllers;

use App\Models\BorrowDevice;
use App\Models\Room;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Services\Interfaces\BorrowDeviceServiceInterface;
use Illuminate\Http\Request;

use App\Http\Requests\StoreBorrow_devicesRequest;
use App\Http\Requests\UpdateBorrow_devicesRequest;

class BorrowDevicesController extends Controller
{
    protected $borrowdeviceService;

    public function __construct(BorrowDeviceServiceInterface $borrowdeviceService)
    {
        $this->borrowdeviceService = $borrowdeviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->borrowdeviceService->paginate(10,$request);
        // Load thông tin người mượn thông qua bảng borrows
        $items->load('borrow.user');

        return view('borrowdevices.index', compact('items'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrow_devices $borrow_devices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except(['_token', '_method']);
        // dd($data);
        $this->borrowdeviceService->update($data,$id);
        return redirect()->route('borrowdevices.index')->with('success', 'Cập nhật thành công');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
        {
            try{
                $this->borrowdeviceService->destroy($id);
                    return redirect()->route('borrowdevices.index')->with('success', 'Xóa thành công!');
                }catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Xóa thất bại!');
                }
        }
    
        public function trash()
        {
            $items = $this->borrowdeviceService->trash();
            // Load thông tin người mượn thông qua bảng borrows
            $items->load('borrow.user');
            return view('borrowdevices.trash', compact('items'));
        }
        public function restore($id)
        {
            try {
                $items = $this->borrowdeviceService->restore($id);
                return redirect()->route('borrowdevices.trash')->with('success', 'Khôi phục thành công');
            } catch (\exception $e) {
                Log::error($e->getMessage());
                return redirect()->route('borrowdevices.trash')->with('error', 'Khôi phục không thành công!');
            }
        }
        public function forceDelete($id)
        {
    
            try {
                $items = $this->borrowdeviceService->forceDelete($id);
                return redirect()->route('borrowdevices.trash')->with('success', 'Xóa thành công');
            } catch (\exception $e) {
                Log::error($e->getMessage());
                return redirect()->route('borrowdevices.trash')->with('error', 'Xóa không thành công!');
            }
        }
}