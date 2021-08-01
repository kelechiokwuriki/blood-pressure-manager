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

    public function exportObservationsAsCsv(int $userId)
    {
        return Excel::download(new ObservationsExport, 'observations.xlsx');

        // $user = $this->userRepository->find($userId);

        // $observations = $this->observationRepository->where('user_id', $userId);
    }

    public function getUserObservations(int $userId)
    {
        return $this->observationRepository->where('user_id', $userId)->get();
    }
}
