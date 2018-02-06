<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarea;
use Auth;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if(session()->has('idioma')) {
                App::setLocale(session()->get('idioma'));
            }

            return $next($request);
        });

//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tareas = Tarea::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(5);

        return view('home', ['tareas' => $tareas]);
    }

    public function crearTarea(Request $request)
    {
        $this->validate($request, [
            'texto' => 'bail|required|string|max:191'
        ]);

//        if ('' == $request->texto) {
//            session()->flash('msg', 'No se ha podido realizar la operación.');
//            session()->flash('tipoAlerta', 'warning');
//            return redirect('/home');
//        }

        $tarea = new Tarea();
        $tarea->texto = $request->texto;
        $tarea->user_id = Auth::id();
        $tarea->save();

        session()->flash('msg', 'Tarea creada de manera satisfactoria.');
        session()->flash('tipoAlerta', 'success');
        return redirect('/home');
    }

    public function cambiarEstado($id, $estado)
    {
        if (!isset($id) || !isset($estado)) {
            session()->flash('msg', 'No se ha podido realizar la operación.');
            session()->flash('tipoAlerta', 'warning');
            return redirect('/home');
        }

        $tarea = Tarea::find($id);

        if ($tarea->user_id === Auth::id()) {
            switch ($estado) {
                case 1:
                    $tarea->estado = 'En proceso';
                    break;
                case 2:
                    $tarea->estado = 'Completada';
                    break;
            }

            $tarea->save();
        }

        session()->flash('msg', 'Estado cambiado de manera satisfactoria.');
        session()->flash('tipoAlerta', 'success');
        return redirect('/home');
    }

    public function eliminar($id)
    {
        if (!isset($id)) {
            session()->flash('msg', 'No se ha podido realizar la operación.');
            session()->flash('tipoAlerta', 'warning');
            return redirect('/home');
        }

        $tarea = Tarea::find($id);

        if ($tarea->user_id === Auth::id()) {
            $tarea->delete();
        }

        session()->flash('msg', 'Tarea eliminada de manera satisfactoria.');
        session()->flash('tipoAlerta', 'danger');
        return redirect('/home');
    }
}
