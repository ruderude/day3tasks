<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LiffController extends Controller
{
    public function today(): View
    {
        return view('liff.today');
    }

    public function history(): View
    {
        return view('liff.history');
    }
}
