<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $user = auth()->user();

        $courses = [
            (object)[
                'nama' => 'Struktur Data Python',
                'guru' => 'Ferdiansyah Pratama',
                'progress' => 75
            ]
        ];

        return view('dashboard', [

            'user' => $user,
            'courseAktif' => count($courses),
            'progress' => 75,
            'pretest' => '1/2',
            'postest' => '0/2',
            'nilai' => 88,
            'courses' => $courses

        ]);
    }
}
