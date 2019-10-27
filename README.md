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
    
# Hướng dẫn download source code từ CPanel về Local để test Wordpress.

Sửa lại các thông số username và password:
- Username: root
- Password: (rỗng)
    
 >    /** MySQL database username */
 
>   define( 'DB_USER', 'root' );

>  /** MySQL database password */

>  define( 'DB_PASSWORD', '' );

Sửa lại máy chủ local trên database: 

> http://localhost/<ten_blog>

     >> Đăng nhập vào tài khoản Wordpress và thiết lập Permalink Settings -> Chọn Post name -> Save (ở bước này mình nghĩ là Bug của Wordpress vì nếu không thiết lập thì các trang Permalink sẽ không được thiết lập về local mà vẫn giữ nguyên URL của website.
     
### Lời kết:
 Ở bài này mình đã hướng dẫn các bạn thiết lập Wordpress để có thể làm việc ở 2 phía Local và CPanel. Trong dự án thực tế thì đa số các bạn đều tạo máy chủ local trên XAMPP và sau đó up lên phía server. Hy vọng bài viết này sẽ giúp các bạn thiết lập một website cho riêng mình sử dụng Wordpress.
