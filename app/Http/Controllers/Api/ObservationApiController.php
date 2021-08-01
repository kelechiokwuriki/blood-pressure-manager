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

    public function store(Request $request)
    {
        return $this->observationService->createPatientObservation($request->all());
    }
}
