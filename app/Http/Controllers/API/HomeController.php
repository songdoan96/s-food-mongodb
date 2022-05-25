<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth:api']);
    }
    public function geProducts()
    {
        return response(['products' => Product::all()]);
    }
}
