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

    public function categories(Category $categories)
    {
        $categories = Category::orderByDesc('id')->paginate('10');
        // return view('frontend.categories', compact('categories'));
    }

    public function details(PackageTour $packageTour)
    {
        return view('frontend.details', compact('packageTour'));
    }

    public function booking(PackageTour $packageTour)
    {
        // dd($packageTour->price);
        return view('frontend.book', compact('packageTour'));
    }
    public function book_store(Request $request, PackageTour $packageTour)
    {
        $user = Auth::user()->id;
        $bank = PackageBank::orderByDesc('id')->first();

        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'address' => 'required|string',
            'total' => 'required|string',
            'package_toursfk' => 'required',
            'usersfk' => 'required',
        ]);
        return view('frontend.checkout');
    }
}
