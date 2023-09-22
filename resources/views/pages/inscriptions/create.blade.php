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
                        <form class="row g-3" action="{{ route('inscriptions.store') }}" method="POST" id="formInscription" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4">
                                <label for="inputName" class="form-label fw-bold">{{__("Nombre")}}</label>
                                <p class="form-control">{{$user->name}}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName" class="form-label fw-bold">{{__("Apellido paterno")}}</label>
                                <p class="form-control">{{$user->lastname}}</p>  
                            </div>
                            <div class="col-md-4">
                                <label for="inputSecondLastName" class="form-label fw-bold">{{__("Apellido materno")}}</label>
                                <p class="form-control">{{$user->second_lastname}}</p>
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
                                            @foreach ($category_inscriptions as $category)
                                                @php
                                                    if($category->name == 'Dermatólogos' || $category->name == 'Residentes' || $category->name == 'Médicos de otras especialidades'){
                                                        $infomark = ' <span class="text-danger">*</span>';
                                                    }else{
                                                        $infomark = '';
                                                    }
                                                @endphp

                                                @if ($category->type == 'radio')
                                                    <tr>
                                                        <td>
                                                            <div class="form-check form-check-primary">
                                                                <input type="{{ $category->type }}" id="category_{{ $category->id }}" name="category_inscription_id" value="{{ $category->id }}" class="form-check-input cursor-pointer" data-catprice="{{ $category->price }}">
                                                                <label class="form-check-label mb-0 ms-1 cursor-pointer" for="category_{{ $category->id }}">{{ $category->name }}{!! $infomark !!}</label>
                                                            </div>
                                                        </td>   
                                                        <td>
                                                            <b>US$ {{ $category->price === '0.00' ? '00' : rtrim(rtrim($category->price, '0'), '.') }}</b>
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if ($category->type == 'checkbox' && $category->name == 'Acompañante')
                                                    <tr>
                                                        <td>
                                                            <div class="form-check form-check-primary">
                                                                <input class="form-check-input cursor-pointer" type="checkbox" name="accompanist" value="si" id="customcheck_{{ $category->id }}" data-catprice="{{ $category->price }}">
                                                                <label class="form-check-label mb-0 ms-1 cursor-pointer" for="customcheck_{{ $category->id }}">{{ $category->name }}</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <b>US$ {{ $category->price === '0.00' ? '00' : rtrim(rtrim($category->price, '0'), '.') }}</b>
                                                        </td>
                                                    </tr>
                                                @endif

                                            @endforeach
                                            <tr class="table-secondary">
                                                <td><b>TOTAL A PAGAR</b></td>
                                                <td><b>US$ <span id="paymentotal">00</span></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <small class="text-danger"><b>{{__("Nota:")}}</b> {{__("* Debe adjuntar documento probatorio de categoría (Título, Constancia, Carnet profesional) (.pdf/.jpg)")}}</small>
                                </div>

                                <div id="dv_document_file" class="d-none">
                                    <label for="document_file" class="form-label mt-3">
                                        <span class="fw-bold">{{ __('Adjuntar documento probatorio de categoría') }}</span> <span class="text-info">{{ __('(Título, Constancia, Carnet profesional) (.pdf/.jpg)') }}</span></label>
                                    <input type="file" name="document_file" id="document_file" class="file-control">
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="card px-3 py-3">
                                    <label for="" class="form-label fw-bold">{{ __('¿Necesita Factura?') }}</label>
                                    <div class="">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input cursor-pointer" type="radio" name="invoice" id="invoice_no" value="no" checked="">
                                            <label class="form-check-label mb-0 cursor-pointer" for="invoice_no">
                                                No
                                            </label>
                                        </div>
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input cursor-pointer" type="radio" name="invoice" id="invoice_yes" value="si">
                                            <label class="form-check-label mb-0 cursor-pointer" for="invoice_yes">
                                                Si
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-2 d-none" id="dv_invoice_info">
                                        <div class="col-md-4">
                                            <input type="text" name="invoice_ruc" id="invoice_ruc" class="form-control" placeholder="RUC">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="invoice_social_reason" id="invoice_social_reason" class="form-control" placeholder="Razón social">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="invoice_address" id="invoice_address" class="form-control" placeholder="Dirección">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card px-3 py-3">
                                    <label for="" class="form-label fw-bold text-center">{{ __('FORMA DE PAGO') }}</label>
                                    <div class="text-center">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input cursor-pointer" type="radio" name="payment_method" value="Transferencia/Depósito" id="payment_method_transfer" checked="">
                                            <label class="form-check-label mb-0 cursor-pointer" for="payment_method_transfer">
                                                Transferencia bancaria o depósito
                                            </label>
                                        </div>
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input cursor-pointer" type="radio" name="payment_method" value="Tarjeta" id="payment_method_card">
                                            <label class="form-check-label mb-0 cursor-pointer" for="payment_method_card">
                                                Tarjeta de crédito/débito
                                            </label>
                                        </div>
                                    </div>

                                    <div id="dv_tranfer" class="mt-3">
                                        <p class="text-center"><img src="{{ asset('assets/img/logo-bcp.png') }}" style="width: 180px;border-radius: 10px;"></p>
                                        <h5 class="text-center"><b>BANCO DE CREDITO DEL PERU</b></h5>
                                        <p class="text-center">
                                            <b>Cta. Cte. Dólares:</b> 194-2143692-1-63<br>
                                            <b>CCI:</b> 002-194-002143692163-95<br>
                                            <b>Código Swift:</b> BCPLPEPL<br>
                                        </p>
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div id="dv_voucher_file" class="mt-2">
                                                    <label for="voucher_file" class="d-block text-center">Adjuntar comprabante de pago.</label>
                                                    <input type="file" name="voucher_file" id="voucher_file" class="file-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>

                                    <div id="dv_card" class="pt-4 pb-4 d-none">
                                        <p class="text-center">Próximamente...</p>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg" id="btnSubInscription">{{__("Inscribirme Ahora")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection