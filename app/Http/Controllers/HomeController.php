<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\AuthenticatedRequest;
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
    public function index(AuthenticatedRequest $request)
    {
        $subscriptions = Auth::user()->subscriptions;

        return view('home', compact('subscriptions'));
    }
}
