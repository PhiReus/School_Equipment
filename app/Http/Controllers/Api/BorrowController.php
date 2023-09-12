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
    public function __construct(BorrowServiceInterface $borrowService
    , DeviceServiceInterface  $deviceService )
    {
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
        return response()->json($createdBorrow,200);
    }
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->borrowService->destroy($id);
        return response()->json(['message' => 'Successfully deleted.']);
    }
}
