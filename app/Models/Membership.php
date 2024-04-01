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
    protected $guarded = ['id'];
    protected $fillable = [
        'fullname',
        'start_date',
        'end_date',
        'plan_status'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    
 
}
