<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Feed;

class AdminController extends Controller
{

    public function index()
    {
        $items = Feed::all();
        return view('feeds.index', ['items' => $items]);
    }
}
