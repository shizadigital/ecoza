# Selamat Datang di Shiza Ecommerce

<p align="center"><img src="http://shiza.id/images/shiza-logo-web.png" width="275"></p>

Kami berfokus pada berbagai pengembangan aplikasi website dan mobile, termasuk pada pengembangan ecommerce yakni EcoZa (Ecommerce of Shiza). EcoZa merupakan aplikasi opensource yang dibangun dengan sukarela untuk memudahkan pekerjaan developer lain dalam menggembangkan aplikasi ecommerce serta memudahkan pengguna dalam mengoperasikan sebuah sistem ecommerce.

EcoZa saat ini dikembangkan dengan menggunakan salah satu mesin framework terpopuler saat ini yaitu [CodeIgniter](https://codeigniter.com/) versi 3.1.11 dan akan dikembangkan dengan CodeIgniter versi 4 untuk EcoZa versi 2.0.

Source Code (Kode Sumber) EcoZa dapat didownload secara gratis pada [github](https://github.com/shizadigital/shiza) yang telah disediakan.

## Requirements

- OS: Ubuntu 16.04 LTS or higher / Windows 7 or Higher (WampServer / XAMPP).
- SERVER: Apache 2 or NGINX.
- RAM: 2 GB or higher.
- PHP: 7.2 or higher.
- For MySQL users: 5.7.23 or higher.
- For MariaDB users: 10.2.7 or Higher.
- Composer: 1.6.5 or higher.
- php mbstring.
- [OpenSSL](https://www.php.net/manual/en/openssl.installation.php)
- [base64_encode](https://www.php.net/manual/en/function.base64-encode.php) and [base64_decode](https://www.php.net/manual/en/function.base64-decode.php)

## Installation and Configuration

**1. Download atau Clone Ecommerce Shiza:**

Clone:

[https://github.com/shizadigital/shiza.git](https://github.com/shizadigital/shiza.git)

Download:

[https://github.com/shizadigital/shiza/archive/master.zip](https://github.com/shizadigital/shiza/archive/master.zip)

**2. Extract Hasil Download ke Localhost (Jika file didownload dari github)**

~~~
http(s)://localhost/ecoza/
~~~

atau

~~~
http(s)://example.com/
~~~

**3. Install Dependensi**

Install dependensi menggunakan composer pada direktori ecommerce shiza. silahkan download composer terlebih dahulu [disini](https://getcomposer.org/)

```sh
$ composer install
```

**4. Konfigurasi Database**

Buka file *.env.example* kemudian rename menjadi *.env*

Buat database baru pada host Anda. Silahkan edit dan sesuaikan database pada file *.env* Anda:

```sh
DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=mypassword
DB_DATABASE=example
DB_PREFIX=example_
DB_CHARSET=utf8
```

**5. Install Migration & Seeder Database**

Install database migration & seeder dengan menggunakan command PHP

```sh
$ php index.php Migration install seed
```

**5. Akses Ecommerce Shiza pada browser**

~~~
http(s)://localhost/ecoza/
~~~

atau

~~~
http(s)://example.com/
~~~

## Contributing
Permintaan kontribusi dipersilakan. Untuk perubahan yang besar, silahkan laporkan masalah terlebih dahulu untuk membahas apa yang ingin Anda ubah.

Pastikan untuk memperbarui tes yang disesuaikan.

## License
EcoZa adalah framework E-Commerce yang sepenuhnya opensource yang akan selalu gratis di bawah [Lisensi MIT](https://github.com/shizadigital/shiza/blob/master/LICENSE)
