<?php

namespace App\Http\Controllers;

use App\Models\studentModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class StudentController extends Controller
{
    public function index()
    {
        return view('bulletin.indexBulletin');
    }
}