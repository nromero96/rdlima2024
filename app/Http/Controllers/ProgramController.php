<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\ProgramSession;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $category_name = '';
        $data = [
            'category_name' => 'programs',
            'page_name' => 'programs',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        
        $programs = Program::orderBy('id', 'desc')->get();

        return view('pages.programs.index')->with($data)->with('programs', $programs);
    }

    public function showOnlinePrograms()
    {
        // $category_name = '';
        $data = [
            'category_name' => 'programs',
            'page_name' => 'online-programs',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        
        $programsession = ProgramSession::orderBy('id', 'desc')->get();
        $programs = Program::orderBy('id', 'desc')->get();

        return view('pages.programs.online-program')->with($data)->with('programsession', $programsession)->with('programs', $programs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
