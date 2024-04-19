@extends('layouts.app')


@section('content')


<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-spacing">
            <div class="col-lg-12 layout-top-spacing mt-4">

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
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <h4>
                                    {{__("Gafétes/Solapínes")}}
                                </h4>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="input-group mt-2 mb-1 pe-3">
                                    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Buscar por ID de inscripción o Nombres" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary" type="button" id="button-addon2">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col"><b>{{__("ID inscripción")}}</b></th>
                                    <th scope="col"><b>{{__("Participante")}}</b></th>
                                    <th scope="col"><b>{{__("País")}}</b></th>
                                    <th scope="col"><b>{{__("Gaféte/Solapín")}}</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inscriptions as $inscription)
                                    <tr>
                                        <td>#{{ $inscription->id }}</td>
                                        <td>John Doe</td>
                                        <td>Guatemala</td>
                                        <td>
                                            <a href="{{ route('gafetes.gafeteforparticipant',$inscription->id) }}" class="btn btn-primary me-1">Participante</a>
                                            <a href="{{ route('gafetes.gafeteforaccompanist','3') }}" class="btn btn-info">Acompañante</a>
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


@endsection