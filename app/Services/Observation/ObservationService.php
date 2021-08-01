<?php

namespace App\Services\Observation;

use App\Exports\ObservationsExport;
use App\Observation;
use App\Repositories\Observation\ObservationRepository;
use App\Repositories\User\UserRepository;
use Maatwebsite\Excel\Facades\Excel;

class ObservationService
{
    protected $observationRepository;
    protected $userRepository;

    public function __construct(ObservationRepository $observationRepository, UserRepository $userRepository)
    {
        $this->observationRepository = $observationRepository;
        $this->userRepository = $userRepository;
    }

    public function createPatientObservation(array $observation)
    {
        return $this->observationRepository->create($observation);
    }
}
