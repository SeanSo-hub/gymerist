<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Backpack\Basset\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use CrudTrait;
    use HasFactory;


    protected $table = 'members';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'code',
        'firstname',
        'lastname',
        'contact_number',
        'email',
        'payment_type',
        'amount',
        'subscription_date',
        'subscription_status',
        'subscription_end_date'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function membership()
    {
        return $this->hasMany(Membership::class);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['fullname'] = $this->firstname . ' ' . $this->lastname;
    }

    protected static function boot()
    {
        parent::boot();

        // Creating event to generate and set the member code
        static::creating(function ($member) {
            $member->generateAndSetMemberCode();
        });

        // Created event to update the member code with the actual ID
        static::created(function ($member) {
            $member->update(['code' => now()->format('md') . '-' . str_pad($member->id, 4, '0', STR_PAD_LEFT)]);
        });
    }

    public function generateAndSetMemberCode()
    {
        $memberCode = now()->format('md') . '-' . str_pad(0, 4, '0', STR_PAD_LEFT);

        $this->attributes['code'] = $memberCode;
    }

    public function storePaymentInfo($paymentType, $amount, $transactionCode = null)
    {

        $this->payment_type = $paymentType;
        $this->amount = $amount;

        if ($paymentType !== null) {

            $this->subscription_status = 'active';

            $this->subscription_start_date = now();
            $this->subscription_end_date = now()->addYear();
        } else {

        }

        if (!is_null($transactionCode)) {
            $this->transaction_code = $transactionCode;
        }

        $this->save();

        return $this;
    }

    public static function getTotalSubscription()
    {
        return self::sum('amount');
    }

    public static function getTotalRevenue()
    {
        $subscriptionTotals = self::getTotalSubscription();
        $planPaymentTotals = Payment::getTotalPlanRevenue();

        return $subscriptionTotals + $planPaymentTotals;
    }

    
    // public static function getTotalCashPaymentsForAllMembers()
    // {
    //     $totalCashPayments = $member->getTotalAmountForCash();
    //     $members = Member::all();

    //     foreach ($members as $member) {
    //         $totalCashPayments = $member->getTotalAmountForCash();
    //     }

    //     return $totalCashPayments;
    // }

    


}
