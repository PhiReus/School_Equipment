<?php
namespace App\Services\Interfaces;

interface ServiceInterface
{
    public function all($request);
    public function find($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
}