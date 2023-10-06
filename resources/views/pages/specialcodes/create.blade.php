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
                                    {{__("Información del código especial")}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <form class="row g-3" action="{{ route('specialcodes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="code" class="form-label fw-bold">{{__("Código")}}</label>
                                <input type="text" name="code" class="form-control convert_mayus" id="code" value="{{ old('code') }}">
                                <small>Una vez guardado no podrá modificar.</small><br>
                                {!!$errors->first("code", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-6">
                                <label for="amount" class="form-label fw-bold">{{__("Monto")}}(US$)</label>
                                <input type="number" name="amount" class="form-control" id="amount" value="{{ old('amount') }}">
                                {!!$errors->first("amount", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">{{__("Descripción:")}}</label>
                                <input type="text" name="description" class="form-control" id="description" value="{{ old('description') }}">
                                {!!$errors->first("description", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="quantity" class="form-label fw-bold">{{__("Cantidad")}}</label>
                                <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity') }}">
                                {!!$errors->first("quantity", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="expiration" class="form-label fw-bold">{{__("Expiracion")}}</label>
                                <input type="date" name="expiration" class="form-control" id="expiration" value="{{ old('expiration') }}">
                                {!!$errors->first("expiration", "<span class='text-danger'>:message</span>")!!}
                            </div>

                            <div class="col-md-4">
                                <label for="status" class="form-label fw-bold">{{__("Expiracion")}}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Activo" {{ old('status') == 'Activo' ? 'selected' : '' }} >{{__("Activo")}}</option>
                                    <option value="Inactivo" {{ old('status') == 'Inactivo' ? 'selected' : '' }}>{{__("Inactivo")}}</option>
                                </select>
                            </div>

                            <div class="col-12 text-end">
                                <a href="{{ route('specialcodes.index') }}" class="btn btn-outline-secondary">{{__("Cancelar")}}</a>
                                <button type="submit" class="btn btn-primary">{{__("Guardar")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


@endsection