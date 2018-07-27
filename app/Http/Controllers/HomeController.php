<?php

namespace App\Http\Controllers;

use App\Repositories\OutageRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function welcome(OutageRepository $outageRepository)
    {

        $outages = $outageRepository->scopeQuery(function($query){
            return $query->future();
        })->all();

        return view('welcome', compact('outages'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home');
    }
}
