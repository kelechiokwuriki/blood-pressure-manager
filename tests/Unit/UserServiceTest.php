<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Observation;
use App\Repositories\Observation\ObservationRepository;
use App\Repositories\User\UserRepository;
use App\Services\Observation\ObservationService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;


class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $patientData;
    protected $staffData;
    protected $userService;
    protected $userRepository;
    protected $userModel;

    public function setup(): void
    {
        parent::setup();

        //user setup
        $this->adminUser = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'api_token' => Str::random(80),
            'role' => 'admin',
            'remember_token' => Str::random(10)
        ]);

        $this->actingAs($this->adminUser);

        $this->patientData = [
            'name' => 'patient test',
            'email' => 'test email',
            'role' => 'patient',
            'phone_number' => '0000000000',
            'notes' => 'Blood pressure note',
            'reading' => 'reading'
        ];

        $this->staffData = [
            'name' => 'patient test',
            'email' => 'test email staff',
            'role' => 'doctor',
            'phone_number' => '0000000000',
            'notes' => 'Blood pressure note',
            'reading' => 'reading'
        ];

        $this->userRepository = new UserRepository(new User());
        $this->userService = new UserService($this->userRepository);
    }

    public function testGetUserById()
    {
        $user = $this->userService->getUserById($this->adminUser->id);
        $this->assertNotEmpty($user);
        $this->assertEquals($user->id, $this->adminUser->id);
    }

    public function testCreateStaff()
    {
        $user = $this->userService->createStaff($this->staffData);
        $this->assertNotEmpty($user);
    }

    public function testGetUserByRole()
    {
        $role = 'patient';
        $patient = $this->userService->createPatient($this->patientData);
        $this->assertEquals($patient->role, $role);

        $role = 'doctor';
        $staff = $this->userService->createPatient($this->staffData);
        $this->assertEquals($staff->role, $role);
    }


}
