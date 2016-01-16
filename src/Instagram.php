<?php namespace Oblagio\Instagram;

class Instagram

{	public $userId;
	
	public $accessToken;

	public function __construct()

	{
		$this->userId = config('config.userId');

		$this->accessToken = config('config.accessToken');
	}

	public function getResultImage()

	{
	
		$userId = config('config.userId');

		$token = config('config.accessToken');
		
		$url = "https://api.instagram.com/v1/users/$userId/media/recent/?access_token=$token";

		
		try
		{
			$contents = file_get_contents($url);
			
			$result = json_decode($contents , true);

			return $result;
		
		}catch(\Exception $e){
		
			throw new \Exception("Access Token Atau User ID Salah , silahkan cek lagi!");
		
		}

	}

	public function getImage($params = "")

	{
		
		$arr = [];

		foreach($this->getResultImage()['data'] as $row)

		{
			$arr[] = $row['images'][$params]['url'];
		}

		return $arr;
	}

	public function lowResolution()

	{
		return $this->getImage('low_resolution');
	}

	public function standardResolution()

	{
		return $this->getImage('standard_resolution');
	}

	public function getResultUser()

	{
		$userId = config('config.userId');

		$token = config('config.accessToken');
		
		$url = "https://api.instagram.com/v1/users/$userId/?access_token=$token";

		
		try
		{
			$contents = file_get_contents($url);
			
			$result = json_decode($contents , true);

			return $result['data'];
		
		}catch(\Exception $e){
		
			throw new \Exception("Access Token Atau User ID Salah , silahkan cek lagi!");
		
		}
	}

	public function profile($param)

	{
		return $this->getResultUser()[$param];
	}

	public function username()

	{
		return $this->profile('username');
	}

	public function bio()

	{
		return $this->profile('bio');
	}

	public function website()

	{
		return $this->profile('website');
	}

	public function pic()

	{
		return $this->profile('profile_picture');
	}

	public function fullName()

	{
		return $this->profile('full_name');
	}

	public function counts($param)

	{
		return $this->getResultUser()['counts'][$param];
	}

	public function countFollowers()

	{
		return $this->counts('followed_by');
	}

	public function countFollowing()

	{
		return $this->counts('follows');
	}

	public function get_contents($url)

	{

		try
		{
			$contents = file_get_contents($url);
			
			$result = json_decode($contents , true);

			return $result['data'];
		
		}catch(\Exception $e){
		
			throw new \Exception("Access Token Atau User ID Salah , silahkan cek lagi!");
		
		}
	}

	public function displayFollowing()

	{
		$url = 'https://api.instagram.com/v1/users/self/follows?access_token='.$this->accessToken;
		return $this->get_contents($url);
	}

}