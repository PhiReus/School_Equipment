<?php
namespace App\Services\Interfaces;

interface GroupServiceInterface extends ServiceInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash($request=[]);
}

