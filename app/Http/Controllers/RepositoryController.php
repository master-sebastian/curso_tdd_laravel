<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    /**
     * @param Request $request Solcitud de un cliente que quiere crear un registro
     * @return redirect Retorna a una ruta especificada dentro de este metodo
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
            'description' => 'required',
        ]);
        $request->user()->repositories()->create($request->all());

        return redirect()->route('repositories.index');
    }
    /**
     * @param Request $request Solcitud de un cliente que quiere modificar un registro
     * @return redirect Retorna a una ruta especificada dentro de este metodo
     */
    public function update(Request $request, Repository $repository)
    {
        $request->validate([
            'url' => 'required',
            'description' => 'required',
        ]);
        $repository->update($request->all());

        return redirect()->route('repositories.edit', $repository);
    }
}