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
                                            <th scope="col">{{__("Pago")}}</th>
                                            <th scope="col">{{__("Estado")}}</th>
                                            <th scope="col">{{__("Fecha")}}</th>
                                            <th scope="col"></th>
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
                                                        {{$inscription->user_name.' '.$inscription->user_lastname.' '.$inscription->user_second_lastname}}
                                                    </td>
                                                    <td>
                                                        {{$inscription->category_inscription_name}}
                                                    </td>
                                                    <td>
                                                        US$ {{$inscription->total}}
                                                    </td>
                                                    <td>
                                                        {{$inscription->status}}
                                                    </td>
                                                    <td>
                                                        {{ $inscription->created_at->format('d-m-Y') }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="badge badge-light-info text-start me-2 action-edit" href="{{ route('inscriptions.show', $inscription->id)}}">                                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M21.257 10.962c.474.62.474 1.457 0 2.076C19.764 14.987 16.182 19 12 19c-4.182 0-7.764-4.013-9.257-5.962a1.692 1.692 0 0 1 0-2.076C4.236 9.013 7.818 5 12 5c4.182 0 7.764 4.013 9.257 5.962z"></path>
                                                                <path d="M12 9a3 3 0 1 0 0 6 3 3 0 1 0 0-6z"></path>
                                                            </svg>
                                                        </a>
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