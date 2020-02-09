<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Dashboard Cui',
            'dataBC' => [
                ['label' => 'Home', 'url' => route('admin.dashboard.index')],
                ['label' => 'Dashboard']
            ]
        ];
        return view('admin.dashboard.index', $data);
    }
}
