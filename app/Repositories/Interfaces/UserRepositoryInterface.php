<?php
namespace App\Repositories\Interfaces;
//RepositoryInterface cùng cấp, ko cần use
interface UserRepositoryInterface extends RepositoryInterface{
    public function trash();
    public function forceDelete($id);
    public function restore($id);
}
