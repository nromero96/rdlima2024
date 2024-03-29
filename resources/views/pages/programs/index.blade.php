@extends('layouts.app')


@section('content')


<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-spacing">
            <div class="col-lg-12 layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header pt-4">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-end">
                                <a href="{{ route('programs.create') }}" class="btn btn-primary mb-4 ms-3 me-3">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 5v14"></path>
                                        <path d="M5 12h14"></path>
                                      </svg>
                                    {{__("Agregar")}}
                                </a>
                                <a href="{{ route('programsessions.index') }}" class="btn btn-success mb-4 ms-2 me-2">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    {{__("Sesiones")}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__("Nombre")}}</th>
                                        <th scope="col">{{__("País")}}</th>
                                        <th scope="col">{{__("Correo")}}</th>
                                        <th scope="col">{{__("Teléfono")}}</th>
                                        <th scope="col">{{__("")}}</th>
                                        <th scope="col">{{__("Fecha")}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programs as $program)
                                        <tr>
                                            <td>
                                                {{$program->full_name}}
                                            </td>
                                            <td>
                                                {{$program->country}}
                                            </td>
                                            <td>
                                                {{$program->email}}
                                            </td>
                                            <td>
                                                +{{$program->phone_code}} {{$program->phone}}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('storage/uploads/invitation_letters').'/'. $program->file_name}}" target="_blank" class="btn btn-primary">{{__("Ver")}}</a>
                                            </td>
                                            <td class="text-center">
                                                {{$program->created_at}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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