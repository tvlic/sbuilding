* Cài đặt database
- Tạo database trên host (hoặc server).
- Import database trong thư mục database lên host (hoặc server).
- Mở file "config.php" trong thư mục "include" bằng trình soạn thảo (Notepad++), sau đó sửa những thông tin sau:
	define('SERVER_HOST',			'ten_server_database'); //Tên server chứa database, thường là "localhost" hoặc "127.0.0.1"
	define('DATABASE_NAME',			'ten_database'); //Tên database đã tạo, ví dụ: bk_doan.
	define('DATABASE_USER',			'ten_dang_nhap'); //Tên đăng nhập quản trị database, thông tin này thường sẽ do nhà cung cấp dịch vụ host (hoặc server) cung cấp.
	define('DATABASE_PASS',			'mat_khau'); //Mật khẩu đăng nhập quản trị database, cũng tương tự tên đăng nhập được nhà cung cấp dịch vụ cấp.
	define('DATABASE_FX',			'tien_to_ten_database'); //Tiền tố trong tên database, ví dụ: database có tên "bk_doan" thì tiền tố sẽ là "bk_"
* Tài khoản đăng nhập Website (được tạo sẵn trên database để test demo)
	+ Nhà trường:
		Tài khoản có sẵn:
			Username: admin
			Password: P@$$1881994
	+ Giảng viên:
		Tài khoản có sẵn:
			Username: teacher1
			Password: 123456
* Contact me if you want know more detail via danghuong18@gmail.com
	
