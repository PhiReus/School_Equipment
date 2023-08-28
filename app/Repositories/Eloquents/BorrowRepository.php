<?php

namespace App\Repositories\Eloquents;

use App\Models\Borrow;
use App\Models\BorrowDevice;
use App\Models\Device;
use App\Repositories\Interfaces\BorrowRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BorrowRepository extends EloquentRepository implements BorrowRepositoryInterface
{
    public function getModel()
    {
        return Borrow::class;
    }


    public function paginate($limit, $request = null)
    {
        $subquery = $this->model
            ->select('user_id')
            ->groupBy('user_id');
        $query = $this->model->query (true);
    
        if ($request && $request->searchName) {
            $subquery->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchName . '%');
            });
            $userIds = $subquery->pluck('user_id');
    
            $query = $this->model->whereIn('user_id', $userIds)
                ->with(['user' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->orderBy('id', 'desc');
        }
    
        if ($request && $request->searchBorrow_date) {
            $query->where('borrow_date', 'LIKE', '%' . $request->searchBorrow_date . '%');
        }
        if($request->searchStatus !== null){
            $query->where('status',$request->searchStatus);
        }
        if ($request->searchApproved !== null) {
            $query->where('approved',$request->searchApproved);
        }
        
        $query->orderBy('id','desc');
        $items = $query->paginate($limit);
    
        return $items;
    }
    
    

   
    public function store($data)
    {
        
        $userData = [
            'user_id' => $data['user_id'],
            'borrow_date' => $data['borrow_date'],
            'borrow_note' => $data['borrow_note'],
            'status' => $data['status'],
            'approved' => $data['approved']

        ];
    
        $deviceData = [];
        foreach ($data['devices']['id'] as $key => $deviceId) {
            $deviceData[] = [
                'device_id' => $deviceId,
                'room_id' => $data['devices']['room_id'][$key],
                'lesson_name' => $data['devices']['lesson_name'][$key],
                'quantity' => $data['devices']['quantity'][$key],
                'session' => $data['devices']['session'][$key],
                'lecture_name' => $data['devices']['lecture_name'][$key],
                'lecture_number' => $data['devices']['lecture_number'][$key],
                'return_date' => $data['devices']['return_date'][$key],
                'borrow_date'  => $data['borrow_date'],
                'status' => $data['status']
            ];
        }
    
        // Tạo bản ghi borrow mới
        $borrow = $this->model->create($userData);
    
        // Thêm nhiều bản ghi borrow_device mới
        $borrow->the_devices()->createMany($deviceData);
    
         // Khi xét duyệt, trừ số lượng
        if($data['approved'] == 1){
            // Cập nhật số lượng trong bảng devices
            foreach ($deviceData as $device) {
               $this->updateDeviceQuantity($device['device_id'], -$device['quantity']);
            }
        }
    
        return $borrow;
    }


    // public function destroy($id)
    // {
    //     $borrow = $this->model->findOrFail($id);
    //     $borrowDevices = $borrow->the_devices;
    
    //     foreach ($borrowDevices as $borrowDevice) {
    //         $this->updateDeviceQuantity($borrowDevice->device_id, $borrowDevice->quantity);
    //     }
    
    //     $result = $this->model->destroy($id);
    //     return $result;
    // }
    

    public function trash($request = null)
    {
        $query = $this->model->onlyTrashed()->with(['user:id,name']);
    
        if($request->searchStatus !== null){
            $query->where('status',$request->searchStatus);
        }
        if ($request->searchApproved !== null) {
            $query->where('approved',$request->searchApproved);
        }
        if ($request->searchBorrow_date) {
            $query->where('borrow_date', 'like', '%' . $request->searchBorrow_date . '%');
        }
    
        if ($request->searchName) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchName . '%');
            });
        }
    
        return $query->orderBy('id', 'DESC')->paginate(11);
    }
    
    
    public function restore($id)
    {
        $result = $this->model->withTrashed()->find($id)->restore();
        return $result;
    }

    public function forceDelete($id)
    {

        $result = $this->model->onlyTrashed()->find($id);
        $result->forceDelete();
        return $result;
    }
    public function update($data, $id)
    {
        $userData = [
            'user_id' => $data['user_id'],
            'borrow_date' => $data['borrow_date'],
            'borrow_note' => $data['borrow_note'],
            'status' => $data['status'],
            'approved' => $data['approved']
        ];
    
        $borrow = $this->model->findOrFail($id);
        $borrow->update($userData);
    
        $currentDeviceIds = $borrow->the_devices->pluck('device_id')->toArray();
    
        // foreach ($data['devices']['id'] as $key => $deviceId) {
        //     $deviceData = [
        //         'device_id' => $deviceId,
        //         'room_id' => $data['devices']['room_id'][$key],
        //         'lesson_name' => $data['devices']['lesson_name'][$key],
        //         'quantity' => $data['devices']['quantity'][$key], // Use the actual borrowed quantity
        //         'session' => $data['devices']['session'][$key],
        //         'lecture_name' => $data['devices']['lecture_name'][$key],
        //         'lecture_number' => $data['devices']['lecture_number'][$key],
        //         'return_date' => $data['devices']['return_date'][$key]
        //     ];
    
        //     // if (in_array($deviceId, $currentDeviceIds)) {
        //     //     $oldQuantity = BorrowDevice::where('borrow_id', $id)
        //     //         ->where('device_id', $deviceId)
        //     //         ->value('quantity');
        //     //     $quantityChange = $device['quantity'] - $oldQuantity;
    
        //     //     $borrow->the_devices()
        //     //         ->where('borrow_id', $id)
        //     //         ->where('device_id', $deviceId)
        //     //         ->update($device);
    
        //     //     $this->updateDeviceQuantity($deviceId, -$quantityChange);
        //     // } else {
        //     //     $borrow->the_devices()->create($device);
    
        //     //     $this->updateDeviceQuantity($deviceId, -$device['quantity']);
        //     // }
    
        //     // unset($currentDeviceIds[array_search($deviceId, $currentDeviceIds)]);
        // }
    
        // Remove devices that were deleted from the borrow record
        // $deletedDeviceIds = array_diff($currentDeviceIds, $data['devices']['id']);
    
        // foreach ($deletedDeviceIds as $deletedDeviceId) {
        //     $deletedQuantity = BorrowDevice::where('borrow_id', $id)
        //         ->where('device_id', $deletedDeviceId)
        //         ->value('quantity');
    
        //     $borrow->the_devices()
        //         ->where('borrow_id', $id)
        //         ->where('device_id', $deletedDeviceId)
        //         ->delete();
    
        //     $this->updateDeviceQuantity($deletedDeviceId, $deletedQuantity);
        // }

        // Thêm nhiều bản ghi borrow_device mới
        
        $deviceData = [];
        $deviceIds = [];
        foreach ($data['devices']['id'] as $key => $deviceId) {
            $deviceData[] = [
                'device_id' => $deviceId,
                'room_id' => $data['devices']['room_id'][$key],
                'lesson_name' => $data['devices']['lesson_name'][$key],
                'quantity' => $data['devices']['quantity'][$key],
                'session' => $data['devices']['session'][$key],
                'lecture_name' => $data['devices']['lecture_name'][$key],
                'lecture_number' => $data['devices']['lecture_number'][$key],
                'return_date' => $data['devices']['return_date'][$key]
            ];
        }
        $borrow->the_devices()->delete();
        $borrow->the_devices()->createMany($deviceData);

        // Khi xét duyệt, trừ số lượng
        if($data['approved'] == 1){
             // Cập nhật số lượng trong bảng devices
            foreach ($deviceData as $device) {
                $this->updateDeviceQuantity($device['device_id'], -$device['quantity']);
            }
            
        }
    
        return true;
    }
    
    public function updateDeviceQuantity($deviceId, $quantityChange)
    {
        $device = Device::findOrFail($deviceId);
        $device->quantity += $quantityChange;
        $device->save();
        
    }
  
    public function all($request = null)
    {
        $query = $this->model->select('*');
        return $query->orderBy('id', 'DESC')->paginate(21);
    }
    public function updateBorrow($id, $data)
    {
        // Tìm phiếu mượn theo ID
        $borrow = $this->model->findOrFail($id);
    
        // Lấy trạng thái xét duyệt hiện tại
        $currentApprovedStatus = $borrow->approved;
    
        // Lấy trạng thái mới từ dữ liệu gửi đến
        $newApprovedStatus = $data['approved'];
    
        // Kiểm tra nếu trạng thái đã xét duyệt thay đổi thành chưa xét duyệt hoặc từ chối
        if ($currentApprovedStatus == 1 && ($newApprovedStatus == 0 || $newApprovedStatus == 2)) {
            // dd(123);
            // $borrow->the_devices()->update([
            //     'status' => 0
            // ]);
            // Trả lại số lượng thiết bị cho bảng device tương ứng
            foreach ($borrow->the_devices as $device) {
                $this->updateDeviceQuantity($device->device_id, $device->quantity);
                $device->status = 0;
                $device->save();
                // $device->update([
                //     'status' => 0
                // ]);
            }
            
        }
        // Kiểm tra nếu trạng thái chưa xét duyệt hoặc từ chối thay đổi thành đã xét duyệt
        elseif (($currentApprovedStatus == 0 || $currentApprovedStatus == 2) && $newApprovedStatus == 1) {
            // Trừ đi số lượng thiết bị cho bảng device tương ứng
            foreach ($borrow->the_devices as $device) {
                $this->updateDeviceQuantity($device->device_id, -$device->quantity);
            }
            
        }else{
            // Cập nhật trạng thái và số lượng trong bảng borrow_device
            $borrow_device_ids = $data['the_device_status'];
            foreach ($borrow_device_ids as $borrow_device_id => $device_status) {
                $borrow->the_devices()->where('id', $borrow_device_id)->update(['status' => $device_status]);
            }
        }
    
        // Cập nhật trạng thái xét duyệt từ dữ liệu gửi đến
        $borrow->approved = $newApprovedStatus;
    
        // Cập nhật trạng thái từ dữ liệu gửi đến (nếu có)
        if (isset($data['status'])) {
            $borrow->status = $data['status'];
        }
    
        
    
        // Tính tổng số thiết bị mượn và trả
        $tong_muon = $borrow->the_devices()->count();
        $tong_tra = $borrow->the_devices()->where('status', 1)->count();
    
        // Tự động cập nhật trạng thái phiếu mượn nếu đã trả hết
        if ($tong_tra == $tong_muon) {
            $borrow->status = 1;
        }
    
        // Lưu các thay đổi
        $borrow->save();
    
        return $borrow;
    }
    
    
}