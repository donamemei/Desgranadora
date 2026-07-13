<?php

namespace App\Http\Controllers;
use Illuminate\View\View;

class AcercaController extends Controller
{
    public function index(): View
    {
        return view('acerca.index');
    }
}
