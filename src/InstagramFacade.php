<?php namespace Oblagio\Instagram;

use Illuminate\Support\Facades\Facade;

class InstagramFacade extends Facade

{

	public static function getFacadeAccessor()

	{
		return 'register-instagram';
	}

}