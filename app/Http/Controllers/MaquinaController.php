<?php

namespace App\Http\Controllers;
use Illuminate\View\View;

class MaquinaController extends Controller
{
    public function index(): View
    {
        return view('maquina.index');
    }
}