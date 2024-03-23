<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'memberships';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'fullname',
        'start_date',
        'end_date',
        'plan_status'
    ];
    // protected $hidden = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    
    // public function payment()
    // {
    //     return $this->belongsTo(Payment::class);
    // }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($membership) { // Capture $payment here
            $membership->start_date = Carbon::now();

            $membership = new Membership();
            $membership->member_id = $membership->member_id;
            $membership->start_date = $membership->start_date;
            $membership->end_date = $membership->calculateEndDate();
            $membership->plan_status = 'Active';
            $membership->save();
        });

    }

    
 
}
