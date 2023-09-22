<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CategoryInscription;
use App\Models\Inscription;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

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

        if (\Auth::user()->hasRole('Administrador')) {
            $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname')
            ->where('inscriptions.user_id', $iduser)
            ->orderBy('inscriptions.id', 'desc')
            ->get();
        } else {
            $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname')
            ->where('inscriptions.user_id', $iduser)
            ->orderBy('inscriptions.id', 'desc')
            ->get();
        }

        return view('pages.inscriptions.index')->with($data)->with('inscriptions', $inscriptions);
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

        //get logged user id
        $iduser = \Auth::user()->id;

        //insert data
        $inscription = new Inscription();
        $inscription->user_id = $iduser;
        $inscription->category_inscription_id = $request->category_inscription_id;
        
        $category_inscription = CategoryInscription::find($request->category_inscription_id);
        $inscription->price_category = $category_inscription->price;

        if($request->accompanist != ''){
            $inscription->accompanist_id = null;
            $category_inscription_accompanist = CategoryInscription::where('name', 'Acompañante')->first();
            $inscription->price_accompanist = $category_inscription_accompanist->price;
        }else{
            $inscription->accompanist_id = null;
            $inscription->price_accompanist = 0;
        }

        $inscription->total = $inscription->price_category + $inscription->price_accompanist;
        $inscription->special_code = '';
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
            $inscription->status = 'Verificando';
            $inscription->save();
            //redirect
            return redirect()->route('inscriptions.index')->with('success', 'Inscripción realizada con éxito');
        } else if($request->payment_method == 'Tarjeta'){
            $inscription->status = 'Pendiente';
            $inscription->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        return view('pages.inscriptions.paymentniubiz')->with($data)->with('user', $user)->with('datainscription', $datainscription);
    }

}
