<?php
namespace App\Services\Interfaces;

interface DeviceTypeServiceInterface extends ServiceInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash();
}

