<?php

namespace App\Http\Controllers;
use Illuminate\View\View;

class ContactoController extends Controller
{
    public function index(): View
    {
        return view('contacto.index');
    }
}
