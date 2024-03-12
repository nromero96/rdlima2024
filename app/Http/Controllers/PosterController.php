<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;
use App\Models\Work;

class PosterController extends Controller
{
    public function index()
    {
        // $category_name = '';
        $data = [
            'category_name' => 'posters',
            'page_name' => 'posters',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        //if user is logged role is Administator
        if (\Auth::user()->hasRole('Administrador') || \Auth::user()->hasRole('Secretaria')) {
            $posters = Work::join('users', 'works.user_id', '=', 'users.id')
            ->where('works.status', 'aceptado')
            ->selectRaw('works.*, CONCAT(users.name, " ", users.lastname, " ", users.second_lastname) AS author, users.country')
            ->get();
        } else {
            $posters = Work::join('users', 'works.user_id', '=', 'users.id')
            ->where('works.status', 'aceptado')
            ->where('works.user_id', auth()->user()->id)
            ->selectRaw('works.*, CONCAT(users.name, " ", users.lastname, " ", users.second_lastname) AS author, users.country')
            ->get();
        }


        return view('pages.posters.index')->with($data)->with('posters', $posters);
    }
}
