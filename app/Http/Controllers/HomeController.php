<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarea;
use App\User;
use Auth;
use App;
use Hash;
use Log;

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
        //$tareas = Tarea::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(5);
        $tareas = User::find(Auth::id())->tareas()->orderBy('created_at', 'desc')->paginate(5);

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

//        $tarea = new Tarea();
//        $tarea->texto = $request->texto;
//        $tarea->user_id = Auth::id();
//        $tarea->save();

        $tarea = new Tarea(['texto' => $request->texto]);
        $usuario = User::find(Auth::id());
        $usuario->tareas()->save($tarea);

        session()->flash('msg', 'Tarea creada de manera satisfactoria.');
        session()->flash('tipoAlerta', 'success');
        return redirect()->route('home');
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
        return redirect()->route('home');
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
        } else {
            Log::notice('Intento de eliminación no permitido.', [
                'id'         => Auth::id(),
                'mombre'     => Auth::user()->name,
                'email'      => Auth::user()->email,
                'tarea'      => $id,
                'tarea_user' => $tarea->user_id,
            ]);
            session()->flash('msg', 'Intento de eliminación no permitido.');
            session()->flash('tipoAlerta', 'danger');
            return redirect()->route('home');
        }

        session()->flash('msg', 'Tarea eliminada de manera satisfactoria.');
        session()->flash('tipoAlerta', 'success');
        return redirect()->route('home');
    }

    public function showConfig()
    {
        return view('config');
    }

    public function cambiarPass(Request $request)
    {
        $this->validate($request, [
            'oldPass' => 'bail|required|string',
            'newPass1' => 'bail|required|string|min:8',
            'newPass2' => 'bail|required|string|min:8'
        ]);

        if (Hash::check($request->oldPass, Auth::user()->password)) {
            if ($request->newPass1 === $request->newPass2) {

                $usuario = User::find(Auth::id());
                $usuario->password = Hash::make($request->newPass1);
                $usuario->save();

                session()->flash('msg', 'Se ha modificado la contraseña.');
                session()->flash('tipoAlerta', 'success');
            } else {

                session()->flash('msg', 'Las contraseñas no coindicen.');
                session()->flash('tipoAlerta', 'danger');
            }
        } else {

            session()->flash('msg', 'La c   ontraseña actual es incorrecta.');
            session()->flash('tipoAlerta', 'danger');
        }

        return redirect()->route('config');
    }
}
