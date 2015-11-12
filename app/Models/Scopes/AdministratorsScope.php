<?php

namespace App\Models\Scopes;

/* My uses */
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;


Class AdministratorsScope implements ScopeInterface {


	public function apply(Builder $builder, Model $model) {
		
		$builder->where('role', 'admin');
		
	}

	public function remove(Builder $builder, Model $model) {

	}
}