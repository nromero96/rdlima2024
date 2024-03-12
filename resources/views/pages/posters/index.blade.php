@extends('layouts.app')


@section('content')


<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-spacing">
            <div class="col-lg-12 layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header pt-2">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Mis posters</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        
                        @if ($posters->count() > 0)

                            @foreach ($posters as $item)
                                <div class="card p-2 mb-3">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-12 border-right">
                                                    <b>Título:</b> {{ $item->title }}
                                                    <hr class="my-0">
                                                </div>
                                                <div class="col-md-6">
                                                    <b>Categoría:</b><br>
                                                    {{ $item->category }}
                                                </div>
                                                <div class="col-md-6">
                                                    <b>Area de conocimiento:</b><br>
                                                    {{ $item->knowledge_area }}
                                                </div>
                                                <div class="col-md-6">
                                                    <b>Autor:</b> <span class="text-capitalize">{{ $item->author }}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>País:</b> {{ $item->country }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <small class="text-center d-block py-4" style="background: #fff7f7;">Pronto podrá subir su poster</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            <p class="text-center">Usted no ha presentado ningún trabajo y por lo tanto no tiene ningún poster para subir.</p>
                        @endif

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