<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index() {
        return view('templates.layout');
    }

    public function page($slug = '') {
        $data = [
            'slug' => $slug
        ];
        return view('templates.page', $data);
    }

    public function category() {
        return view('templates.category');
    }
}
