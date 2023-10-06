<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialCode;
use App\Models\Inscription;

//Log
use Illuminate\Support\Facades\Log;


class SpecialCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'specialcodes',
            'page_name' => 'specialcodes',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $specialcodes = SpecialCode::orderBy('id', 'desc')->get();
        return view('pages.specialcodes.index')->with($data)->with('specialcodes', $specialcodes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'specialcodes',
            'page_name' => 'specialcodes_create',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('pages.specialcodes.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate
        $this->validate($request, [
            'code' => 'required|unique:special_codes',
            'amount' => 'required|numeric',
            'description' => 'nullable',
            'quantity' => 'required|numeric',
            'expiration' => 'required|date',
        ]);

        //create
        $specialcode = new SpecialCode;
        $specialcode->code = $request->input('code');
        $specialcode->amount = $request->input('amount');
        $specialcode->description = $request->input('description');
        $specialcode->quantity = $request->input('quantity');
        $specialcode->expiration = $request->input('expiration');
        $specialcode->status = $request->input('status');
        $specialcode->save();
        return redirect()->route('specialcodes.index')->with('success', '¡Código especial creado con éxito!');
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
        $data = [
            'category_name' => 'specialcodes',
            'page_name' => 'specialcodes_edit',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $specialcode = SpecialCode::find($id);
        return view('pages.specialcodes.edit')->with($data)->with('specialcode', $specialcode);
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
        //validate update
        $this->validate($request, [
            'amount' => 'required|numeric',
            'description' => 'nullable',
            'quantity' => 'required|numeric',
            'expiration' => 'required|date',
            'status' => 'required',
        ]);

        //update
        $specialcode = SpecialCode::find($id);
        $specialcode->amount = $request->input('amount');
        $specialcode->description = $request->input('description');
        $specialcode->quantity = $request->input('quantity');
        $specialcode->expiration = $request->input('expiration');
        $specialcode->status = $request->input('status');
        $specialcode->save();
        //return edit page
        return redirect()->route('specialcodes.edit', $specialcode->id)->with('success', '¡Código especial actualizado con éxito!');

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

    
    public function validateSpecialCode(Request $request)
    {
        $code = $request->input('code');
        $specialcode = SpecialCode::where('code', $code)->first();

        if (!$specialcode) {
            return response()->json([
                'success' => false,
                'message' => 'Código especial no válido',
            ]);
        }

        // Verificar si la fecha de expiración es igual o inferior a la fecha actual
        $expirationDate = \Carbon\Carbon::parse($specialcode->expiration);
        $currentDate = \Carbon\Carbon::now();
        if ($expirationDate->lte($currentDate)) {
            return response()->json([
                'success' => false,
                'message' => 'Código especial expirado',
            ]);
        }

        // verificar si status es activo
        if ($specialcode->status != 'Activo') {
            return response()->json([
                'success' => false,
                'message' => 'Código especial no activo',
            ]);
        }

        // Verificar si el código especial está agotado en todas las inscripciones
        $usedCount = Inscription::where('special_code', $code)->count();
        if ($usedCount >= $specialcode->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Código especial agotado',
            ]);
        }

        // Verificar si el usuario logueado ya ha utilizado el código en su inscripción
        $userId = \Auth::user()->id; // Obtener el ID del usuario logueado
        $userUsedCount = Inscription::where('special_code', $code)
            ->where('user_id', $userId)
            ->count();

        if ($userUsedCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Ya utilizó el código en su inscripción',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Código especial válido',
            'price' => $specialcode->amount, // Puedes cambiar esto según tus necesidades
        ]);

    }

}
