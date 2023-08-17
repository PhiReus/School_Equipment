<?php
namespace App\Services\Interfaces;

interface UserServiceInterface extends ServiceInterface {
    public function trash();
    public function forceDelete($id);
    public function restore($id);
}
