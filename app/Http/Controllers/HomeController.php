<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $titlePage = "Mitology - Homepage";

        return view('home', compact(
            'titlePage'
        ));
    }
}
