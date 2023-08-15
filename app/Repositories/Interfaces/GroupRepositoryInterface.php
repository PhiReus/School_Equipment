<?php
namespace App\Repositories\Interfaces;


interface GroupRepositoryInterface extends RepositoryInterface {
    public function forceDelete($id);
    public function restore($id);
}
