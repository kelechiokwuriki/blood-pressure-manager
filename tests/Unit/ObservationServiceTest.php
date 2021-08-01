<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Observation;
use App\Repositories\Observation\ObservationRepository;
use App\Repositories\User\UserRepository;
use App\Services\Observation\ObservationService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;


class ObservationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $observationData;
    protected $observationService;
    protected $observationRepository;
    protected $userRepository;

    protected $observationModel;

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

        $this->observationData = [
            'user_id' => $this->adminUser->id,
            'notes' => 'Test notes',
            'reading' => 'Test reading'
        ];

        $this->userRepository = new UserRepository(new User());
        $this->observationRepository = new ObservationRepository(new Observation());
        $this->observationService = new ObservationService($this->observationRepository, $this->userRepository);
    }

    public function testCreateObservation()
    {
        $this->observationService->createPatientObservation($this->observationData);
        $this->assertDatabaseHas('observations', $this->observationData);
    }


}
