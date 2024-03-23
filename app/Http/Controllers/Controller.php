<?php

namespace App\Http\Controllers;


use App\Models\Member;
use App\Models\Checkin;
use App\Models\Payment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function showCheckin(Request $request): View
    {
        $checkins = Checkin::paginate(10);
        $members = Member::paginate(10);

        return view('vendor/backpack/ui/checkin', compact('checkins', 'members'));
    }

    public function showMember(Request $request): View
    {
        $members = Member::paginate(10);

        return view('vendor/backpack/ui/member', compact('members'));
    }

    public function showPayment(Request $request): View
    {
        $payments = Payment::paginate(10);
        $members = Member::paginate(10);

        return view('vendor/backpack/ui/payment', compact('payments', 'members'));
    }

    public function filter(Request $request): View
    {

        if ($request->has('clear')) {

            $checkins = Checkin::orderBy('date', 'desc')->paginate(10);
            return view('vendor/backpack/ui/checkin', compact('checkins'));
        }

        $filterBy = $request->input('filter_by');
        $weekNumber = $request->input('week');
        $month = $request->input('month');
        $year = $request->input('year');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Checkin::query();

        switch ($filterBy) {
            case 'week':
                if ($weekNumber) {
                    $query->whereBetween('date', [
                        Carbon::now()->startOfWeek()->addWeek($weekNumber - 1),
                        Carbon::now()->endOfWeek()->addWeek($weekNumber - 1)
                    ]);
                }
                break;

            case 'month':
                if ($month) {
                    $query->whereMonth('date', $month);
                }
                break;

            case 'year':
                if ($year) {
                    $query->whereYear('date', $year);
                }
                break;

            case 'custom':
                

                if ($startDate && $endDate) {
                    $query->whereBetween('date', [$startDate, $endDate]);
                }
                break;

            default:
                // No filter applied
                break;
        }

        $checkins = $query->orderBy('date', 'desc')->paginate(10);

        return view('vendor/backpack/ui/checkin', compact('checkins'));
    }

}
