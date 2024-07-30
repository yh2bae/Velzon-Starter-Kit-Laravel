<p  align="center"><a  href="https://laravel.com"  target="_blank"><img  src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  width="400"  alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/yh2bae/Velzon-Starter-Kit-Laravel"><img src="https://img.shields.io/github/v/release/yh2bae/Velzon-Starter-Kit-Laravel?style=social">
</a><a href="https://github.com/yh2bae/Velzon-Starter-Kit-Laravel"><img src="https://img.shields.io/github/last-commit/yh2bae/Velzon-Starter-Kit-Laravel?style=social">
 </a><a href="https://github.com/yh2bae/Velzon-Starter-Kit-Laravel"><img src="https://img.shields.io/github/forks/yh2bae/Velzon-Starter-Kit-Laravel?style=social">
 </a><a href="https://github.com/yh2bae/Velzon-Starter-Kit-Laravel"><img src="https://img.shields.io/github/stars/yh2bae?style=social">
 </a>
</p>


## Starter Kit Laravel 11.x 

## Introduction
Laravel Starterkit dengan Template Velzon! Starterkit ini dirancang untuk mempercepat pengembangan aplikasi web berbasis Laravel dengan menggunakan template admin Velzon yang modern dan responsif. Dengan starterkit ini, dapat langsung fokus pada pengembangan fitur aplikasi tanpa harus memulai dari awal.

## Features

- Authentication:
    *   Register
    *   Login
    *   Forget Password
- Example UI Dashboard.
- Password Validation.
- Authorization :
    *   Data User
        * Create
        * Edit
        * Delete
        * Login As
    *   Data Role
        * Create
        * Edit
        * View
        * Delete
    *   List Permissions
        * Create
        * Edit
        * Delete
 - Profile Account :
    * Change Photo Profile.
    * Update Data Profile.
    * Update Password

    
## Requered :
- PHP 8.2
- Composer version 2.7.7
- MySQL

## Package PHP :
- "spatie/laravel-permission": "^5.5",
    > Note: Untuk Manajemen Authorization User.
- "yajra/laravel-datatables": "^9.0",
    > Note: Untuk Manajemen Table Display.
    
## Setup :

- Clone Project dari Github :
```shell
https://github.com/yh2bae/Velzon-Starter-Kit-Laravel.git
```

- Buat .env dari file .env.example
- Jalankan perintah :
```shell
composer install
```
- Jalankan perintah :
```shell
php artisan key:generate
```
- Buat Database.
- Konfigurasi Database.
- Lalu jalankan perintah :
```shell
php artisan migrate --seed
```

- Kemudian jalankan perintah :
```shell
php artisan storage:link
```

- Untuk  User :
```shell
Super Admin
email: superadmin@app.com Password: rahasia!

Admin
email: admin@app.com Password: rahasia!

User
email: user@app.com Password: rahasia!

```
## License

MIT license adalah lisensi perangkat lunak bebas guna yang berasal dari Massachusetts Institute of Technology (MIT). Lisensi ini ringkas dan to the point. Lisensi ini membolehkan pengguna untuk melakukan apapun pada kode program seperti pada Apache License. Lisensi ini hanya mewajibkan pengguna untuk menyertakan lisensi dan copyright si pembuat pada kode yang didistribusikan ulang dan tidak ada larangan untuk menggunakan trademark dari si pembuat asli. Selain itu pengguna juga tidak berhak untuk menuntut si pembuat ketika terjadi kerusakan pada perangkat lunak tersebut.
[MIT license](https://opensource.org/licenses/MIT).

