# Hướng dẫn upload source code từ local lên CPanel:

### 1. Local host (XAMPP)
##### A. Database:
     Vào http://localhost/phpmyadmin, chọn tên database mà bạn sử dụng chọn Wordpress, chọn Tab Export -> Nhấn Go để save file.

    Lưu ý: Đa số các cài đặt trên máy chủ XAMPP trên local sẽ có mặc định quyền root và password là rỗng nên khi upload source code nào lên server chúng ta sẽ phải thay đổi các thông số này.

wp-config.php
    
  

> define( 'DB_NAME', 'blog' );

> /** MySQL database username */
    
> define( 'DB_USER', 'root' );                  =>  Thông số mặc định nên không thể thay đổi

 > /** MySQL database password */
    
 > define( 'DB_PASSWORD', '' );                 =>  Thông số mặc định nên không thể thay đổi
  
  > /** MySQL hostname */
    
 > define( 'DB_HOST', 'localhost' );


###### B. Source code.
    Các bạn vào thư mực htdocs và nén lại tất cả các tập tin, (có thể dưới dạng *.zip)
    
##### 2. CPanel 
   * Tạo database trùng tên với database dưới local.
   * Upload database từ local vô máy chủ phpadmin của Cpanel.
   * Tạo username và password sử dụng cho database.
   * Add username đã tạo vào database.
   * Tiến hành sửa file wp-config.php để thay đổi cấu hình cho Cpanel:
    
    
    wp-config.php
    
    
 > define( 'DB_NAME', 'blog' );

  > /** MySQL database username */
> define( 'DB_USER', 'new_user_on_cpanel' );

 > /** MySQL database password */
> define( 'DB_PASSWORD', 'new_pass_on_cpnel' );

    
  * Tiến hành sửa về các thông số Login trên Datbase.
    
    Mặc định thì trong source code của máy chủ Local thì nó sẽ được thiết lập là Local Host, vì vậy nếu khi đăng nhập website 
    thì sẽ bị redirect qua local.
    
    Để giải quyết vấn đề này thì chúng vào trang quản trị Database-> chọn database name -> chọn bảng wp-login sửa các đường dẫn về tên miền chúng ta thiết lập.
    
    Tham khảo cách dùng như sau.
    https://stackoverflow.com/questions/9764722/why-does-my-page-redirect-to-localhost-in-my-wordpress-blog
    
    
    
