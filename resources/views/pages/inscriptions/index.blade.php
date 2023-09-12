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
                                <strong>{{__("¡Atención!")}}</strong> {{__("Debes completar tu información personal para poder inscribirte.")}}<br><br>
                                <a href="{{ route('users.myprofile') }}" class="btn btn-primary mb-4 ms-3 me-3">{{__("Completar Información")}}</a>
                            </div>
                    @else
                        <div class="widget-header pt-4">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-end">
                                    <a href="{{ route('inscriptions.create') }}" class="btn btn-primary mb-4 ms-3 me-3">{{__("Comprar Nuevo")}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area pt-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{__("Participante")}}</th>
                                            <th scope="col">{{__("Categoría")}}</th>
                                            <th scope="col">{{__("Precio")}}</th>
                                            <th scope="col">{{__("Fecha")}}</th>
                                            <th scope="col">{{__("Acción")}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if ($inscriptions->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h6 class="mt-2">{{__("No hay inscripciones registradas")}}</h6>
                                                    <a href="{{ route('inscriptions.create') }}" class="btn btn-primary mb-4 ms-3 me-3">{{__("Comprar Nuevo")}}</a>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($inscriptions as $inscription)
                                                <tr>
                                                    <td>
                                                        {{$inscription->full_name}}
                                                    </td>
                                                    <td>
                                                        {{$inscription->country}}
                                                    </td>
                                                    <td>
                                                        {{$inscription->email}}
                                                    </td>
                                                    <td>
                                                        +{{$inscription->phone_code}} {{$inscription->phone}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$inscription->created_at}}
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