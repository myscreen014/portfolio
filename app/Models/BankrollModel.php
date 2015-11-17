<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankrollModel extends Model
{
  
   	protected $table = 'bankrolls';

    /* Relations */
	public function page() {
		return $this->belongsTo('App\Models\UserModel', 'user_id');
	}
	public function sessions() {
    	return $this->hasMany('App\Models\SessionModel', 'bankroll_id');
    }

}
