<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\User;
use App\Services\Interfaces\BorrowServiceInterface;
use App\Services\Interfaces\DeviceServiceInterface;

use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;

class BorrowController extends Controller
{
    protected $borrowService;
    protected $deviceService;

    public function __construct(BorrowServiceInterface $borrowService, DeviceServiceInterface $deviceService )
    {
        $this->borrowService = $borrowService;
        $this->deviceService = $deviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->borrowService->paginate(2,$request);
        $users = User::get();
        return view('borrows.index', compact('items','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('borrows.create', compact('users'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowRequest $request)
    {
        // dd(2);
        $data = $request->except(['_token', '_method']);
        $this->borrowService->store($data);
        return redirect()->route('borrows.index')->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show($borrow)
    {
        $users = User::get();
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $items = $this->borrowService->find($id);
        // dd($item);
        $users = User::all();
        return view('borrows.edit', compact('items','users',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowRequest $request, string $id)
    {
        // dd(123);
        $data = $request->except(['_token', '_method']);
        $this->borrowService->update($id, $data);
        return redirect()->route('borrows.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $this->borrowService->destroy($id);
                return redirect()->route('borrows.index')->with('success', 'Xóa thành công!');
            }catch (\Exception $e) {
                return redirect()->back()->with('error', 'Xóa thất bại!');
            }
    }

    public function trash()
    {
        $items = $this->borrowService->trash();
        $users = User::get();
        return view('borrows.trash', compact('items','users'));
    }
    public function restore($id)
    {
        try {
            $items = $this->borrowService->restore($id);
            return redirect()->route('borrows.trash')->with('success', 'Khôi phục thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('borrows.trash')->with('error', 'Khôi phục không thành công!');
        }
    }
    public function forceDelete($id)
    {

        try {
            $items = $this->borrowService->forceDelete($id);
            return redirect()->route('borrows.trash')->with('success', 'Xóa thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('borrows.trash')->with('error', 'Xóa không thành công!');
        }
    }

    public function devices(Request $request)
    {
        $devices = $this->deviceService->paginate(2,$request);
        $data = [];
        foreach ($devices as $device){
            $data[] = [
                'id' => $device->id,
                'text' => $device->name
            ];
        }
        return response()->json($data);
    }
}
