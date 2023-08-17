<?php 
namespace App\Repositories\Interfaces;
//RepositoryInterface cùng cấp, ko cần use
interface DeviceRepositoryInterface extends RepositoryInterface{
    function trash();
    function restore($id);
    function forceDelete($id);
}