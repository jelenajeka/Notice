<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notices;
use App\NoticesType;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter','');
        $types = NoticesType::all();
        $notices = Notices::with('noticeby')->where('title', 'Like', '%' .$filter. '%')->get();
        return view('home', ['types' => $types, 'notices'=>$notices]);
    }
}
