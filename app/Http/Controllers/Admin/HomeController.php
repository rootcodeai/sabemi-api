<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Traits\HasErrorLogging;
use Exception;

final class HomeController extends Controller
{
    use HasErrorLogging;

    public function index()
    {
        try {
            return view('admin.home.index');
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao carregar dashboard', get_called_class().'@'.__FUNCTION__);
            return redirect()->back()->withErrors(['message' => 'Erro ao carregar o painel.']);
        }
    }
}
