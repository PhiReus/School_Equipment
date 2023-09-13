<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Device;
use App\Services\Interfaces\BorrowServiceInterface;
use App\Services\Interfaces\DeviceServiceInterface;
use App\Http\Resources\BorrowResource;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;

class BorrowController extends Controller
{
    private $borrowService;
    private $deviceService;
    public function __construct(
        BorrowServiceInterface $borrowService
        , DeviceServiceInterface $deviceService
    ) {
        $this->borrowService = $borrowService;
        $this->deviceService = $deviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->borrowService->all($request);

        // Thêm tính toán tong_muon và tong_tra cho mỗi $item
        foreach ($items as $key => $item) {
            $tong_muon = $item->the_devices()->count();
            $tong_tra = $item->the_devices()->where('status', 1)->count();

            // Thêm vào dữ liệu của mỗi $item
            $items[$key]->tong_muon = $tong_muon;
            $items[$key]->tong_tra = $tong_tra;
        }

        return response()->json($items, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        // dd($data);
        $createdBorrow = $this->borrowService->store($data);
        return response()->json($createdBorrow, 200);
    }

   
    public function update(Request $request, $id)
    {
        // Tìm phiếu mượn cần cập nhật
        $borrow = $this->borrowService->find($id);
    
        if (!$borrow) {
            return response()->json([
                "success" => false,
                "message" => "Không tìm thấy phiếu mượn",
            ], 404);
        }
    
        // Cập nhật thông tin của phiếu mượn
        $data = $request->except(['_token', '_method']);
        $updatedBorrow = $this->borrowService->update($data, $id);
    
        return response()->json([
            "success" => true,
            "message" => "Cập nhật phiếu mượn thành công",
            "borrow" => $updatedBorrow,
        ], 200);
    }

    // public function update(Request $request, $id)
    // {
    //     // Tìm phiếu mượn cần cập nhật
    //     $borrow = Borrow::find($id);

    //     if (!$borrow) {
    //         return response()->json([
    //             "success" => false,
    //             "message" => "Không tìm thấy phiếu mượn",
    //         ], 404);
    //     }

    //     // Cập nhật thông tin của phiếu mượn
    //     $borrow->borrow_date = $request->input('borrow_date');
    //     $borrow->borrow_note = $request->input('borrow_note');
    //     $borrow->save();

    //     if ($request->input('devices') && count($request->input('devices'))) {
    //         // Xóa tất cả các thiết bị liên quan đến phiếu mượn
    //         $borrow->devices()->detach();

    //         // Thêm lại các thiết bị sau khi cập nhật
    //         foreach ($request->input('devices') as $deviceData) {
    //             $borrow->devices()->attach($deviceData['id'], [
    //                 'lesson_name' => $deviceData['lesson_name'],
    //                 'quantity' => $deviceData['quantity'],
    //                 'session' => $deviceData['session'],
    //                 'lecture_name' => $deviceData['lecture_name'],
    //                 'room_id' => $deviceData['room_id'],
    //                 'lecture_number' => $deviceData['lecture_number'],
    //                 'return_date' => $deviceData['return_date'],
    //             ]);
    //         }
    //     }


    //     return response()->json([
    //         "success" => true,
    //         "message" => "Cập nhật phiếu mượn thành công",
    //         "borrow" => $borrow,
    //     ], 200);
    // }
   
    
    public function show(string $id)
    {
        $item = $this->borrowService->find($id);
        // $user = $item->user;
        $devices = $item->devices;
        $the_devices = $item->the_devices;
        
        return response()->json([
            "success" => true,
            "data" => $item,
           

        ]);
    }
    public function destroy(string $id)
    {
        $this->borrowService->destroy($id);
        return response()->json([
            "success" => true,
            "message" => "Xóa thành công",
        ]);
    }

}