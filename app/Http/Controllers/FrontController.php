<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\PackageTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index()
    {
        // $id = Auth::user()->id;
        // $user = User::find($id);
        $categories = Category::orderByDesc('id')->paginate('10');
        $tours = PackageTour::orderByDesc('id')->paginate('10');
        return view('frontend.index', compact('categories', 'tours'));
    }
    public function book(PackageTour $packageTour)
    {
        // return view('front.book', compact('packageTour'));
    }
}
