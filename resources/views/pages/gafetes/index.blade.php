@extends('layouts.app')


@section('content')


<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{__("Éxito")}}!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{__("Error")}}!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="statbox widget box box-shadow">
                    <div class="widget-header pb-2 pt-2">
                        <form action="{{ route('gafetes.index') }}" method="GET" class="mb-0" >
                            <div class="row">
                                <div class="col-md-2 align-self-center">
                                    <h4>Asistencia</h4>
                                </div>
                                <div class="col-md-1 align-self-center ps-0">
                                    <select name="listforpage" class="form-select form-control-sm ms-0" id="listforpage" onchange="this.form.submit()">
                                        <option value="10" {{ request('listforpage') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('listforpage') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('listforpage') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('listforpage') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                                <div class="col-md-4 align-self-center">
                                    
                                </div>
                                <div class="col-md-5 align-self-center text-start">
                                    <div class="input-group">
                                        <input type="text" class="form-control mb-2 mb-md-0" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                                        @if(request('search') != '')
                                            <a href="{{ route('inscriptions.index') }}" class="btn btn-outline-light px-1" id="button-addon2" style="border-left: 0px;border-color: #bfc9d4;background: white;">
                                                <svg width="24" height="24" fill="none" stroke="#9e9e9e" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 2a10 10 0 1 0 0 20 10 10 0 1 0 0-20z"></path>
                                                    <path d="m15 9-6 6"></path>
                                                    <path d="m9 9 6 6"></path>
                                                </svg>
                                            </a>
                                        @endif
                                        <button type="submit" class="btn btn-primary" id="button-addon2">Buscar</button>
                                    </div>
                                    <small class="text-muted">Por: Inscripción, Nombre, País</small>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col"><b>{{__("ID INS.")}}</b></th>
                                        <th scope="col"><b>{{__("Participante")}}</b></th>
                                        <th scope="col"><b>{{__("País")}}</b></th>
                                        <th scope="col"><b>{{__("Asistencía")}}</b></th>
                                        <th scope="col" class="px-1 text-center" style="width: 135px;"><b>{{__("Gaféte/Solapín")}}</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inscriptions as $inscription)
                                        <tr>
                                            <td><a href="{{ route('inscriptions.show',$inscription->id) }}" target="_blank" class="text-info">#{{ $inscription->id }}</a></td>
                                            <td>{{$inscription->user_name.' '.$inscription->user_lastname.' '.$inscription->user_second_lastname}}<br> 
                                                <small class="text-muted d-block"><b>Gafete/Solapín: </b>{{ $inscription->solapin_name }}</small>
                                            </td>
                                            <td>{{ $inscription->user_country }}</td>
                                            <td>
                                                <div class="form-check d-block">
                                                    <input class="form-check-input checkasispart" type="checkbox" value="" id="flexCheck{{ $inscription->id }}part">
                                                    <label class="form-check-label ps-1" for="flexCheck{{ $inscription->id }}part">
                                                    Participante
                                                    </label>
                                                </div>

                                                @if($inscription->accompanist_id)
                                                    <div class="form-check d-block">
                                                        <input class="form-check-input checkasisacomp" type="checkbox" value="" id="flexCheck{{ $inscription->id }}acomp">
                                                        <label class="form-check-label label ps-1 mb-0" for="flexCheck{{ $inscription->id }}acomp">
                                                        Acompañante
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-1 py-1 text-start">
                                                <a href="{{ route('gafetes.gafeteforparticipant',$inscription->id) }}" class="btn btn-primary px-1 py-1 d-block btngaftpart disabled" target="_blank">
                                                    <svg width="21" height="21" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M21 5H3a1 1 0 0 0-1 1v3.5h.6a2.5 2.5 0 0 1 0 5H2V18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-3.5h-.1a2.5 2.5 0 0 1 0-5h.1V6a1 1 0 0 0-1-1Z"></path>
                                                        <path stroke-dasharray="3 3" d="M15 5v14"></path>
                                                    </svg>
                                                    Participante
                                                </a>
                                                @if($inscription->accompanist_id)
                                                    <a href="{{ route('gafetes.gafeteforaccompanist','3') }}" class="btn px-1 py-1 btn-info d-block mt-1 btngaftacomp disabled" target="_blank" >
                                                        <svg width="21" height="21" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21 5H3a1 1 0 0 0-1 1v3.5h.6a2.5 2.5 0 0 1 0 5H2V18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-3.5h-.1a2.5 2.5 0 0 1 0-5h.1V6a1 1 0 0 0-1-1Z"></path>
                                                            <path stroke-dasharray="3 3" d="M15 5v14"></path>
                                                        </svg>
                                                        Acompañante
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="row mx-0 mt-1">
                            <div class="col-md-7">
                                <div class="">
                                    {{ $inscriptions->onEachSide(1)->withQueryString()->links() }}
                                </div>
                            </div>
                            <div class="col-md-5 mt-1">
                                <p class="text-end">Mostrando página {{ $inscriptions->currentPage() }} de {{ $inscriptions->lastPage() }} ({{ $inscriptions->total() }})</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    var isAdmin = @json(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Secretaria'));

    // Checkboxes checkasispart
    var checkasispart = document.querySelectorAll('.checkasispart');
    // Checkboxes checkasisacomp
    var checkasisacomp = document.querySelectorAll('.checkasisacomp');

    checkasispart.forEach(function(checkasispart) {
        checkasispart.addEventListener('change', function() {
            var btngaftpart = this.parentElement.parentElement.parentElement.querySelector('.btngaftpart');
            if(this.checked) {
                btngaftpart.classList.remove('disabled');
            } else {
                btngaftpart.classList.add('disabled');
            }
        });
    });

    checkasisacomp.forEach(function(checkasisacomp) {
        checkasisacomp.addEventListener('change', function() {
            var btngaftacomp = this.parentElement.parentElement.parentElement.querySelector('.btngaftacomp');
            if(this.checked) {
                btngaftacomp.classList.remove('disabled');
            } else {
                btngaftacomp.classList.add('disabled');
            }
        });
    });

</script>


@endsection