<?php namespace Oblagio\Instagram;

/**
 * Laravel Instagram Package , Indonesia Punya 
 *
 * @author   Muhamad Reza Abdul Rohim <reza.wikrama3@gmail.com>
 */

class Instagram

{	

	protected $userId;
	
	protected $accessToken;

	protected $clientId;

	protected $clientSecret;

	protected $redirectUri;

	public function __construct()

	{
		$this->userId = config('config.userId');

		$this->accessToken = config('config.accessToken');
	
		$this->clientId = config('config.clientId');

		$this->clientSecret = config('config.clientSecret');

		$this->redirectUri = config('config.redirectUri');
	}

	public function setContents($url)

	{

		try
		{
			$contents = file_get_contents($url);
			
			$result = json_decode($contents , true);

			return $result;
		}catch(\Exception $e){
		
			throw new \Exception("Access Token Atau User ID Salah , silahkan cek lagi!");
		
		}
	}

	public function getContents($url)
	{
		return $this->setContents($url)['data'];
	}

	public function getResultImage($count="")

	{
		if(!empty($count))
		{
			$count = "&count=".$count;
		}else{
			$count = "";
		}

		$url = "https://api.instagram.com/v1/users/".$this->userId."/media/recent/?access_token=".$this->accessToken.$count;

		return $this->getContents($url);

	}

	public function getImage($params = "",$count="")

	{
		
		$arr = [];

		foreach($this->getResultImage($count) as $row)

		{
			$arr[] = $row['images'][$params]['url'];
		}

		return $arr;
	}

	public function lowResolution($count = "")

	{
		return $this->getImage('low_resolution',$count);
	}

	public function standardResolution($count="")

	{
		return $this->getImage('standard_resolution',$count);
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

	public function getCodeAuth()

	{
		$url = "https://api.instagram.com/oauth/authorize/?client_id=".$this->clientId."&redirect_uri=".$this->redirectUri."&response_type=code";
		return $url;
	}

	public function curlAuth($code)

	{

		$url = "https://api.instagram.com/oauth/access_token";

		$ch = curl_init();

		$info = [

			'client_id' => $this->clientId,
			'client_secret' => $this->clientSecret,
			'grant_type' => 'authorization_code',
			'redirect_uri' => $this->redirectUri,
			'grant_type' => 'authorization_code',
			'code' => $code,
		];

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output
		$result = json_decode(curl_exec($ch) , true);
		curl_close ($ch);
		
		return $result;

	}

	public function auth($code)

	{
		$auth = $this->curlAuth($code);
		
		$jadikan_flatt_array = array_flatten($auth);
		$masukan_key = ['access_token' , 'username' , 'bio' , 'website' , 'pic' , 'full_name', 'id'];
		
		$hasil = array_combine($masukan_key, $jadikan_flatt_array);

		return $hasil;
	}

}