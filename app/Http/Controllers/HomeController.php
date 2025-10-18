<?php

namespace App\Http\Controllers;

use App\Helpers\HomePageHelper;

class HomeController extends Controller
{
    public function index()
    {
        $catalogos = HomePageHelper::getCatalogos();
        return view('home', $catalogos);
    }
}
