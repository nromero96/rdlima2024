<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GafeteController extends Controller
{
    public function index()
    {
        $data = [
            'category_name' => 'gafetes',
            'page_name' => 'gafetes',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('pages.gafetes.index')->with($data);
    }

    public function gafeteForParticipant($id)
    {
        echo "Se generará el gafe para el participante con id: $id";
    }

    public function gafeteForAccompanist($id)
    {
        echo "Se generará el gafe para el acompañante con id: $id";
    }

}
