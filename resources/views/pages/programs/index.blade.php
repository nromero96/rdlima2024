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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__("Nombre")}}</th>
                                        <th scope="col">{{__("Tema")}}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                    function hex2rgba($color, $opacity = false) {
                                        $default = 'rgb(0,0,0)';
                                        if(empty($color))
                                            return $default; 
                                        if ($color[0] == '#')
                                            $color = substr($color, 1);
                                        if (strlen($color) == 6)
                                            $hex = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);
                                        elseif (strlen($color) == 3)
                                            $hex = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
                                        else
                                            return $default;
                                        $rgb =  array_map('hexdec', $hex);
                                        if($opacity !== false){
                                            if(abs($opacity) > 1)
                                                $opacity = 1.0;
                                            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
                                        } else {
                                            $output = 'rgb('.implode(",",$rgb).')';
                                        }
                                        return $output;
                                    }
                                    @endphp

                                    @php
                                        $prevName = '';
                                    @endphp

                                    @foreach ($programs as $program)

                                        @php
                                            $fullName = $program->apellido . $program->nombre;
                                            $color = '#' . substr(md5($fullName), 0, 6); // Genera un color aleatorio basado en el nombre completo
                                            $rgbaColor = hex2rgba($color, 0.3); // Agrega transparencia al color    
                                        @endphp

                                        <tr style="background-color: {{$rgbaColor}};">
                                            <td>
                                                @if ($program->apellido . $program->nombre !== $prevName)
                                                    INS <a href="{{ route('inscriptions.show', $program->insc_id) }}" class="text-primary">#{{$program->insc_id}}</a>
                                                    <b class="d-block">{{$program->apellido}} {{$program->nombre}}</b>
                                                    <small class="d-block">{{$program->status}} - {{$program->pais}}</small>
                                                    @php
                                                        $prevName = $program->apellido . $program->nombre;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                <small class="d-block">{{$program->sesion}} - {{$program->sala}} - {{$program->fecha}} ({{$program->bloque}})</small>
                                                <small style="font-weight: bold;">{{$program->inicio}} - {{$program->termino}}</small> {{ \Illuminate\Support\Str::limit($program->tema, 50, '...') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('programs.edit', $program->id) }}" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="{{ __("Editar") }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                </a>
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