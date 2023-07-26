<?php

namespace App\UserInterface\Controller\User;

use App\Application\User\UpdateUserUseCase;
use App\Infrastructure\Laravel\Controller;
use App\UserInterface\Requests\Auth\RegisterFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

class UpdateUserController extends Controller
{
    private UpdateUserUseCase $updateUserUseCase;

    public function __construct(UpdateUserUseCase $updateUserUseCase) {
        $this->updateUserUseCase = $updateUserUseCase;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterFormRequest $request, string $id)
    {
        try {
            $user = $this->updateUserUseCase->__invoke(
                $request->input('name'),
                $request->input('last_name'),
                $request->input('email'),
                $request->input('identification'),
                $request->input('is_verified'),
                $request->input('password'),
                $id
            );

            return Response::json([
                'data' => $user->asArray()
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return Response::json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
