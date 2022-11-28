<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecureAccountController extends Controller
{
    public function secure(Request $request)
    {
        return response()->json(['message' => 'Not implemented yet']);
    }
}
