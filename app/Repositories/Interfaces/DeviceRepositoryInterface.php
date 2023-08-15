<?php 
namespace App\Repositories\Interfaces;
//RepositoryInterface cùng cấp, ko cần use
interface DeviceRepositoryInterface extends RepositoryInterface{
    function paginate($request);
}