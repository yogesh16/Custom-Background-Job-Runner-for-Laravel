<?php

namespace App\Http\Controllers;

use App\Models\BackgroundJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = BackgroundJob::orderBy('created_at', 'desc')->paginate(10);
        return view('jobs.index', compact('jobs'));
    }
}
