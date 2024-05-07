@extends('layouts.app')


@section('content')


<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-spacing">
            <div class="col-lg-12 layout-top-spacing mt-4">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                                <label for="inputName" class="form-label fw-bold">{{__("Nombre")}}:</label>
                                <p class="form-control">{{$user->name}}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName" class="form-label fw-bold">{{__("Apellido paterno")}}:</label>
                                <p class="form-control">{{$user->lastname}}</p>  
                            </div>
                            <div class="col-md-4">
                                <label for="inputSecondLastName" class="form-label fw-bold">{{__("Apellido materno")}}:</label>
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
                                                    if($category->name == 'Dermatólogos' || $category->name == 'Residentes' || $category->name == 'Médicos de otras especialidades' || $category->name == 'Cuota especial'){
                                                        $infomark = ' <span class="text-danger">*</span>';
                                                    }else{
                                                        $infomark = '';
                                                    }
                                                @endphp

                                                @if ($category->type == 'radio' && $category->status == 'active' && $category->id != '4' )
                                                    <tr>
                                                        <td>
                                                            <div class="form-check form-check-primary me-1">
                                                                <input type="{{ $category->type }}" id="category_{{ $category->id }}" name="category_inscription_id" value="{{ $category->id }}" class="form-check-input cursor-pointer" data-catprice="{{ $category->price }}">
                                                                <label class="form-check-label mb-0 ms-1 cursor-pointer" for="category_{{ $category->id }}">{{ $category->name }}{!! $infomark !!}
                                                                <small class="text-muted">{!! $category->description !!}</small>
                                                                </label>
                                                            </div>

                                                            @if ($category->id == '7')
                                                                <div id="dv_specialcode" class="d-sm-inline-block d-none">
                                                                    <div class="input-group mt-1 mb-0">
                                                                        <input type="text" name="specialcode" id="specialcode" class="form-control convert_mayus" placeholder="Ingresar código">
                                                                        <button class="btn btn-secondary d-none" type="button" id="clear_specialcode" style="border-radius: 0px 6px 6px 0px;">Limpiar</button>
                                                                        <button class="btn btn-primary px-2 px-sm-3" type="button" id="validate_specialcode">Validar</button>
                                                                    </div>
                                                                </div>
                                                                <div class="d-inline-block" id="sms_valid_vc">
                                                                    <!-- Mensaje -->
                                                                </div>
                                                                <input type="hidden" name="specialcode_verify" id="specialcode_verify" value="">
                                                            @endif

                                                        </td>
                                                        <td>
                                                            <b>US$ <span id="dc_price_{{ $category->id }}">{{ $category->price === '0.00' ? '00' : rtrim(rtrim($category->price, '0'), '.') }}</span></b>
                                                        </td>
                                                    </tr>

                                                @endif

                                                @if($beneficiariobeca == 'si' && $category->status == 'active' && $category->id == '4')
                                                    <tr>
                                                        <td>
                                                            <div class="form-check form-check-primary">
                                                                <input type="{{ $category->type }}" id="category_{{ $category->id }}" name="category_inscription_id" value="{{ $category->id }}" class="form-check-input cursor-pointer" data-catprice="{{ $category->price }}">
                                                                <label class="form-check-label mb-0 ms-1 cursor-pointer" for="category_{{ $category->id }}">{{ $category->name }}{!! $infomark !!}</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <b>US$ <span id="dc_price_{{ $category->id }}">{{ $category->price === '0.00' ? '00' : rtrim(rtrim($category->price, '0'), '.') }}</span></b>
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if ($category->type == 'checkbox' && $category->name == 'Acompañante' && $category->status == 'active')
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
                                </div>

                                <div id="dv_accompanist" class="d-none">
                                    <label class="form-label mt-3">
                                        <span class="fw-bold">{{ __('Complete los datos del acompañante') }}:</span></label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="accompanist_name" class="text-muted">{{__("Nombre completo")}}:</label>
                                            <input type="text" class="form-control convert_mayus" name="accompanist_name">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="accompanist_typedocument" class="text-muted">{{__("Tipo documento")}}:</label>
                                            <select class="form-control" name="accompanist_typedocument" id="accompanist_typedocument">
                                                <option value="Seleccione...">Seleccione...</option>
                                                <option value="DNI">DNI</option>
                                                <option value="Carnet de extranjería">Carnet de extranjería</option>
                                                <option value="Pasaporte">Pasaporte</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="accompanist_numdocument" class="text-muted">{{__("N° documento")}}:</label>
                                            <input type="text" class="form-control" name="accompanist_numdocument" name="accompanist_numdocument">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="accompanist_solapin" class="text-muted">{{__("Solapín/Gafete")}}:</label>
                                            <input type="text" class="form-control convert_mayus" name="accompanist_solapin" id="accompanist_solapin">
                                        </div>
                                    </div>
                                </div>

                                <div id="dv_document_file" class="d-none">
                                    <small class="text-danger"><b>{{__("Nota:")}}</b> {{__("* Debe adjuntar documento probatorio de categoría (Título, Constancia, Carnet profesional) (.pdf/.jpg)")}}</small>

                                    <label for="document_file" class="form-label mt-2">
                                        <span class="fw-bold">{{ __('Adjuntar documento probatorio de categoría') }}:</span> <span class="text-info">{{ __('(Título, Constancia, Carnet profesional) (.pdf/.jpg)') }}</span></label>
                                    <input type="file" name="document_file" id="document_file" class="file-control">
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="card px-3 py-3">
                                    <label for="" class="form-label fw-bold">
                                        @if ($user->country == 'Perú')
                                            {{ __('¿Necesita Factura?') }}
                                        @else
                                            {{ __('¿Necesita Boleta de Pago?') }}
                                        @endif
                                    </label>
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
                                            <input type="text" name="invoice_ruc" id="invoice_ruc" class="form-control" placeholder="@if ($user->country == 'Perú') RUC @else N° de Identificación Tributaria @endif"></div>
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

                                        <p class="text-center">BENEFICIARIO: <b>ASOCIACION DERMATOLOGICA RADLA</b> - <b>RUC 20504537405</b></p>

                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input cursor-pointer" type="radio" name="payment_method" value="Transferencia/Depósito" id="payment_method_transfer" checked>
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
                                                    <label for="voucher_file" class="d-block text-center">Adjuntar comprobante de pago.</label>
                                                    <input type="file" name="voucher_file" id="voucher_file" class="file-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>

                                    <div id="dv_card" class="pt-4 pb-4 d-none">
                                        <p class="text-center">
                                            <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                                                Realiza tu pago con cualquier tarjeta de crédito o débito.<br>Si te inscribes en Beca RADLA, categorías especiales o cuota especial, ¡el pago ya no es necesario!
                                            </div>
                                        </p>
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