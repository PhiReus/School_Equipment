<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\DepartmentServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Requests\StoreDepartmentRequest;

class DepartmentController extends Controller
{
    protected $departmentService;
    public function __construct(DepartmentServiceInterface $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {   
        if (!Auth::user()->hasPermission('Room_viewAny')) {
            abort(403);
        }
        $departments = $this->departmentService->paginate(20, $request);
        
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {

        $data = $request->except(['_token', '_method']);
        $this->departmentService->store($data);
        return redirect()->route('departments.index')->with('success', 'Thêm mới thành công!');
    }

    public function edit($id)
    {
        $department = $this->departmentService->find($id);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, string $id)
    {
        $data = $request->except(['_token', '_method']);
        $room = $this->departmentService->update($data, $id);
        return redirect()->route('departments.index')->with('success', 'Cập Nhật thành công!');
    }


    public function destroy($id)
    {
        try {
            if ($this->departmentService->isDepartmentDevice($id)) {
                return redirect()->back()->with('error', 'Trong Thiết Bị đang có Bộ Môn này, không thể xóa!');
            }
            $this->departmentService->destroy($id);
            return redirect()->route('departments.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }


    public function trash(Request $request)
    {
        $departments = $this->departmentService->trash($request);
        return view('departments.trash', compact('departments', 'request'));
    }

    public function restore($id)
    {

        try {
            $department = $this->departmentService->restore($id);
            return redirect()->route('departments.trash')->with('success', 'Khôi phục thành công!');
        } catch (err) {
            return redirect()->route('departments.trash')->with('error', 'Khôi phục không thành công!');
        }
    }

    public function force_destroy($id)
    {
        try {
            $department = $this->departmentService->forceDelete($id);
            return redirect()->route('departments.trash')->with('success', 'Xóa thành công!');
        } catch (err) {
            return redirect()->route('departments.trash')->with('error', 'Xóa không thành công!');
        }
    }

}
