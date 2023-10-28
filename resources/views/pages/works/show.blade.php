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
                        <div class="row g-3" id="print_work">
                            <div class="col-md-6">
                                <label for="inputAreaConocimento" class="form-label fw-bold">{{__("Area de conocimiento")}}:</label>
                                <p class="form-control bg-light">{{ $work->knowledge_area }}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="inputCategory" class="form-label fw-bold">{{__("Categoría del trabajo")}}:</label>
                                <p class="form-control bg-light">{{ $work->category }}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{__("Nombre y apellidos")}}:</label>
                                <p class="form-control bg-light">{{ $work->author_coauthors }}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{__("Coloque el nombre completo de la institución seguido de la ciudad y el pais")}}:</label>
                                <p class="form-control bg-light">{{ $work->institution }}</p>
                            </div>

                            <div class="col-md-12">
                                <hr class="my-0">
                                <h6 class="mb-0 mt-2">{{__("Datos del Autor Ponente / Presentador")}}</h6>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{__("Nombre Completo")}}:</label>
                                <p class="form-control bg-light">{{$work->name}} {{$work->lastname}} {{$work->second_lastname}} </p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{__("Título del trabajo")}}:</label>
                                <p class="form-control bg-light">{{ $work->title }}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{__("Cuerpo del trabajo")}}:</label>
                                <p class="form-control bg-light">{!! nl2br(e($work->description)) !!}</p>
                            </div>

                            <div class="col-md-12 @if($work->category != 'Mini Caso') @else d-none  @endif" id="dv_references">
                                <label class="form-label fw-bold">{{__("Referencias bibliográficas")}}</label>
                                <p class="form-control bg-light">{!! nl2br(e($work->references)) !!}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{__("Fotografías, Gráficos y Tablas")}}:</label>
                            </div>
                            @if ($work->file_1)
                            <div class="col-md-4">
                                <div class="form-control bg-light text-center" id="dv_fileshow_1">
                                    {{ strlen($work->file_1) > 25 ? substr($work->file_1, 0, 25) . '...' : $work->file_1 }}
                                    <div class="text-center mt-2">
                                        <a href="{{ asset('storage/uploads/abstract_file').'/'.$work->file_1}}" class="badge badge-light-primary text-start me-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Descargar" target="_blank" download> 
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m7 10 5 5 5-5"></path><path d="M12 15V3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if ($work->file_2)
                            <div class="col-md-4">
                                <div class="form-control bg-light text-center" id="dv_fileshow_2">
                                    {{ strlen($work->file_2) > 25 ? substr($work->file_2, 0, 25) . '...' : $work->file_1 }}
                                    <div class="text-center mt-2">
                                        <a href="{{ asset('storage/uploads/abstract_file').'/'.$work->file_2}}" class="badge badge-light-primary text-start me-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Descargar" target="_blank" download> 
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m7 10 5 5 5-5"></path><path d="M12 15V3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if ($work->file_3)
                            <div class="col-md-4">
                                <div class="form-control bg-light text-center" id="dv_fileshow_3">
                                    {{ strlen($work->file_3) > 25 ? substr($work->file_3, 0, 25) . '...' : $work->file_1 }}
                                    <div class="text-center mt-2">
                                        <a href="{{ asset('storage/uploads/abstract_file').'/'.$work->file_3}}" class="badge badge-light-primary text-start me-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Descargar" target="_blank" download> 
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m7 10 5 5 5-5"></path><path d="M12 15V3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if ($work->file_4)
                            <div class="col-md-4">
                                <div class="form-control bg-light text-center" id="dv_fileshow_4">
                                    {{ strlen($work->file_4) > 25 ? substr($work->file_4, 0, 25) . '...' : $work->file_1 }}
                                    <div class="text-center mt-2">
                                        <a href="{{ asset('storage/uploads/abstract_file').'/'.$work->file_4}}" class="badge badge-light-primary text-start me-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Descargar" target="_blank" download> 
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m7 10 5 5 5-5"></path><path d="M12 15V3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
            
                            @if ($work->file_5)
                            <div class="col-md-4">
                                <div class="form-control bg-light text-center" id="dv_fileshow_5">
                                    {{ strlen($work->file_5) > 25 ? substr($work->file_5, 0, 25) . '...' : $work->file_5 }}
                                    <div class="text-center mt-2">
                                        <a href="{{ asset('storage/uploads/abstract_file').'/'.$work->file_5}}" class="badge badge-light-primary text-start me-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Descargar" target="_blank" download> 
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m7 10 5 5 5-5"></path><path d="M12 15V3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($work->file_6)
                            <div class="col-md-4">
                                <div class="form-control bg-light text-center" id="dv_fileshow_6">
                                    {{ strlen($work->file_6) > 25 ? substr($work->file_6, 0, 25) . '...' : $work->file_6 }}
                                    <div class="text-center mt-2">
                                        <a href="{{ asset('storage/uploads/abstract_file').'/'.$work->file_6}}" class="badge badge-light-primary text-start me-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Descargar" target="_blank" download> 
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m7 10 5 5 5-5"></path><path d="M12 15V3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


@endsection