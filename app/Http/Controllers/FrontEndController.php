<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sector;
use App\Models\Category;

class FrontEndController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $sectors=Sector::where(['status'=>1,'featured'=>1])->take(10)->get();
       return view('home',compact('sectors'));
    }


     public function quiz(Request $request)
    {

       $category=Category::where(['status'=>1,'slug'=>$request->slug])->first();

       return view('pages.quiz',compact('category'));
    }
}
