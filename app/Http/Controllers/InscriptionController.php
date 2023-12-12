<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Payment;
use App\Models\CategoryInscription;
use App\Models\Inscription;
use App\Models\TemporaryFile;
use App\Models\Accompanist;
use App\Models\Statusnote;
use App\Models\SpecialCode;

use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Log;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $iduser = \Auth::user()->id;

        $data = [
            'category_name' => 'inscriptions',
            'page_name' => 'inscriptions',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        if (\Auth::user()->hasRole('Administrador') || \Auth::user()->hasRole('Secretaria')) {
            $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country')
                ->where('inscriptions.status', '!=', 'Rechazado')
                ->orderBy('inscriptions.id', 'desc')
                ->get();
        } else {
            $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country')
                ->where('inscriptions.user_id', $iduser)
                ->orderBy('inscriptions.id', 'desc')
                ->get();
        }
        

        return view('pages.inscriptions.index')->with($data)->with('inscriptions', $inscriptions);
    }

    public function indexRejects(){
        $iduser = \Auth::user()->id;

        $data = [
            'category_name' => 'inscriptions',
            'page_name' => 'inscriptions_rejects',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        if (\Auth::user()->hasRole('Administrador') || \Auth::user()->hasRole('Secretaria') || \Auth::user()->hasRole('Hotelero')) {
            $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country')
                ->where('inscriptions.status', 'Rechazado')
                ->orderBy('inscriptions.id', 'desc')
                ->get();
        } else {
            $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country')
                ->where('inscriptions.user_id', $iduser)
                ->where('inscriptions.status', 'Rechazado')
                ->orderBy('inscriptions.id', 'desc')
                ->get();
        }
        

        return view('pages.inscriptions.rejects')->with($data)->with('inscriptions', $inscriptions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = \Auth::user()->id;

        $data = [
            'category_name' => 'inscriptions',
            'page_name' => 'inscriptions_create',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $user = User::find($id);

        //get CategoryInscription
        $category_inscriptions = CategoryInscription::orderBy('id', 'asc')->get();

        return view('pages.inscriptions.create')->with($data)->with('user', $user)->with('category_inscriptions', $category_inscriptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $amount_especialcode = 0;
        //si $request->category_inscription_id == 7 validar que exista el código especial
        if($request->category_inscription_id == 7){
            //get amount code special
            $specialcode = SpecialCode::where('code', $request->specialcode)->first();
            if($specialcode){
                $amount_especialcode = $specialcode->amount;
            }else{
                return redirect()->route('inscriptions.create')->with('error', 'El código especial no existe');
            }
        }

        //get logged user id
        $iduser = \Auth::user()->id;

        //verificar si existe acompañante en la inscripcion, registrar y devolver id
        if($request->accompanist != ''){
            $accompanist = new Accompanist();
            $accompanist->accompanist_name = $request->accompanist_name;
            $accompanist->accompanist_typedocument = $request->accompanist_typedocument;
            $accompanist->accompanist_numdocument = $request->accompanist_numdocument;
            $accompanist->accompanist_solapin = $request->accompanist_solapin;
            $accompanist->save();
            $data_accompanist_id = $accompanist->id;
        }else{
            $data_accompanist_id = null;
        }

        //insert data
        $inscription = new Inscription();
        $inscription->user_id = $iduser;
        $inscription->category_inscription_id = $request->category_inscription_id;
        
        $category_inscription = CategoryInscription::find($request->category_inscription_id);
        
        //si $amount_especialcode es mayor a 0, poner el precio del código especial
        if($amount_especialcode > 0){
            $inscription->price_category = $amount_especialcode;
        }else{
            $inscription->price_category = $category_inscription->price;
        }

        if($request->accompanist != ''){
            $inscription->accompanist_id = $data_accompanist_id;
            $category_inscription_accompanist = CategoryInscription::where('name', 'Acompañante')->first();
            $inscription->price_accompanist = $category_inscription_accompanist->price;
        }else{
            $inscription->accompanist_id = $data_accompanist_id;
            $inscription->price_accompanist = 0;
        }

        $inscription->total = $inscription->price_category + $inscription->price_accompanist;
        $inscription->special_code = $request->specialcode;
        $inscription->invoice = $request->invoice;
        $inscription->invoice_ruc = $request->invoice_ruc;
        $inscription->invoice_social_reason = $request->invoice_social_reason;
        $inscription->invoice_address = $request->invoice_address;
        $inscription->payment_method = $request->payment_method;
        $inscription->voucher_file = '';
        $inscription->save();

        $temporaryfile_document_file = TemporaryFile::where('folder', $request->document_file)->first();
        if($temporaryfile_document_file){
            Storage::move('public/uploads/tmp/'.$request->document_file.'/'.$temporaryfile_document_file->filename, 'public/uploads/document_file/'.$temporaryfile_document_file->filename);
            $inscription->document_file = $temporaryfile_document_file->filename;
            $inscription->save();
            rmdir(storage_path('app/public/uploads/tmp/'.$request->document_file));
            $temporaryfile_document_file->delete();
        }

        $temporaryfile_voucher_file = TemporaryFile::where('folder', $request->voucher_file)->first();
        if($temporaryfile_voucher_file){
            Storage::move('public/uploads/tmp/'.$request->voucher_file.'/'.$temporaryfile_voucher_file->filename, 'public/uploads/voucher_file/'.$temporaryfile_voucher_file->filename);
            $inscription->voucher_file = $temporaryfile_voucher_file->filename;
            $inscription->save();
            rmdir(storage_path('app/public/uploads/tmp/'.$request->voucher_file));
            $temporaryfile_voucher_file->delete();
        }

        if($request->payment_method == 'Transferencia/Depósito'){
            $inscription->status = 'Procesando';
            $inscription->save();

            //send email
            $user = User::find($iduser);
            $datainscription = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
            ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name')
            ->where('inscriptions.id', $inscription->id)
            ->first();
            $data = [
                'user' => $user,
                'datainscription' => $datainscription,
            ];

            Mail::to($user->email)
                ->cc(config('services.correonotificacion.inscripcion'))
                ->send(new \App\Mail\InscriptionCreated($data));


            //redirect
            return redirect()->route('inscriptions.index')->with('success', 'Inscripción realizada con éxito');
        } else if($request->payment_method == 'Tarjeta'){
            $inscription->status = 'Pendiente';
            $inscription->save();

            //send email
            $user = User::find($iduser);
            $datainscription = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
            ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name')
            ->where('inscriptions.id', $inscription->id)
            ->first();
            $data = [
                'user' => $user,
                'datainscription' => $datainscription,
            ];

            Mail::to($user->email)
                ->cc(config('services.correonotificacion.inscripcion'))
                ->send(new \App\Mail\InscriptionCreated($data));

            //redirect to payment page with inscription id
            return redirect()->route('inscriptions.paymentniubiz', ['inscription' => $inscription->id]);
        }

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //solo mostrar su inscripciones del usuario logueado y para roles de Administrador y Secretaria
        $iduser = \Auth::user()->id;
        $inscription = Inscription::where('id', $id)->where('user_id', $iduser)->first();

        if (\Auth::user()->hasRole('Administrador') || \Auth::user()->hasRole('Secretaria') || $inscription) {

            $data = [
                'category_name' => 'inscriptions',
                'page_name' => 'inscriptions_show',
                'has_scrollspy' => 0,
                'scrollspy_offset' => '',
            ];
    
            $inscription = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->leftJoin('accompanists', 'inscriptions.accompanist_id', '=', 'accompanists.id')
            ->select('inscriptions.*', 
                    'category_inscriptions.name as category_inscription_name', 
                    'users.name as user_name', 
                    'users.lastname as user_lastname', 
                    'users.second_lastname as user_second_lastname', 
                    'users.document_type as user_document_type', 
                    'users.document_number as user_document_number',
                    'users.country as user_country',
                    'users.state as user_state',
                    'users.city as user_city',
                    'users.address as user_address',
                    'users.postal_code as user_postal_code',
                    'users.phone_code as user_phone_code',
                    'users.phone_code_city as user_phone_code_city',
                    'users.phone_number as user_phone_number',
                    'users.whatsapp_code as user_whatsapp_code',
                    'users.whatsapp_number as user_whatsapp_number',
                    'users.email as user_email',
                    'users.workplace as user_workplace',
                    'users.solapin_name as user_solapin_name',
                    'accompanists.accompanist_name as accompanist_name',
                    'accompanists.accompanist_typedocument as accompanist_typedocument',
                    'accompanists.accompanist_numdocument as accompanist_numdocument',
                    'accompanists.accompanist_solapin as accompanist_solapin')
            ->where('inscriptions.id', $id)
            ->first();

            $paymentcard = Payment::where('inscription_id', $id)->first();
            $accompanist = Accompanist::find($inscription->accompanist_id);

            //notes status
            $statusnotes = StatusNote::where('inscription_id', $id)->orderBy('id', 'desc')->get();

            return view('pages.inscriptions.show')->with($data)->with('inscription', $inscription)->with('accompanist', $accompanist)->with('paymentcard', $paymentcard)->with('statusnotes', $statusnotes);
        }else{
            return redirect()->route('inscriptions.index')->with('error', 'No tiene permisos para ver esta inscripción');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function paymentNiubiz(Inscription $inscription)
    {

        //get logged user id
        $iduser = \Auth::user()->id;
        $data = [
            'category_name' => 'inscriptions',
            'page_name' => 'inscriptions_paymentniubiz',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $user = User::find($iduser);
        //data inscription inner join category_inscriptions
        $datainscription = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
        ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name')
        ->where('inscriptions.id', $inscription->id)
        ->first();

        $amount = $datainscription->total;

        $sessionToken = $this->generateSessionToken($amount);

        return view('pages.inscriptions.paymentniubiz')->with($data)->with('user', $user)->with('datainscription', $datainscription)->with('sessionToken', $sessionToken)->with('amount', $amount);
    }

    private function generateSessionToken($amount){
        $auth = base64_encode(config('services.niubiz.user').':'.config('services.niubiz.password'));
        $accessToken = Http::withHeaders([
                'Authorization' => 'Basic '.$auth,
            ])->get(config('services.niubiz.url_api').'/api.security/v1/security')
            ->body();

        $accessToken = Http::withHeaders([
            'Authorization' => $accessToken,
            'Content-Type' => 'application/json',
        ])->post(config('services.niubiz.url_api').'/api.ecommerce/v2/ecommerce/token/session/'.config('services.niubiz.merchant_id'),[
            'channel' => 'web',
            'amount' => $amount,
            'antifraud' => [
                'clientIp' => request()->ip(),
                'merchantDefineData' => [
                    'MDD4' => auth()->user()->email,
                    'MDD21' => 0,
                    'MDD32' => auth()->user()->id,
                    'MDD75' => 'Registrado',
                    'MDD77' => now()->diffInDays(auth()->user()->created_at) + 1,
                ],
            ],
        ])->json();

        return $accessToken['sessionKey'];

    }

    public function confirmPaymentNiubiz(Request $request){
        
        $auth = base64_encode(config('services.niubiz.user').':'.config('services.niubiz.password'));
        $accessToken = Http::withHeaders([
                'Authorization' => 'Basic '.$auth,
            ])->get(config('services.niubiz.url_api').'/api.security/v1/security')
            ->body();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $accessToken,
        ])->post(config('services.niubiz.url_api').'/api.authorization/v3/authorization/ecommerce/'.config('services.niubiz.merchant_id'),[
            'channel' => 'web',
            'captureType' => 'manual',
            'countable' => true,
            'order' => [
                'tokenId' => $request->transactionToken,
                'purchaseNumber' => $request->purchasenumber,
                'amount' => $request->amount,
                'currency' => config('services.niubiz.currency'),
            ],
        ])->json();

        session()->flash('niubiz', [
            'inscription' => $request->inscription,
            'response' => $response,
            'purchaseNumber' => $request->purchasenumber,
        ]);


        if(isset($response['dataMap']) && $response['dataMap']['ACTION_CODE'] === '000'){
            //update status inscription
            $inscription = Inscription::find($request->inscription);
            $inscription->status = 'Procesando';
            $inscription->updated_at = now();
            $inscription->save();

            //insert payment
            $payment = new Payment();
            $payment->inscription_id = $request->inscription;
            $payment->user_id = \Auth::user()->id;
            $payment->action_description = $response['dataMap']['ACTION_DESCRIPTION'];
            $payment->purchasenumber = $request->purchasenumber;
            $payment->card_brand = $response['dataMap']['BRAND'];
            $payment->card_number = $response['dataMap']['CARD'];
            $payment->amount = $response['order']['amount'];
            $payment->currency = $response['order']['currency'];
            $payment->transaction_date = $response['dataMap']['TRANSACTION_DATE'];
            $payment->save();

        }else{
            
        }

        $data = [
            'category_name' => 'inscriptions',
            'page_name' => 'inscriptions_paymentconfirmniubiz',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('pages.inscriptions.paymentconfirmniubiz')->with($data);

    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // Obtener la inscripción actual
            $inscription = Inscription::findOrFail($id);

            // Validación de datos (ajusta estas reglas según tus necesidades)
            $validatedData = $request->validate([
                'action' => 'required',
                'note' => 'nullable|string',
            ]);

            // Insertar la nota de estado
            StatusNote::create([
                'inscription_id' => $id,
                'action' => "Cambió de '{$inscription->status}' a '{$validatedData['action']}'",
                'note' => $validatedData['note'] ?? 'Ninguna nota',
                'user_id' => auth()->id(),
            ]);

            // Actualizar el estado de la inscripción después de registrar la nota
            $inscription->update([
                'status' => $validatedData['action'],
                'updated_at' => now(),
            ]);

            return redirect()->route('inscriptions.show', ['inscription' => $id])->with('success', 'Estado actualizado con éxito');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el estado.');
        }
    }


    public function exportExcelInscriptions()
    {

        //if user is admin or secretary
        if(\Auth::user()->hasRole('Administrador') || \Auth::user()->hasRole('Secretaria')){
            return Excel::download(new \App\Exports\ExporInscriptions, 'inscriptions.xlsx');
        }else{
            echo 'No tiene permisos para exportar';
            exit;
        }

        
    }

}
