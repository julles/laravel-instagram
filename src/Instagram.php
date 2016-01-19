<?php namespace Oblagio\Instagram;

class Instagram

{	

	protected $userId;
	
	protected $accessToken;

	public function __construct()

	{
		$this->userId = config('config.userId');

		$this->accessToken = config('config.accessToken');
	}

	public function getContents($url)

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

	public function getResultImage()

	{
		$url = "https://api.instagram.com/v1/users/".$this->userId."/media/recent/?access_token=".$this->accessToken;

		return $this->getContents($url);

	}

	public function getImage($params = "")

	{
		
		$arr = [];

		foreach($this->getResultImage() as $row)

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
		
		$url = "https://api.instagram.com/v1/users/".$this->userId."/?access_token=".$this->accessToken;

		return $this->getContents($url);
		
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

	

	public function displayFollowing()

	{
		$url = 'https://api.instagram.com/v1/users/self/follows?access_token='.$this->accessToken;
		return $this->getContents($url);
	}

	public function displayFollowers()

	{
		$url = 'https://api.instagram.com/v1/users/self/followed-by?access_token='.$this->accessToken;
		return $this->getContents($url);
	}

}