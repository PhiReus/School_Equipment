<?php

namespace App\Services;

use App\Services\Interfaces\DeviceServiceInterface;

use App\Repositories\Interfaces\DeviceRepositoryInterface;

class DeviceService implements DeviceServiceInterface
{
    protected $deviceRepository;

    public function __construct(DeviceRepositoryInterface $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    /* Triển khai các phương thức trong DeviceServiceInterface */
    public function paginate($limit,$request=[])
    {
        return $this->groupRepository->paginate($request);
    }
    public function all($request=[]){
        return $this->deviceRepository->all($request);
    }
    public function find($id){
        return $this->deviceRepository->find($id);
    }
    public function store($request){
        return $this->deviceRepository->store($request);
    }
    public function update($request, $id){
        return $this->deviceRepository->update($request,$id);
    }
    public function destroy($id){
        return $this->deviceRepository->destroy($id);
    }
}