<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHomePage()
    {
        return view('home');
    }

    public function submitForm(Request $request)
    {
        $code = $request->input('code');


        $member = Member::where('code', $code)->first();

        if (!$member) {

            return view('home', ['code' => $code, 'message' => 'User does not exist']);
        }


        $payment = Payment::where('member_id', $member->id)->first();

        if (!$payment || $payment->plan_status !== 'active') {

            $payment = null;
        } else {

            $memberId = $member->id;  // Retrieve the member ID
            $payment->addToCheckins($memberId); 
        }


        return view('home', ['code' => $code, 'member' => $member, 'payment' => $payment]);
    }


}
