<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\User;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'works',
            'page_name' => 'works',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $works = Work::orderBy('id', 'desc')->get();

        return view('pages.works.index')->with($data)->with('works', $works);
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
            'category_name' => 'works',
            'page_name' => 'works_create',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $user = User::find($id);

        return view('pages.works.create')->with($data)->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = \Auth::user()->id;

        $request->validate([
            'knowledge_area' => 'required',
            'category' => 'required',
        ]);

        $action = $request->input('action'); // Obtén el valor del botón presionado

        $work = new Work([
            'knowledge_area' => $request->get('knowledge_area'),
            'category' => $request->get('category'),
            'author_coauthors' => $request->get('author_coauthors'),
            'institution' => $request->get('institution'),
            'user_id' => $id,
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'file_1' => $request->get('file_1'),
            'file_2' => $request->get('file_2'),
            'file_3' => $request->get('file_3'),
            'file_4' => $request->get('file_4'),
            'file_5' => $request->get('file_5'),
            'file_6' => $request->get('file_6'),
            'status' => $action,
        ]);

        $work->save();

        // Redirigir según el valor de $action
        if ($action == 'borrador') {
            return redirect()->route('works.edit', ['work' => $work->id])->with('success', 'Trabajo agregado exitosamente.');
        } elseif ($action == 'finalizado') {
            return redirect()->route('works.index')->with('success', 'Trabajo agregado exitosamente.');
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
        return 'En proceso de construcción...';
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
