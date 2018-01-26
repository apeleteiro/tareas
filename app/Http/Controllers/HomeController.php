<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarea;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tareas = Tarea::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('home', ['tareas' => $tareas]);
    }

    public function crearTarea(Request $request)
    {
        $tarea = new Tarea();
        $tarea->texto = $request->texto;
        $tarea->user_id = Auth::id();
        $tarea->save();

        return redirect('/home');
    }
}
