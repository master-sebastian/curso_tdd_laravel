<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;
/**
 *  Este controlador tiene las funcionalidad respetivas para efectuar un crud completo
 */
class RepositoryController extends Controller
{
    
    /** 
     * Crear un nuevo repositorio considerando el usuario que se invocucra en el request
     * @param Request $request Objeto request
     * @return redirect Rediecciona a una ruta especificada dentro de este metodo
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
     * Permite modificar la informacion de forma completa del repositorio considerando que le debe pertenecer al usuario
     * para efectuar su respectiva modificacion
     * @param Request $request objeto request
     * @param Repository $repository objeto del modelo repositorio
     * @return redirect Redirecciona a una ruta especificada dentro de este metodo
     */
    public function update(Request $request, Repository $repository)
    {
        $request->validate([
            'url' => 'required',
            'description' => 'required',
        ]);
        if ($request->user()->id != $repository->user_id) {
            abort(403);
        }
        $repository->update($request->all());

        return redirect()->route('repositories.edit', $repository);
    }

    /**
     * Se utiliza para eliminar un repositorio que le pertenezca a un usuario especifico
     * @param Request $request objeto request
     * @param Repository $repository objeto del modelo repositorio
     * @return redirect Retorna a una ruta especificada dentro de este metodo
     */
    public function destroy(Request $request, Repository $repository)
    {
        if ($request->user()->id != $repository->user_id) {
            abort(403);
        }
        $repository->delete();

        return redirect()->route('repositories.index');
    }
    
    /**
     * Se utiliza para listar todos los repositorios que le pertenezcan
     * @param Request $request objeto request
     * @return View carga una vista
     */
    public function index(Request $request)
    {
        return view('repositories.index', [
            'repositories' => $request->user()->repositories
        ]);
    }
    
    /**
     * Se utiliza para ver un repositorio espeficio que le pertezca a un usuario puntual
     * @param Request $request objeto request
     * @return View carga una vista
     */
    public function show(Request $request, Repository $repository)
    {
        if ($request->user()->id != $repository->user_id) {
            abort(403);
        }
        return view('repositories.show', compact('repository'));
    }
}