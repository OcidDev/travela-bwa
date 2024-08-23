<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\PackageBank;
use App\Models\PackageTour;
use Illuminate\Http\Request;
use App\Models\PackageBooking;
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
        // dd($request->all());
        $data = $request->validate([
            'startdate' => 'required|date',
            'quantity' => 'required|numeric',
            'totalamount' => 'required|numeric',
        ]);
        // dd($packageTour->id);
        $bank = PackageBank::first();
        $data['packagetoursfk'] = $packageTour->id;
        $data['usersfk'] = Auth::user()->id;
        $data['packagebanksfk'] = $bank->id;
        $data['proof'] = 0;
        $data['ispaid'] = 0;
        $data['insurance'] = 300000 * $data['quantity'];
        $data['tax'] = $packageTour->price * 0.1 * $data['quantity'];
        $data['subtotal'] = $packageTour->price * $data['quantity'];
        $data['totalamount'] = $data['subtotal'] + $data['tax'] + $data['insurance'];
        $data['startdate'] = new Carbon($request->startdate);
        $data['enddate'] = $data['startdate']->addDays($packageTour->days);
        $packageBooking = PackageBooking::create($data);
        return redirect()->route('choose.bank', $packageBooking->id);
    }
    public function choose_bank(PackageBooking $packageBooking)
    {
        $banks = PackageBank::all();
        return view('frontend.choosebank', compact('banks', 'packageBooking'));

    }

    public function choose_bank_store(Request $request, PackageBooking $packageBooking)
    {
        $data = $request->validate([
            'bankname' => 'required',
        ]);
        $packageBooking->update([
            'packagebanksfk' => $data['bankname'],
        ]);
        dd($packageBooking);
        // return redirect()->route('book.payment', $packageBooking->id);
    }
}
