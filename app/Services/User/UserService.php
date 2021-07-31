<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsersByRole(string $role)
    {
        return $this->userRepository->where('role', $role)->get();
    }

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    public function createPatient(array $patientData)
    {
        return $this->userRepository->create($patientData);
    }
}
