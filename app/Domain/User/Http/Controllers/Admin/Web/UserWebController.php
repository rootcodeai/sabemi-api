<?php

namespace App\Domain\User\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Domain\User\Services\UserService;
use App\Domain\User\Http\Requests\Admin\User\FilterUserRequest;
use App\Support\Traits\HasErrorLogging;
use Exception;

final class UserWebController extends Controller
{
    use HasErrorLogging;

    public function __construct(
        private readonly UserService $service,
    ) {}

    public function index(FilterUserRequest $request)
    {
        try {
            $filters = $request->getFilters();
            $users = $this->service->index($filters)->withQueryString();
            return view('admin.users.index', compact('users'));
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao listar usuários', get_called_class().'@'.__FUNCTION__);
            return redirect()->back()->withErrors(['message' => 'Erro ao listar usuários.']);
        }
    }
}
