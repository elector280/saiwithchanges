<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    
    public function Index(){
        return view('home.about-us');
    } // end mehtod 


    public function ContactMethod(){
       return view('home.contact-us');
    }


}
