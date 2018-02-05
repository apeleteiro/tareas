@extends('layouts.app')

@section('content')
    <div class="modal fade" id="crearTarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('messages.createTask') }}</h5>
                </div>
                <form action="{{ url('crear-tarea') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="text" name="texto" class="form-control" placeholder="{{ __('messages.writeTask') }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <input type="submit" class="btn btn-primary" value="{{ __('messages.createTask') }}">
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
                    <i class="fa fa-plus"> {{ __('messages.task') }}</i>
                </button>
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('messages.myTasks') }}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        @forelse($tareas as $tarea)
                            @if ($tarea->estado === 'En proceso')
                                <tr class="success">
                            @elseif ($tarea->estado === 'Completada')
                                <tr class="info">
                            @else
                                <tr>
                            @endif
                                <td>{{ $tarea->texto }}</td>
                                <td class="text-right">
                                    @if ($tarea->estado === 'Pendiente')
                                        {{ __('messages.pending') }}
                                    @elseif ($tarea->estado === 'En proceso')
                                        {{ __('messages.progress') }}
                                    @else
                                        {{ __('messages.completed') }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if ($tarea->estado === 'Pendiente')
                                        <a href="{{ url('/cambiar-estado', [$tarea->id, 1]) }}" class="btn btn-success btn-xs"><i class="fa fa-play fa-fw"></i></a>
                                    @endif
                                    @if ($tarea->estado === 'En proceso')
                                        <a href="{{ url('/cambiar-estado', [$tarea->id, 2]) }}" class="btn btn-primary btn-xs"><i class="fa fa-check fa-fw"></i></a>
                                    @endif
                                        <a href="{{ url('eliminar',[$tarea->id]) }}" class="btn btn-danger btn-xs"><i class="fa fa-times fa-fw"></i></a>
                                </td>
                            </tr>
                        @empty
                            {{ __('messages.noTasks') }}
                        @endforelse
                    </table>
                </div>
            </div>
            <div class="text-center">{{ $tareas->links() }}</div>
        </div>
    </div>
</div>
@endsection
