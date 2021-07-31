<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\Observation\ObservationService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserApiController extends Controller
{
    protected $userService;
    protected $observationService;

    public function __construct(UserService $userService,
    ObservationService $observationService)
    {
        $this->userService = $userService;
        $this->observationService = $observationService;
    }

    public function index(Request $request)
    {
        try {
            $role = $request->query('role');
            $users = null;

            if ($role) {
                $users = $this->userService->getUsersByRole($role) ?
                $this->userService->getUsersByRole($role) : $this->userService->getAllUsers();
            }

            $users = UserResource::collection($users);

            return response()->json($users, 200);

        } catch (\Exception $e) {
            Log::error("Unable to fetch users: ". $e->getMessage());
            return response()->json('Failed fetching users', 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $role = $request->query('role');
            $user = null;

            if (!$role) {
                return response()->json(['error' => 'specify role when creating user.'], 400);
            }

            switch($role) {
                case 'patient':
                    $user = $this->userService->createPatient($request->all());
                    $data = $request->all();

                    if (isset($data['observation'])) {
                        $data['observation']['user_id'] = $user->id;
                        $this->observationService->createPatientObservation($data['observation']);
                    }
                break;

                case 'staff':
                    $user = $this->userService->createStaff($request->all());
                break;

                default:
                    return response()->json(['error' => 'Unrecognized role'], 400);
                break;

            }
            $user = new UserResource($user);

            return response()->json($user, 201);

        } catch (\Exception $e) {
            Log::error("Unable to create user: ". $e->getMessage());
            return response()->json('Failed creating user', 400);
        }
    }
}
