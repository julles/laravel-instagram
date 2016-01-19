# Laravel 5 Instagram Packages
Package Instagram untuk Laravel 5

### Installasi

Tambahkan Package pada composer.json
```sh
composer require muhamadrezaar/instagram
```
setelah package terdownload , register  provider  dan facade nya

Provider :
```sh
Oblagio\Instagram\InstagramServiceProvider::class,
```
Facade :
```sh
'IG' => Oblagio\Instagram\InstagramFacade::class,
```

Publish config
```sh
php artisan vendor:publish
```

### Konfigurasi

Buka file config/InstagramConfig.php
masukan user id dan access token instagram anda
contoh :
```sh
<?php
/* 	NOTES
 *  Jika hanya menampilkan data pribadi saja , cukup masukan userId dan accesToken
 *  Jika diperlukan autentikasi login semua nya wajib di isi 
 */
	
	return [
		'userId' => 'user-id-kamu',
		'accessToken' => 'access-token-kamu',
		
		'clientId' => 'client-id-kamu',
		'clientSecret' => 'client-secrets-kamu',
		'redirectUri' => 'redirect-uri-kamu',
	];

```

### Cara penggunaaan

Menampilkan Gambar low resolusi
  
```sh

<?php

foreach(IG::lowResolution() as $row)
{
	echo "<img src = '".$row."' />";
}

?>
```
Contoh Output Menampilkan gambar low resolution di browser

![alt tag](http://s15.postimg.org/n8nhl6r8r/low_resoulution.png)




Menampilkan Gambar standar resolusi

```sh

<?php

foreach(IG::standardResolution() as $row)

{
	echo "<img src = '".$row."' />";
}

?>

```

Menampilkan Informasi User

```sh

<?php

echo IG::username();

echo IG::bio(); 

echo IG::website();

echo IG::pic();

echo IG::fullName();

echo IG::countFollowers();

echo IG::countFollowing();

?>


```

Menampilkan Data Followers

```sh

<?php

foreach(IG::displayFollowers() as $row)

{
	echo $row['full_name'];
	echo $row['profile_picture'];
	echo $row['username'];
	echo $row['id'];
}

?>

```

Menampilkan Data Following

```sh

<?php

foreach(IG::displayFollowing() as $row)

{
	echo $row['full_name'];
	echo $row['profile_picture'];
	echo $row['username'];
	echo $row['id'];
}

?>

```

### Menggunakan Login Authenticate

contoh membuat link authentikasi (tombol login ke instagram)

```sh
<?php
echo "<a href = '".IG::getCodeAuth()."'>Login</a>";
?>
```
tombol diatas akan meredirect ke halaman login instagram , setelah si user login maka instagram akan meridirect ke halaman yang anda declare di InstagramConfig.php -> ('redirectUri' => 'bla bla bla').

contoh redirectUri : localhost:8000/instagram

selain meredirect ke halaman url anda tadi , instagram memberikan code di url anda , ini url nya localhost:8000/instagram?code=1234567.
nah di url ini lah kita bisa mendapatkan informasi si user yang login tadi , dengan 
cara meggunakan script berikut :

```sh
<?php

$ig = IG::auth($_GET['code']);

print_r($ig);

?>
```

semua informasi user yang login bisa di dapatkan :).



## Ada Pertanyaan ?

email aja ke : reza.wikrama3@gmail.com

## License

MIT

**ENJOY !!!**