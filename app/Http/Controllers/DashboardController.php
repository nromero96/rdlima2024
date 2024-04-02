<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller{
    public function index(){
        // $category_name = '';
        $data = [
            'category_name' => 'dashboard',
            'page_name' => 'dashboard',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        // $pageName = 'dashboard';
        return view('dashboard.index')->with($data);
    }


}
