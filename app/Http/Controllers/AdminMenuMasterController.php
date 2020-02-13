<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMenuMasterController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Menu Admin Master',
            'subtopbar' => true,
            'dataBC' => [
                ['label' => 'Dashboard', 'url' => route('admin.adminmenumaster.index')],
                ['label' => 'Menu Admin Master']
            ]
        ];
        return view('admin.adminmenumaster.index', $data);
    }
}
