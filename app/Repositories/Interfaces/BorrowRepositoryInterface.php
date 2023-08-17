<?php 
namespace App\Repositories\Interfaces;
//RepositoryInterface cùng cấp, ko cần use
interface BorrowRepositoryInterface extends RepositoryInterface{
    function trash();
    function restore($id);
    function forceDelete($id);
}