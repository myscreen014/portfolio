<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    //

    protected $table = 'sessions';

    public function bankroll() {
    	return $this->belongsTo('App\Models\BankrollModel', 'bankroll_id');
    }
}
