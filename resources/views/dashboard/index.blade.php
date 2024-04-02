@extends('layouts.app')


@section('content')

<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-top-spacing">
            <div class="col-sm-6 mb-3 mb-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{__("Hola,")}} <b>{{ Auth::user()->name }}</b></h5>
                        <p class="card-text">{{__("Bienvenido a la RADLA 2024")}}</p>
                        <a href="#" class="btn btn-info" disabled>¡Pronto podrás descargar tu solapín aquí!</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 mb-3 mb-sm-3">
                <div class="card bg-primary">
                  <div class="card-body">
                    <h5 class="card-title mb-0">{{__("El evento empieza en:")}}</h5>
                    {{-- Aqui el contador --}}

                    <div id="msmencurso" class="pt-2 pb-2 d-none" style="font-size: 17px;">
                        {{-- Mensaje --}}
                        EVENTO EN CURSO
                    </div>

                    <div id="contador" class="d-flex mb-1">
                        <div class="text-white"><span id="dias" style="font-size: 25px;font-weight: bolder;"></span> <small style="font-size: 15px;">DÍAS Y </small><span id="horas" style="font-size: 25px;font-weight: bolder;"></span> <small style="font-size: 15px;">HORAS</small></div>
                    </div>
                    <a href="{{ route('onlineprograms') }}" target="_blank" class="btn btn-light text-dark"><b>VER PROGRAMA</b></a>
                  </div>
                </div>
            </div>

            @if (Auth::user()->hasRole('Administrador'))
            
            @endif
        </div>

    </div>

</div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function calcularTiempoRestante(fechaLimite) {
            const ahora = new Date();
            const fechaLimiteObj = new Date(fechaLimite);
            const tiempoRestante = fechaLimiteObj - ahora;

            if (tiempoRestante <= 0) {
                document.getElementById('contador').classList.add('d-none');
                document.getElementById('msmencurso').classList.remove('d-none');
                return;
            }

            const dias = Math.floor(tiempoRestante / (1000 * 60 * 60 * 24));
            const horas = Math.floor((tiempoRestante % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            document.getElementById('dias').textContent = dias;
            document.getElementById('horas').textContent = horas;
        }

        function actualizarContador() {
            const fechaLimite = new Date("2024-05-08T08:00:00");
            calcularTiempoRestante(fechaLimite);
        }

        // Actualizar el contador al cargar la página
        actualizarContador();

        // Actualizar el contador cada 20 minutos
        setInterval(actualizarContador, 1200000); // 1200000 ms = 20 minutos
    });
</script>
