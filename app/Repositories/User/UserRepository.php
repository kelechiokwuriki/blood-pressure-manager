<?php

namespace App\Repositories\User;

use App\Repositories\Base\BaseRepository;
use App\User;

class UserRepository extends BaseRepository
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        parent::__construct($userModel);
    }
}
