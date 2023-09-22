@extends('layouts.app')


@section('content')

@php
    $amount = $datainscription->total;
    $detallePago = "Inscripcion categoria ".$datainscription->category_inscription_name;

    $token = App\Helpers\NiubizHelper::generateToken();
    $sesion = 'sessio1';
    $purchaseNumber = '0000000001';

    // $token = generateToken();
    // $sesion = generateSesion($amount, $token);
    // $purchaseNumber = generatePurchaseNumber();
@endphp

<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <div class="row layout-spacing">
            <div class="col-lg-12 layout-top-spacing mt-4">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 mb-2 col-12">
                                <h4 class="text-center mt-3">
                                    {{__("INFORMACIÓN DE PAGO")}}
                                    {{ $token }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area pt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <b style="padding-left:20px;">Importe a pagar: </b> S/. <?php echo $amount; ?> <br>
                                    <b style="padding-left:20px;">Número de pedido: </b> <?php echo $purchaseNumber; ?> <br>
                                    <b style="padding-left:20px;">Concepto: </b> <?php echo $detallePago; ?> <br>
                                    <b style="padding-left:20px;">Fecha: </b> <?php echo date("d/m/Y"); ?> <br>
                                    <input type="checkbox" name="ckbTerms" id="ckbTerms" onclick="visaNetEc3()"> <label for="ckbTerms">Acepto los <a href="#" target="_blank">Términos y condiciones</a></label>
                                </div>
                                <form id="frmVisaNet" class="text-center" action="{{ route('inscriptions.confirmpaymentniubiz') }}?amount={{ $amount }}&purchaseNumber={{ $purchaseNumber }}">
                                    <script src="{{ config('niubiz.VISA_URL_JS') }}" 
                                        data-sessiontoken="{{ $sesion }}"
                                        data-channel="web"
                                        data-merchantid="{{ config('niubiz.VISA_MERCHANT_ID') }}"
                                        data-merchantlogo= "{{ asset('assets/img/logo2.png') }}"
                                        data-purchasenumber="{{ $purchaseNumber }}"
                                        data-amount="{{ $amount }}"
                                        data-expirationminutes="5"
                                        data-timeouturl="{{ route('inscriptions.index') }}"
                                    ></script>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    var frmVisa = document.getElementById('frmVisaNet');

if (document.body.contains(frmVisa)) {
    document.getElementById('frmVisaNet').setAttribute("style", "display:none");
}
function visaNetEc3() {
    if (document.getElementById('ckbTerms').checked) {
        document.getElementById('frmVisaNet').setAttribute("style", "display:auto");
    } else {
        document.getElementById('frmVisaNet').setAttribute("style", "display:none");
    }
}
</script>

@endsection