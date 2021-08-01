<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Observation\ObservationService;
use Illuminate\Http\Request;

class ObservationApiController extends Controller
{
    protected $observationService;

    public function __construct(ObservationService $observationService)
    {
        $this->observationService = $observationService;
    }

    public function getPatientObservations(int $userId, Request $request)
    {
        $type = $request->query('type');

        switch ($type) {
            case 'csv':
                $this->observationService->exportObservationsAsCsv($userId);
            break;

            case 'pdf':
                $this->observationService->exportobservationAsPdf($userId);
            break;

            default:
                return $this->observationService->getUserObservations($userId);
            break;
        }
    }
}
