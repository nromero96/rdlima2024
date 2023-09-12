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
                                    {{__("Mi reservación")}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <form class="row g-3" action="{{ route('users.updatemyprofile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4">
                                <label for="inputName" class="form-label fw-bold">{{__("Nombre")}}</label>
                                <input type="text" name="name" class="form-control" id="inputName" value="{{$user->name}}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName" class="form-label fw-bold">{{__("Apellido paterno")}}</label>
                                <input type="text" name="lastname" class="form-control" id="inputLastName" value="{{$user->lastname}}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="inputSecondLastName" class="form-label fw-bold">{{__("Apellido materno")}}</label>
                                <input type="text" name="second_lastname" class="form-control" id="inputSecondLastName" value="{{$user->second_lastname}}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="inputDocumentType" class="form-label fw-bold">{{__("Hotel")}} <span class="text-danger">*</span></label>
                                <select name="document_type" class="form-select" id="inputDocumentType">
                                    <option value="">Seleccione...</option>
                                    <option value="Opción Uno">Opción Uno</option>
                                    <option value="Opción Dos">Opción Dos</option>
                                    <option value="Opción Tres">Opción Tres</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="inputDocumentType" class="form-label fw-bold">{{__("Tipo de habitación")}} <span class="text-danger">*</span></label>
                                <select name="document_type" class="form-select" id="inputDocumentType">
                                    <option value="">Seleccione...</option>
                                    <option value="Opción Uno">Opción Uno</option>
                                    <option value="Opción Dos">Opción Dos</option>
                                    <option value="Opción Tres">Opción Tres</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="inputDocumentType" class="form-label fw-bold">{{__("Número de huesped")}} <span class="text-danger">*</span></label>
                                <select name="document_type" class="form-select" id="inputDocumentType">
                                    <option value="">Seleccione...</option>
                                    <option value="Opción Uno">Opción Uno</option>
                                    <option value="Opción Dos">Opción Dos</option>
                                    <option value="Opción Tres">Opción Tres</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName" class="form-label fw-bold">{{__("Entrada")}} <span class="text-danger">*</span></label>
                                <input type="date" name="lastname" class="form-control" id="inputLastName">
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName" class="form-label fw-bold">{{__("Salida")}} <span class="text-danger">*</span></label>
                                <input type="date" name="lastname" class="form-control" id="inputLastName">
                            </div>
                            <div class="col-md-12">
                                <label for="inputDocumentType" class="form-label fw-bold">Comentario</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="8"></textarea>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">{{__("Solicitar Reserva")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


@endsection