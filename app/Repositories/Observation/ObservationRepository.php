<?php

namespace App\Repositories\Observation;

use App\Observation;
use App\Repositories\Base\BaseRepository;

class ObservationRepository extends BaseRepository
{
    protected $observationModel;

    public function __construct(Observation $observationModel)
    {
        parent::__construct($observationModel);
    }
}
