@extends('layouts.app')

@section('content')
    <div class="modal fade" id="crearTarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear tarea</h5>
                </div>
                <form action="{{ url('crear-tarea') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="text" name="texto" class="form-control" placeholder="Describe la tarea">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Crear tarea">
                    </div>
                </form>
            </div>
        </div>
    </div>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearTarea">
                    <i class="fa fa-plus"> Tarea</i>
                </button>
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Mis tareas</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        @forelse($tareas as $tarea)
                            <tr>
                                <td>{{ $tarea->texto }}</td>
                                <td>{{ $tarea->estado }}</td>
                                <td>
                                    AA
                                </td>
                            </tr>
                        @empty
                            No hay tareas para mostrar.
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
