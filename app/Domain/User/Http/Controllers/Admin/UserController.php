<?php

namespace App\Domain\User\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\User\Services\UserService;
use App\Domain\User\Http\Requests\Admin\User\UserCreateFormRequest;
use App\Domain\User\Http\Requests\Admin\User\UserUpdateFormRequest;
use App\Domain\User\Http\Requests\Admin\User\FilterUserRequest;
use App\Domain\User\Http\Resources\Admin\User\UserResource;
use App\Domain\User\Http\Resources\Admin\User\UserCollect;
use App\Support\Traits\HasErrorLogging;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

final class UserController extends Controller
{
    use HasErrorLogging;

    public function __construct(
        private readonly UserService $service,
    ) {}

    public function index(FilterUserRequest $request): JsonResponse|UserCollect
    {
        try {
            $filters = $request->getFilters();
            $result = $this->service->index($filters);
            return new UserCollect($result);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao listar usuários', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao listar usuários.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(UserCreateFormRequest $request): JsonResponse|UserResource
    {
        try {
            $result = $this->service->store($request->validatedData());
            return (new UserResource($result))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao criar usuário', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao criar usuário.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id): JsonResponse|UserResource
    {
        try {
            $result = $this->service->show($id);
            return new UserResource($result);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao exibir usuário', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao exibir usuário.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UserUpdateFormRequest $request, int $id): JsonResponse|UserResource
    {
        try {
            $result = $this->service->update($id, $request->validatedData());
            return new UserResource($result);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao atualizar usuário', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao atualizar usuário.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Usuário removido com sucesso.'], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao remover usuário', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao remover usuário.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
