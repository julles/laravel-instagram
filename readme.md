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
### Konfigurasi

Buka file vendor/muhamadrezaar/instagram/InstagramConfig.php
masukan user id dan access token instagram anda
contoh :
```sh
return [
		'userId' => '1234567890',
		'accessToken' => '1619689047987654321', 
];
```

### Cara penggunaaan

1.Menampilkan Gambar low resolusi
  
  ```sh

<?php

foreach(IG::lowResolution() as $row)
{
	echo "<img src = '".$row."' />";
}

?>
```
2. Menampilkan Gambar standar resolusi

 ```sh

<?php

foreach(IG::standardResolution() as $row)

{
	echo "<img src = '".$row."' />";
}

?>

```

3.Menampilkan Informasi User
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

## License

### MIT

**ENJOY !!!**