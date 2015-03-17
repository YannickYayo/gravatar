<?php
class User_image extends Eloquent
{
	public function user()
	{
		return $this->belongsTo('User');
	}
}