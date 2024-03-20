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
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'member_id',
        'amount',
        'date',
        'mode',
        'transaction_code',
        'type',
        'status',
    ];
    // protected $hidden = [];

    //set relation
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    //to get fullname
    public function getFullNameAttribute()
    {   
        return $this->firstname . ' ' . $this->lastname;
    }

    //calculate end date
    public function getEndDateAttribute()
    {
        $startDate = Carbon::parse($this->date);

        switch ($this->type) {
            case 'monthly':
                return $startDate->addMonth()->toDateString();
                break;
            case 'bi-monthly':
                return $startDate->addMonths(2)->toDateString();
                break;
            case 'annual':
                return $startDate->addYear()->toDateString();
                break;
            default:
                return $startDate->addMonth()->toDateString();
                break;
        }
    }

    protected static function booted()
    {
        static::saving(function ($membership) {
            if ($membership->end_date && $membership->end_date > now()) {
                $membership->status = 'active';
            } else {
                $membership->status = 'expired';
            }
        });
    }

}
