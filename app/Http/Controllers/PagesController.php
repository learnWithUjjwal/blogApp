<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Welcome to Laravel';
        return view('pages.welcome', compact('title'));
    }
    public function services(){
        $data = array(
            'title' => 'Services',
            'services' => ['Web Programming', 'Blogging', 'Oration']
        );
        return view('pages.services')->with($data);
    }
    public function about(){
        $title = 'About';
        return view('pages.about') -> with('title', $title);
    }
}
