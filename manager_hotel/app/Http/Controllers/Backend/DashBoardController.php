<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;

class DashBoardController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return Inertia::render('Admin/DashBoard/Index');
    }
}
