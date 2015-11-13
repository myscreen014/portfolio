<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* My uses */
use App\Models\UserModel;
use App\Models\Scopes\AdministratorsScope;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Passwords\CanResetPassword;


class AdministratorModel extends UserModel
{

	use Authenticatable, Authorizable, CanResetPassword;

	public function __construct(array $attributes = []) {
		AdministratorModel::addGlobalScope(new AdministratorsScope());
	}

	public function getDates() {
		return ['created_at', 'updated_at', 'last_login'];
	}

   
}
