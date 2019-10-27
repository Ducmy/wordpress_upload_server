Hướng dẫn upload source code từ local lên CPanel:

Phía Local: sẽ upload 2 phần là db (database) và source code:

Database:
$ Vào http://localhost/phpmyadmin

$ Export database

Lưu ý: Đa số các cài đặt máy chủ XAMPP sẽ có mặc định quyền user là root và password là rỗng: '',

wp-config.php file:

....................

define( 'FS_METHOD', 'direct' );

define( 'DB_NAME', 'wp_mynguyen' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

.........................
