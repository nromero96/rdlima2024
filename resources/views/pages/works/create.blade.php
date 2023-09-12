@extends('layouts.app')


@section('content')


<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-spacing">
            <div class="col-lg-12 layout-top-spacing mt-4">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 mb-2 col-12">
                                <h4>
                                    {{__("Información del trabajo")}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <form class="row g-3" action="{{ route('works.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputAreaConocimento" class="form-label fw-bold">{{__("Area de conocimiento")}}</label>
                                <select name="knowledge_area" class="form-select" id="inputAreaConocimento">
                                    <option value="">{{ __('Seleccione...') }}</option>
                                    <option value="Acné y dermatosis acneiformes">Acné y dermatosis acneiformes</option>
                                    <option value="Rosácea">Rosácea</option>
                                    <option value="Alteraciones en el pigmento">Alteraciones en el pigmento</option>
                                    <option value="Dermatosis neoplásicas">Dermatosis neoplásicas</option>
                                    <option value="Cirugía dermatológica">Cirugía dermatológica</option>
                                    <option value="Dermatología cosmética">Dermatología cosmética</option>
                                    <option value="Dermatología pediátrica">Dermatología pediátrica</option>
                                    <option value="Dermatología y medicina interna">Dermatología y medicina interna</option>
                                    <option value="Dermatosis infecciosas">Dermatosis infecciosas</option>
                                    <option value="Dermatosis por agentes físicos, químicos y mecánicos">Dermatosis por agentes físicos, químicos y mecánicos</option>
                                    <option value="Dermatosis autoinmunes">Dermatosis autoinmunes</option>
                                    <option value="Terapéutica dermatológica">Terapéutica dermatológica</option>
                                    <option value="Manejo de heridas y úlceras">Manejo de heridas y úlceras</option>
                                    <option value="Dermatosis de anexos cutáneos">Dermatosis de anexos cutáneos</option>
                                    <option value="Dermatosis vasculares">Dermatosis vasculares</option>
                                    <option value="Dermatosis genéticas">Dermatosis genéticas</option>
                                    <option value="Dermatosis ampollares">Dermatosis ampollares</option>
                                    <option value="Dermatosis psicosomáticas, neurogénicas y psicogénicas">Dermatosis psicosomáticas, neurogénicas y psicogénicas</option>
                                    <option value="Métodos de diagnósticos en dermatología">Métodos de diagnósticos en dermatología</option>
                                    <option value="Biología molecular en dermatología">Biología molecular en dermatología</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="inputCategory" class="form-label fw-bold">{{__("Categoría del trabajo")}}</label>
                                <select name="category" class="form-select" id="inputCategory">
                                    <option value="">Seleccione...</option>
                                    <option value="Dermatólogo Joven">Dermatólogo Joven</option>
                                    <option value="Trabajo de Investigación Científica">Trabajo de Investigación Científica</option>
                                    <option value="Mini Caso">Mini Caso</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="inputAuthor_coauthors" class="form-label fw-bold">{{__("Nombre y apellidos:")}} (<small class="text-info">{{ __('Colocar primero al autor principal, seguido de los coautores, separado por comas.') }}</small>)</label>
                                <input type="text" name="author_coauthors" class="form-control" id="inputAuthor_coauthors">
                            </div>

                            <div class="col-md-12">
                                <label for="inputInstitution" class="form-label fw-bold">{{__("Coloque el nombre completo de la institución seguido de la ciudad y el pais.")}}</label>
                                <input type="text" name="institution" class="form-control" id="inputInstitution">
                            </div>

                            <div class="col-md-12">
                                <hr class="my-0">
                                <h6 class="mb-0 mt-2">{{__("Datos del Autor Ponente / Presentador")}}</h6>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{__("Nombre Completo")}}</label>
                                <p class="form-control">{{$user->name}} {{$user->lastname}} {{$user->second_lastname}} </p>
                            </div>

                            <div class="col-md-12">
                                <label for="inputTitle" class="form-label fw-bold">{{__("Título del trabajo")}}</label>
                                <input type="text" name="title" class="form-control" id="inputTitle">
                            </div>

                            <div class="col-md-12">
                                <label for="inputDescription" class="form-label fw-bold">{{__("Cuerpo del trabajo")}} (<small class="text-info">Síga las instrucciones de las bases.</small>)</label>
                                <textarea name="description" class="form-control" id="inputDescription" rows="15"></textarea>
                                <span id="charCount">0 / 5000</span>
                            </div>

                            <div class="col-md-12">
                                <label for="inputFile_1" class="form-label fw-bold">{{__("Fotografías, Gráficos y Tablas")}} (<small class="text-info">Maximo 6 archivos en total.</small>)</label>
                                <input type="file" name="file_1" class="form-control-file" id="inputFile_1">
                                <input type="file" name="file_2" class="form-control-file mt-2" id="inputFile_2">
                                <input type="file" name="file_3" class="form-control-file mt-2" id="inputFile_3">
                                <input type="file" name="file_4" class="form-control-file mt-2" id="inputFile_4">
                                <input type="file" name="file_5" class="form-control-file mt-2" id="inputFile_5">
                                <input type="file" name="file_6" class="form-control-file mt-2" id="inputFile_6">
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" name="action" class="btn btn-primary" value="borrador">{{__("Borrador")}}</button>
                                <button type="submit" name="action" class="btn btn-primary" value="finalizado">{{__("Finalizar")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


@endsection