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
        'fullname',
        'contact_number',
        'email',
        'member_id',
        'fullname',
        'subscription_status',
        'subscription_date',
        'subscription_end_date'
    ];

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function membership() {
        return $this->hasMany(Membership::class);
    }

    public function getFullNameAttribute() {   
        return $this->attributes['fullname'] = $this->firstname . ' ' . $this->lastname;
    }

    protected static function boot() {
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

    public function generateAndSetMemberCode() {
        $memberCode = now()->format('md') . '-' . str_pad(0, 4, '0', STR_PAD_LEFT);
        
        $this->attributes['code'] = $memberCode;
    }

    public function addToCheckins() {
        $checkin = new Checkin();
        $checkin->fullname = $this->firstname . ' ' . $this->lastname;
        $formattedDate = Carbon::now()->format('Y-m-d H:i:s');
        $checkin->date = $formattedDate;
        $checkin->save();
    }

    public function getStatusAttribute() {
        return $this->payments->first() ? $this->payments->first()->status : '-'; // Display '-' or desired placeholder if no payment
    }    

}
