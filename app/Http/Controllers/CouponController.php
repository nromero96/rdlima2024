<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\CategoryInscription;

class CouponController extends Controller
{
    public function __construct(){
        $this->middleware('can:coupons.index')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'coupons',
            'page_name' => 'coupons',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        //get coupons order by id desc
        $coupons = Coupon::orderBy('id', 'desc')->get();

        return view('pages.coupons.index')->with($data)->with('coupons', $coupons);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'coupons',
            'page_name' => 'coupons_create',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        //get categories
        $categories = CategoryInscription::all();

        return view('pages.coupons.create')->with($data)->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ///validate
        $this->validate($request, [
            'code' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'amount' => 'required',
            'quantity' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'inscripcion_category' => 'nullable',
            'is_email_restrict' => 'nullable',
            'status' => 'required',
        ]);

        //create coupon
        $coupon = new Coupon;
        $coupon->code = $request->input('code');
        $coupon->description = $request->input('description');
        $coupon->type = $request->input('type');
        $coupon->amount = $request->input('amount');
        $coupon->quantity = $request->input('quantity');
        $coupon->start_date = $request->input('start_date');
        $coupon->end_date = $request->input('end_date');
        $coupon->inscripcion_category = $request->input('inscripcion_category');
        $coupon->is_email_restrict = $request->input('is_email_restrict');
        $coupon->status = $request->input('status');
        $coupon->save();

        //redirect a coupons con mensaje de exito
        return redirect('/coupons')->with('success', 'Cupón creado exitosamente!');

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
            'category_name' => 'coupons',
            'page_name' => 'coupons_edit',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        //get categories
        $categories = CategoryInscription::all();

        //get coupon
        $coupon = Coupon::find($id);

        return view('pages.coupons.edit')->with($data)->with('coupon', $coupon)->with('categories', $categories);

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
        ///validate
        $this->validate($request, [
            'description' => 'nullable',
            'type' => 'required',
            'amount' => 'required',
            'quantity' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'inscripcion_category' => 'nullable',
            'is_email_restrict' => 'nullable',
            'status' => 'required',
        ]);

        //update coupon
        $coupon = Coupon::find($id);
        $coupon->description = $request->input('description');
        $coupon->type = $request->input('type');
        $coupon->amount = $request->input('amount');
        $coupon->quantity = $request->input('quantity');
        $coupon->start_date = $request->input('start_date');
        $coupon->end_date = $request->input('end_date');
        $coupon->inscripcion_category = $request->input('inscripcion_category');
        $coupon->is_email_restrict = $request->input('is_email_restrict');
        $coupon->status = $request->input('status');
        $coupon->save();

        //redirect a edit page con mensaje de exito
        return redirect('/coupons/'.$id.'/edit')->with('success', 'Cupón actualizado exitosamente!');
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
}
