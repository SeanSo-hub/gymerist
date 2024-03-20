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

        // Retrieve the member details based on the code
        $member = Member::where('code', $code)->first();

        if (!$member) {
            // Handle the case where the member doesn't exist
            return view('home', ['code' => $code, 'message' => 'User does not exist']);
        }

        // Check if the member's status is active
        $membership = Payment::where('member_id', $member->id)->first();

        if (!$membership || $membership->status !== 'active') {
            // If membership is not active, set membership to null
            $membership = null;
        } else {
            // If the status is active, proceed with check-in
            $member->addToCheckins();
        }

        // Return the view with the necessary data
        return view('home', ['code' => $code, 'member' => $member, 'membership' => $membership]);
    }

    // Other controller methods...
}
