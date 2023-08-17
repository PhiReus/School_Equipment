<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Services\Interfaces\BorrowServiceInterface;

use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;

class BorrowController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowServiceInterface $borrowService)
    {
        $this->borrowService = $borrowService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->borrowService->paginate(2,$request);

        return view('borrows.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('borrows.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->borrowService->store($data);
        return redirect()->route('borrows.index')->with('success', 'Thêm thiết bị thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrow $borrow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrow $borrow)
    {
        $items = $this->borrowService->find($id);
        // dd($item);
        return view('borrows.edit', compact('items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowRequest $request, Borrow $borrow)
    {
        // dd(123);
        $data = $request->except(['_token', '_method']);
        $this->borrowService->update($id, $data);
        return redirect()->route('borrows.index')->with('success', 'Cập nhật thiết bị thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        try{
            $this->borrowService->destroy($id);
                return redirect()->route('borrows.index')->with('success', 'Xóa thiết bị thành công');
            }catch (\Exception $e) {
                return redirect()->back()->with('error', 'Xóa thất bại!');
            }
    }

    public function trash()
    {
        $items = $this->borrowService->trash();
        return view('borrows.trash', compact('items'));
    }
    public function restore($id)
    {
        try {
            $items = $this->borrowService->restore($id);
            return redirect()->route('borrows.index')->with('success', 'Khôi phục thiết bị thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('borrows.index')->with('error', 'Khôi phục không thành công!');
        }
    }
    public function forceDelete($id)
    {

        try {
            $items = $this->borrowService->forceDelete($id);
            return redirect()->route('borrows.index')->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('borrows.index')->with('error', 'Xóa không thành công!');
        }
}

}
