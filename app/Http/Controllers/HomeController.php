<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $titlePage = "Mythology - Homepage";

        return view('logged.home.index', compact(
            'titlePage'
        ));
    }
}
