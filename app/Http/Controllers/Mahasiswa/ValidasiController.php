<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function index()
    {
        return view('mahasiswa.validasi');
    }
}
