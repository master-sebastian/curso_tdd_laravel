<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    /**
     * @param Request $request Solcitud del servidor
     * @return redirect Retorna a una ruta especificada dentro de este metodo
     */
    public function store(Request $request)
    {
        $request->user()->repositories()->create($request->all());

        return redirect()->route('repositories.index');
    }
}