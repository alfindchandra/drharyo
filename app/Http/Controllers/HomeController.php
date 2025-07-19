<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Dokter;
use App\Models\Antrian;
use App\Models\Schedule;

class HomeController extends Controller
{ 
   
    public function showAntrianForm()
    {
        $cabang = Cabang::all();
        return view('index', compact('cabang'));
    }
}