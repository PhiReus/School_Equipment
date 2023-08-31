<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Device;
use App\Services\Interfaces\BorrowServiceInterface;
use App\Services\Interfaces\DeviceServiceInterface;
use App\Http\Resources\BorrowResource;
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
        return response()->json($items,200);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data = $request->except(['_token', '_method']);
        $createdBorrow = $this->borrowService->store($data);
    
        return response()->json($createdBorrow,200);
    }
    
    public function show(string $id)
    {
        $borrow = $this->borrowService->find($id);
        return new BorrowResource($borrow);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $updatedBorrow = $this->borrowService->update($data, $id);

        return new BorrowResource($updatedBorrow);
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
