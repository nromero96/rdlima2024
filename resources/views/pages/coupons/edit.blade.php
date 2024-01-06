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
                            <div class="col-xl-12 col-md-12 col-sm-12 mb-2 col-12">
                                <h4>
                                    {{__("Información del cupón")}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <form class="row g-3" action="{{ route('coupons.update',$coupon->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <label for="code" class="form-label fw-bold">{{__("Código")}}</label>
                                <input style="color: black" type="text" name="code" class="form-control convert_mayus" id="code" value="{{ $coupon->code }}" readonly>
                                <small>Una vez guardado no podrá modificar.</small><br>
                                {!!$errors->first("code", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-6">
                                <label for="description" class="form-label fw-bold">{{__("Descripción")}}</label>
                                <input type="text" name="description" class="form-control" id="description" value="{{ $coupon->description }}">
                                {!!$errors->first("description", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="type" class="form-label fw-bold">{{__("Tipo")}}</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="Monto" {{ old('type') == 'Monto' ? 'selected' : '' }} >{{__("Monto")}}</option>
                                    <option value="Porcentaje" {{ old('type') == 'Porcentaje' ? 'selected' : '' }}>{{__("Porcentaje")}}</option>
                                </select>
                                {!!$errors->first("type", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="amount" class="form-label fw-bold">{{__("Monto")}}</label>
                                <input type="number" name="amount" class="form-control" id="amount" value="{{ $coupon->amount }}">
                                {!!$errors->first("amount", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="quantity" class="form-label fw-bold">{{__("Cantidad")}}</label>
                                <input type="number" name="quantity" class="form-control" id="quantity" value="{{ $coupon->quantity }}">
                                {!!$errors->first("quantity", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="start_date" class="form-label fw-bold">{{__("Inicio")}}</label>
                                <input type="date" name="start_date" class="form-control" id="start_date" value="{{ $coupon->start_date }}">
                                {!!$errors->first("start_date", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="end_date" class="form-label fw-bold">{{__("Expiracion")}}</label>
                                <input type="date" name="end_date" class="form-control" id="end_date" value="{{ $coupon->end_date }}">
                                {!!$errors->first("end_date", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="inscripcion_category" class="form-label fw-bold">{{__("Categoría")}}</label>
                                <select name="inscripcion_category" id="inscripcion_category" class="form-select">
                                    <option value="">Todas</option>
                                    @foreach ($categories as $categorie)
                                        <option value="{{ $categorie->id }}" @if($coupon->inscripcion_category == $categorie->id) selected @else  @endif  >{{ $categorie->name }}</option>
                                    @endforeach
                                </select>
                                {!!$errors->first("inscripcion_category", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="is_email_restrict" class="form-label fw-bold">{{__("Restringir por correos")}}</label>
                                <select name="is_email_restrict" id="is_email_restrict" class="form-select">
                                    <option value="0" @if($coupon->is_email_restrict == '0') selected @else  @endif >{{__("No")}}</option>
                                    <option value="1" @if($coupon->is_email_restrict == '1') selected @else  @endif>{{__("Si")}}</option>
                                </select>
                                <small>En la parte inferior puede agregar los correos.</small>
                                {!!$errors->first("is_email_restrict", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="status" class="form-label fw-bold">{{__("Estado")}}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Activo" @if($coupon->status == 'Activo') selected @else  @endif >{{__("Activo")}}</option>
                                    <option value="Inactivo" @if($coupon->status == 'Inactivo') selected @else  @endif>{{__("Inactivo")}}</option>
                                </select>
                                {!!$errors->first("status", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-12 text-end">
                                <a href="{{ route('coupons.index') }}" class="btn btn-outline-secondary">{{__("Cancelar")}}</a>
                                <button type="submit" class="btn btn-primary">{{__("Actualizar")}}</button>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="statbox widget box box-shadow mt-3">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 mb-2 col-12">
                                <h4>
                                    {{__("Correos")}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <form class="row g-3" id="registeremail">
                            <div class="col-md-5">
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">{{__("Agregar")}}</button>
                            </div>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-2">
                                <a href="javascript:;" class="btn btn-info w-100">{{__("Masivo")}}</a>
                            </div>

                            {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}
                        </form>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__("Email")}}</th>
                                                <th style="width: 80px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($couponemails as $email)
                                                <tr>
                                                    <td>{{ $email->email }}</td>
                                                    <td>
                                                        <form action="{{ route('couponmails.deletemail',$email->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="badge badge-light-danger text-start btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="{{ __("Eliminar") }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                            </button>
                                                        </form>
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