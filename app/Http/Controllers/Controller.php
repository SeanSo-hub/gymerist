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
        $checkins = Checkin::orderBy('date', 'desc')->paginate(10);
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

    public function showCashflow(Request $request): View
    {
        $payments = Payment::all();

        return view('vendor/backpack/ui/cashflow', compact('payments'));
    }

    public function checkinFilter(Request $request)
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

        $checkins = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();;

        return view('vendor/backpack/ui/checkin', compact('checkins'));
    }

    public function memberFilter(Request $request)
    {

        if ($request->has('clear')) {

            $members = Member::orderBy('date', 'desc')->paginate(10);
            return view('vendor/backpack/ui/member', compact('members'));
        }

        $filterBy = $request->input('filter_by');
        $weekNumber = $request->input('week');
        $month = $request->input('month');
        $year = $request->input('year');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Member::query();

        switch ($filterBy) {
            case 'month':
                if ($month) {
                    $query->whereMonth('created_at', $month);
                }
                break;

            case 'year':
                if ($year) {
                    $query->whereYear('created_at', $year);
                }
                break;

            case 'custom':


                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                break;

            default:
                // No filter applied
                break;
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();;

        return view('vendor/backpack/ui/member', compact('members'));
    }

    public function paymentFilter(Request $request): View
    {

        if ($request->has('clear')) {

            $payments = Payment::orderBy('created_at', 'desc')->paginate(10);
            $members = Member::orderBy('created_at', 'desc')->paginate(10);

            return view('vendor/backpack/ui/payment', compact('payments', 'members'));
        }

        $filterBy = $request->input('filter_by');
        $month = $request->input('month');
        $year = $request->input('year');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Payment::query();

        switch ($filterBy) {
            case 'month':
                if ($month) {
                    $query->whereMonth('created_at', $month);
                }
                break;

            case 'year':
                if ($year) {
                    $query->whereYear('created_at', $year);
                }
                break;

            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                break;

            default:
                break;
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $members = Member::orderBy('created_at', 'desc')->paginate(10);

        return view('vendor/backpack/ui/payment', compact('payments', 'members'));
    }

    public function cashflowFilter(Request $request)
    {
        // Define the function to get total based on filter
        $filterBy = $request->input('filter_by');
        $month = $request->input('month');
        $year = $request->input('year');
        $currentDate = Carbon::now();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $total = 0;

        switch ($filterBy) {
            case 'day':
                $total = Payment::whereDate('created_at', $currentDate)
                    ->sum('amount');
                break;
            case 'week':
                $total = Payment::whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfWeek(),
                    Carbon::parse($endDate)->endOfWeek(),
                ])->sum('amount');
                break;
            case 'month':
                $currentDate->startOfMonth();
                $total = Payment::whereMonth('created_at', $currentDate->month)
                    ->whereYear('created_at', $currentDate->year)
                    ->sum('amount');
                break;
            case 'year':
                $currentDate->startOfYear(); // Set date to the beginning of the year
                $total = Payment::whereYear('created_at', $currentDate->year) // Use $currentDate->year
                    ->sum('amount');
                break;
            case 'custom':
                if ($startDate && $endDate) {
                $total = Payment::whereBetween('created_at', [$startDate, $endDate])
                    ->sum('amount');
                }
                break;
            case 'cash':
                $total = Payment::getTotalAmountForCash();
                break;
            case 'gcash':
                $total = Payment::getTotalAmountForGCash();
                break;
            case 'total_plan':
                $total = Payment::getTotalPlanRevenue();
                break;
            default:
                break;
        }

        // Pass data to the view
        return view('vendor/backpack/ui/cashflow', compact('total'));
    }
}
