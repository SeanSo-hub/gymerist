<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'payments';
    protected $guarded = ['id'];
    protected $fillable = [];


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function calculateEndDate()
    {
        $plan_type = $this->plan_type;
        $plan_end_date = null;

        switch ($plan_type) {
            case 'session':
                $plan_end_date = Carbon::now()->addHours(24);
                break;
            case 'monthly':
                $plan_end_date = Carbon::now()->addMonth();
                break;
            case 'quarterly':
                $plan_end_date = Carbon::now()->addMonths(3);
                break;
            case 'half-year':
                $plan_end_date = Carbon::now()->addMonths(6);
                break;
            case 'annual':
                $plan_end_date = Carbon::now()->addYear();
                break;
            default:
                $plan_end_date = Carbon::now()->addMonth();
                break;
        }

        return $plan_end_date->toDateString();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) { // Capture $payment here
            $payment->plan_start_date = Carbon::now();
            $payment->plan_end_date = $payment->calculateEndDate();
            $payment->plan_status = 'Active';
            $payment->save();
        });

        static::updating(function ($payment) {
            if ($payment->isDirty('plan_type')) {
                $payment->plan_end_date = $payment->calculateEndDate();
            } 
        });
    }

    public static function getTotalAmountForCash()
    {
        return self::where('payment_type', 'cash')->sum('amount');
    }

    public static function getTotalAmountForGCash()
    {
        return self::where('payment_type', 'gcash')->sum('amount');
    }

    public static function getTotalPlanRevenue()
    {
        $cashTotals = self::getTotalAmountForCash();
        $gcashTotals = self::getTotalAmountForGCash();

        return $cashTotals + $gcashTotals;
    }


    public function addToCheckins($memberId)
    {
        $checkin = new Checkin();
        $checkin->member_id = $memberId; 
        $formattedDate = Carbon::now()->format('Y-m-d H:i:s');
        $checkin->date = $formattedDate;
        $checkin->save();
    }

    public function storePlanInfo($planType, $paymentType, $amount, $transactionCode = null)
    {
        $this->plan_type = $planType;
        $this->payment_type = $paymentType;
        $this->amount = $amount;

        $this->plan_start_date = now();

        if ($planType !== null) {
            $this->plan_end_date = $this->calculateEndDate();
            $this->plan_status = 'active';
        } else {
            $this->plan_status = 'inactive'; 
        }

        if (!is_null($transactionCode)) {
            $this->transaction_code = $transactionCode;
        }

        $this->save();

        return $this;
    }

    public function updatePlanStatus()
    {
        if ($this->plan_end_date !== null && $this->plan_end_date->isPast()) {
            $this->plan_status = 'expired';
            $this->save();
        }
    }

}
