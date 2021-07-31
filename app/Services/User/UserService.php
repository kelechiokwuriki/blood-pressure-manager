<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createStaff(array $staffData)
    {
        return $this->userRepository->create($staffData);
    }

    public function getUsersByRole(string $role)
    {
        switch($role) {
            case 'patient':
                return $this->userRepository->where('role', $role)->get();

            case 'staff':
                return $this->userRepository->where('role', 'admin')
                ->orWhere('role', 'nurse')
                ->orWhere('role', 'doctor')
                ->get();

            default:
                throw new Exception('Role not recognized');

        }
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
