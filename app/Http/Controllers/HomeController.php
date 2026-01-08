<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;

class HomeController extends Controller
{
    public function index()
    {
        $recentTemplates = Template::latest()->take(5)->get();
        $totalTemplates = Template::count();
        
        return view('home', compact('recentTemplates', 'totalTemplates'));
    }
}