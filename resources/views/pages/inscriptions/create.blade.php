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
                                    {{__("Mi inscripción")}}
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

                            <div class="col-md-12">
                                <hr class="my-0">
                            </div>

                            <div class="col-md-12">
                                <h5 class="text-center">{{__("Categoría")}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col"><b>{{__("Categoría")}}</b></th>
                                                <th scope="col" width="105px"><b>{{__("Precio")}}</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-primary">
                                                        <input type="radio" id="customRadio1" name="customRadio" class="form-check-input">
                                                        <label class="form-check-label mb-0 ms-1" for="customRadio1">Dermatólogos <span class="text-danger">*</span></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>US$ 300</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-primary">
                                                        <input type="radio" id="customRadio2" name="customRadio" class="form-check-input">
                                                        <label class="form-check-label mb-0 ms-1" for="customRadio2">Residentes <span class="text-danger">*</span></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>US$ 180</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-primary">
                                                        <input type="radio" id="customRadio3" name="customRadio" class="form-check-input">
                                                        <label class="form-check-label mb-0 ms-1" for="customRadio3">Médicos de otras especialidades <span class="text-danger">*</span></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>US$ 1,500</b>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-primary">
                                                        <input type="radio" id="customRadio4" name="customRadio" class="form-check-input">
                                                        <label class="form-check-label mb-0 ms-1" for="customRadio4">Beca RADLA</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>US$ 00</b>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-primary">
                                                        <input type="radio" id="customRadio5" name="customRadio" class="form-check-input">
                                                        <label class="form-check-label mb-0 ms-1" for="customRadio5">Profesores Invitados</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>US$ 00</b>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-primary">
                                                        <input type="radio" id="customRadio6" name="customRadio" class="form-check-input">
                                                        <label class="form-check-label mb-0 ms-1" for="customRadio6">Coordinadores </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>US$ 00</b>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-primary">
                                                        <input type="radio" id="customRadio7" name="customRadio" class="form-check-input">
                                                        <label class="form-check-label mb-0 ms-1" for="customRadio7">Cuota especial</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>US$ 00</b>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-primary">
                                                        <input class="form-check-input" type="checkbox" value="" id="customCheck1">
                                                        <label class="form-check-label mb-0 ms-1" for="customCheck1">Acompañante</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>US$ 150</b>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <small class="text-danger"><b>{{__("Nota:")}}</b> {{__("* Debe adjuntar documento probatorio de categoría (Título, Constancia, Carnet profesional) (.pdf/.jpg)")}}</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card px-3 py-2">
                                    <label for="" class="form-label fw-bold">{{ __('¿Necesita Factura?') }}</label>
                                    <div class="">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input" type="radio" name="invoice" id="invoice_no" checked="">
                                            <label class="form-check-label mb-0" for="invoice_no">
                                                No
                                            </label>
                                        </div>
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input" type="radio" name="invoice" id="invoice_yes">
                                            <label class="form-check-label mb-0" for="invoice_yes">
                                                Si
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card px-3 py-2">
                                    <label for="" class="form-label fw-bold">{{ __('Forma de pago') }}</label>
                                    <div class="">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_transfer" checked="">
                                            <label class="form-check-label mb-0" for="payment_method_transfer">
                                                Transferencia bancaria o depósito
                                            </label>
                                        </div>
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_card">
                                            <label class="form-check-label mb-0" for="payment_method_card">
                                                Tarjeta de crédito/débito
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">{{__("Inscribirme")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


@endsection