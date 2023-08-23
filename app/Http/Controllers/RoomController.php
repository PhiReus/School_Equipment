<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\Request;
use App\Services\Interfaces\RoomServiceInterface;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;




class RoomController extends Controller
{
    protected $postSevice;

    public function __construct(RoomServiceInterface $postSevice){
        $this->postSevice = $postSevice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('Room_viewAny')){
            abort(403);
        }
        $rooms = $this->postSevice->paginate(20,$request);
        return view('rooms.index',compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rooms/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->postSevice->store($data);
        return redirect()->route('rooms.index')->with('success', 'Thêm mới thành công!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = $this->postSevice->find($id);
        return view('rooms/edit',compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, string $id)
    {
        $data = $request->except(['_token', '_method']);
        $room = $this->postSevice->update($data,$id);
        return redirect()->route('rooms.index')->with('success', 'Cập Nhật thành công!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $this->postSevice->destroy($id);
            return redirect()->route('rooms.index')->with('success', 'Xóa thành công!');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
        
    }
    public function trash(){
        $rooms = $this->postSevice->trash();
        return view('rooms.trash',compact('rooms'));
       
    }

    public function restore($id){

        try {
            $room = $this->postSevice->restore($id);
            return redirect()->route('rooms.trash')->with('success', 'Khôi phục thành công!');
        } catch (err) {
            return redirect()->route('rooms.trash')->with('error', 'Khôi phục không thành công!');
        }
    }

    public function force_destroy($id){
        try {
            $room = $this->postSevice->forceDelete($id);
            return redirect()->route('rooms.trash')->with('success', 'Xóa thành công!');
        } catch (err) {
            return redirect()->route('rooms.trash')->with('error', 'Xóa không thành công!');
        }
    }
    
}
