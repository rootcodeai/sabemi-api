<?php

namespace App\Domain\User\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Domain\User\Services\UserService;
use App\Domain\User\Http\Requests\Admin\User\FilterUserRequest;
use App\Domain\User\Http\Requests\Admin\User\UserCreateFormRequest;
use App\Domain\User\Http\Requests\Admin\User\UserUpdateFormRequest;
use App\Support\Traits\HasErrorLogging;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function create()
    {
        try {
            return view('admin.users.create');
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao carregar formulário de criação', get_called_class().'@'.__FUNCTION__);
            return redirect()->route('admin.users.index')->withErrors(['message' => 'Erro ao carregar formulário.']);
        }
    }

    public function store(UserCreateFormRequest $request)
    {
        try {
            $this->service->store($request->validatedData());
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Usuário criado com sucesso.');
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao criar usuário', get_called_class().'@'.__FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['message' => 'Erro ao criar usuário.']);
        }
    }

    public function edit(int $id)
    {
        try {
            $user = $this->service->show($id);
            return view('admin.users.edit', compact('user'));
        } catch (ModelNotFoundException) {
            return redirect()->route('admin.users.index')->withErrors(['message' => 'Usuário não encontrado.']);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao carregar usuário', get_called_class().'@'.__FUNCTION__);
            return redirect()->route('admin.users.index')->withErrors(['message' => 'Erro ao carregar usuário.']);
        }
    }

    public function update(UserUpdateFormRequest $request, int $id)
    {
        try {
            $this->service->update($id, $request->validatedData());
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Usuário atualizado com sucesso.');
        } catch (ModelNotFoundException) {
            return redirect()->route('admin.users.index')->withErrors(['message' => 'Usuário não encontrado.']);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao atualizar usuário', get_called_class().'@'.__FUNCTION__);
            return redirect()->back()->withInput()->withErrors(['message' => 'Erro ao atualizar usuário.']);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->service->destroy($id);
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Usuário removido com sucesso.');
        } catch (ModelNotFoundException) {
            return redirect()->route('admin.users.index')->withErrors(['message' => 'Usuário não encontrado.']);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao remover usuário', get_called_class().'@'.__FUNCTION__);
            return redirect()->back()->withErrors(['message' => 'Erro ao remover usuário.']);
        }
    }
}
