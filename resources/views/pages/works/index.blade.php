@extends('layouts.app')


@section('content')


<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-spacing">
            <div class="col-lg-12 layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    @php
                            $user = Auth::user();
                            //get user logged role
                            $userRole = $user->roles->pluck('name')->toArray();
                    @endphp
                    
                    @if($user->confir_information == '' && $userRole[0] != 'Administrador')
                            <div class="alert alert-danger text-center" role="alert">
                                <strong>{{__("¡Atención!")}}</strong> {{__("Debes completar tu información personal para poder enviar su trabajo.")}}<br><br>
                                <a href="{{ route('users.myprofile') }}" class="btn btn-primary mb-4 ms-3 me-3">{{__("Completar Información")}}</a>
                            </div>
                    @else
                    <div class="widget-header pt-4">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-end">
                                <a href="{{ route('works.create') }}" class="btn btn-primary mb-4 ms-3 me-3">{{__("Trabajo Nuevo")}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__("Area de conocimiento")}}</th>
                                        <th scope="col">{{__("Categoría del trabajo")}}</th>
                                        <th scope="col">{{__("Título del trabajo")}}</th>
                                        <th scope="col">{{__("Estado")}}</th>
                                        <th scope="col">{{__("Fecha")}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($works->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <h6 class="mt-2">{{__("No hay trabajos registradss")}}</h6>
                                                <a href="{{ route('works.create') }}" class="btn btn-primary mb-4 ms-3 me-3">{{__("Nuevo Trabajo")}}</a>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($works as $work)
                                            <tr>
                                                <td>
                                                    {{$work->knowledge_area}}
                                                </td>
                                                <td>
                                                    {{$work->category}}
                                                </td>
                                                <td>
                                                    {{$work->title}}
                                                </td>
                                                <td>
                                                    {{$work->status}}
                                                </td>
                                                <td class="text-center">
                                                    {{$work->created_at}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>


@endsection

<script>
// JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los formularios de eliminación
    var deleteForms = document.querySelectorAll('.deleteForm');

    // Agregar controlador de eventos de clic a cada botón de eliminación
    deleteForms.forEach(function(form) {
        var deleteButton = form.querySelector('.btn-delete');
        deleteButton.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm("{{ __('Are you sure you want to delete this user?') }}")) {
                form.submit();
            }
        });
    });
});


</script>