<?php

namespace App\Services\Observation;

use App\Observation;
use App\Repositories\Observation\ObservationRepository;

class ObservationService
{
    protected $observationRepository;

    public function __construct(ObservationRepository $observationRepository)
    {
        $this->observationRepository = $observationRepository;
    }

    public function createPatientObservation(array $observation)
    {
        return $this->observationRepository->create($observation);
    }
}
