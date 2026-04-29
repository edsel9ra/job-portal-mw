<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
        // cambia "name" si tu columna es otra
        return response()->json(
            Branch::query()->select('id', 'name')->orderBy('name')->get()
        );
    }
}