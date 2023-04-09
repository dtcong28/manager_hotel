<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return Inertia::render('Web/Contact/Index');
    }

}
