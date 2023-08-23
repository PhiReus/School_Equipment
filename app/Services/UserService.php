<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;




class UserService implements UserServiceInterface {
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        return $this->userRepository = $userRepository;
    }
     /* Triển khai các phương thức trong GroupServiceInterface */
    public function paginate($limit,$request=[])
    {
        return $this->userRepository->paginate($limit);
    }
    public function all($request=[])
    {
        return $this->userRepository->all($request);
    }
    public function find($id)
    {
        return $this->userRepository->find($id);
    }
    public function store($request)
    {
        return $this->userRepository->store($request);
    }
    public function update($request, $id)
    {
        return $this->userRepository->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->userRepository->destroy($id);
    }

    public function forceDelete($id)
    {
        return $this->userRepository->forceDelete($id);
    }
    public function restore($id)
    {
        return $this->userRepository->restore($id);
    }
    public function trash()
    {
        return $this->userRepository->trash();
    }

}
