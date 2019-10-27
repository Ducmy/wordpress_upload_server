Hướng dẫn upload source code từ local lên CPanel:

1. Phía Local thì sẽ upload 2 phần là db (database) và source code:

    A. Database:
     Vào http://localhost/phpmyadmin, chọn tên database mà bạn sử dụng chọn Wordpress, chọn Tab Export -> Nhấn Go để save file.

    Lưu ý: Đa số các cài đặt máy chủ XAMPP sẽ có mặc định quyền user là root và password là rỗng: '', nên khi upload source code nào lên server chúng ta sẽ phải thay đổi lại.

    -> wp-config.php file trên local host:

    ....................

    define( 'FS_METHOD', 'direct' );

    define( 'DB_NAME', 'wp_mynguyen' );

    /** MySQL database username */
    
    define( 'DB_USER', 'root' );                  =>  Sẽ phải thay đổi trên CPanel(*)

    /** MySQL database password */
    
    define( 'DB_PASSWORD', '' );                 =>  Sẽ phải thay đổi trên CPanel(*)
  
    /** MySQL hostname */
    
    define( 'DB_HOST', 'localhost' );

    .........................
    
    B. Source code.
    Các bạn vào thư mực htdocs và nén lại tất cả các tập tin, (có thể dưới dạng *.zip)
    
2. Phía Cpanel thì chúng ta thực hiện các bước sau:
    A. Tạo database trùng tên với database dưới local.
    B. Upload database từ local vô máy chủ phpadmin của Cpanel.
    C. Tạo username và password sử dụng cho database, phần (*) mình đã đề cập ở trên.
    D. Add username đã tạo vào database.
    E. Tiến hành sửa file wp-config.php để thay đổi cấu hình cho Cpanel:
    
    
    -> wp-config.php file trên cpanel host:
    
    
    define( 'DB_NAME', 'wp_mynguyen' );

    /** MySQL database username */
    define( 'DB_USER', 'wp_mynguyen' );

    /** MySQL database password */
    define( 'DB_PASSWORD', 'ducmy2020' );

    /** MySQL hostname */
    define( 'DB_HOST', 'localhost' );
    
    F. Tiến hành sửa về các thông số Login trên Datbase.
    Mặc định thì trong source code của máy chủ Local thì nó sẽ được thiết lập là Local Host, vì vậy nếu khi đăng nhập website 
    thì redirect qua trang local, 
    Vào trang quản trị Database-> chọn database -> chọn wp-login sửa các đường dẫn về tên miền chúng ta thiết lập
    https://stackoverflow.com/questions/9764722/why-does-my-page-redirect-to-localhost-in-my-wordpress-blog
    
    
    
