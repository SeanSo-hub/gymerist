<?php

namespace App\Http\Controllers;


use App\Models\Checkin;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function showCheckin(Request $request): View
    {
        $perPage = 10; // Adjust the number of records per page as needed

        // Using Eloquent with latest first sorting
        $checkins = Checkin::orderBy('date', 'desc')->paginate($perPage);

        return view('vendor/backpack/ui/checkin', compact('checkins'));
    }

    public function index(Request $request) {

        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');
    
        $checkins = Checkin::query(); // Adjust query builder
        if ($from_date) {
            $checkins->whereDate('date', '>=', $from_date);
        }
        if ($to_date) {
            $checkins->whereDate('date', '<=', $to_date);
        }
    
        $checkins = $checkins->get(); // Replace with your logic
    
        return view('vendor/backpack/ui/checkin', compact('checkins'));

    }
    
}
