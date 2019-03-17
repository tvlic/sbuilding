<?php
define('iBK',true);

require('include/config.php');
require('include/function.php');

if(isset($_POST['login'])) {
	$username 	= isset($_POST["username"]) ? htmlspecialchars($_POST["username"]) : '';
	$password 	= isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : '';
	$check 		= $db->database("id, username, password, usercode, groupid ","user"," username = '".$username."' AND groupid IN (1,2)");
	
	$pass_login = md5(md5($password).$check[0][3]);
	if(empty($username) || empty($password)) {
		$c = ['status' => 0, 'message' => '<div class="alert alert-warning">Bạn chưa nhập tên người dùng hoặc mật khẩu.</div>'];
	}
	elseif($check[0][2] == $pass_login) {
		$_SESSION['adminid']	=	$check[0][0];
		$_SESSION['groupid']	=	$check[0][4];
		
		
		$c = ['status' => 1, 'message' => '<div class="alert alert-success">Đăng nhập thành công.</div>'];
	} 

	else {
		$c = ['status' => 0, 'message' => '<div class="alert alert-warning">Bạn không phải là ban quản trị hoặc tên đăng nhập và mật khẩu bị sai!</div>'];
	}
	echo json_encode($c);
	exit();
}
elseif(isset($_POST['logout'])) {
	$_SESSION['adminid']	=	null;
	$_SESSION['groupid']	=	null;
	echo json_encode(['status' => 1]);
}

if($groupid == 1 || $groupid == 2) {
	if(isset($_POST['admin'])) {
		$top = '<li> 
					'.hello().'! 
					
					</li>
					 
					<li >
						<a title="Thoát" onclick="logout()" href="javascript:void(0)">
							<i class="fa fa-sign-out fa-fw"></i>
						</a>
					</li>
					<!-- /.dropdown -->';
		$sidebar = '
							<li>
								<a href="'.MAIN_URL.'"><i class="fa fa-dashboard fa-fw"></i> Bảng điều khiển</a>
							</li>
							<li>
								<a href="'.MAIN_URL.'/lessons.html"><i class="fa fa-list-alt fa-fw"></i> Lớp Học Phần - Điểm Danh</a>
							</li>
							<li>
								<a href="'.MAIN_URL.'/timetable.html"><i class="fa fa-calendar fa-fw"></i> Thời Khóa Biểu</a>
							</li>
							<li>
								<a href="'.MAIN_URL.'/student.html"><i class="fa fa-graduation-cap fa-fw"></i> Danh Sách Sinh Viên</a>
							</li>
							
							'.(($groupid==1)?'<li>
								<a href="#"><i class="fa fa-user fa-fw"></i> Thành viên<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="'.MAIN_URL.'/user/admin.html">Nhà Trường</a>
									</li>
									<li>
										<a href="'.MAIN_URL.'/user/mod.html">Giảng Viên</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>':'').'
					<div class="search-suggest" style="display: none"></div>
					<!-- /.sidebar-collapse -->
					<!-- Metis Menu Plugin JavaScript -->
					<script type="text/javascript" src="'.MAIN_URL.'/assets/js/metisMenu.min.js"></script>
					<script type="text/javascript" src="'.MAIN_URL.'/assets/js/sb-admin-2.js"></script>';
		$c = ['status' => 1, 'top' => $top, 'sidebar' => $sidebar];
		echo json_encode($c);
		exit();
	}

	elseif(isset($_GET['add'])) {
		$task	= intval($_GET['task']);
		$id		= intval($_GET['id']);

		if($task == 1) //user
		{
			 $html = '<tr id="new-user-'.$id.'">
						
							<td colspan="5"><form id="new-'.$id.'" method="post" enctype="multipart/form-data">
								<input style="display: none" name="new" value="1">
								<div class="form-group">
									<input placeholder="Tên Đăng Nhập" class="form-control" name="username">
									
									<input placeholder="Mật Khẩu" class="form-control" name="password" type="password" value="">
								
									<input placeholder="Họ Tên" class="form-control" name="fullname" value="">

									<input placeholder="Email" class="form-control" name="email" value="">
								
									<input placeholder="Khoa" class="form-control" name="department" value="">

									<select class="form-control" name="groupid">
										<option>Nhóm Thành Viên</option>
										<option value="1">Nhà Trường</option>
										<option value="2">Giảng Viên</option>
									</select>
 
								</div>
								
								<button id="submit-'.$id.'" style="display: none"></button>
								
							</form>
							</td>
							<script>
								$(document)["ready"](function() {
									$("#new-'.$id.'").submit(function(e) {
										e.preventDefault();
										var formdata = new FormData(this);
										$.ajax({
											url: ajaxurl + "/ajax.xr",
											type: "POST",
											data: formdata,
											dataType: "json",
											contentType: false,
											cache: false,
											processData: false,
											success: function(e) {
												if (e.status == 1) $("#new-user-'.$id.'").html(e.content) && $("#new-user-'.$id.'").attr("id","id-" + e.id) && $("#no-user").remove();
												else if(e.status == 0) $(".desc strong").html(e.content) && $("#pop-alert")["modal"]("show");
											}
										});
									});
								})
							</script>
						</td>

						<td><a class="btn btn-outline btn-primary btn-xs" onclick="save('.$id.')" href="javascript:void(0)">Thêm</a><a class="btn btn-outline btn-danger btn-xs btn-delete" onclick="cancel(1,'.$id.')" href="javascript:void(0)">Hủy</a>
						</td>
					</tr>';
		}
		elseif($task == 2) //timetable
		{
			 
		}
		elseif($task == 3) //student
		{
			 $html = '<tr id="new-student-'.$id.'">
					
						<td colspan="4"><form id="new-'.$id.'" method="post" enctype="multipart/form-data">
							<input style="display: none" name="new" value="3">
							<div class="form-group">
								<input placeholder="Mã Số Sinh Viên" class="form-control" name="mssv">
							
								<input placeholder="Họ Tên" class="form-control" name="name" value="">
							
								<input placeholder="Khoa" class="form-control" name="department" value="">
							
								<input placeholder="Lớp" class="form-control" name="class" value="">
							</div>
							
							<button id="submit-'.$id.'" style="display: none"></button>
							
						</form>
						</td>
						<script>
							$(document)["ready"](function() {
								$("#new-'.$id.'").submit(function(e) {
									e.preventDefault();
									var formdata = new FormData(this);
									$.ajax({
										url: ajaxurl + "/ajax.xr",
										type: "POST",
										data: formdata,
										dataType: "json",
										contentType: false,
										cache: false,
										processData: false,
										success: function(e) {
											if (e.status == 1) $("#new-student-'.$id.'").html(e.content) && $("#new-student-'.$id.'").attr("id","id-" + e.id) && $("#no-student").remove();
											else if(e.status == 0) $(".desc strong").html(e.content) && $("#pop-alert")["modal"]("show");
										}
									});
								});
							})
						</script>
					</td>

					<td><a class="btn btn-outline btn-primary btn-xs" onclick="save('.$id.')" >Thêm</a><a class="btn btn-outline btn-danger btn-xs btn-delete" onclick="cancel(3,'.$id.')" href="javascript:void(0)">Hủy</a>
					</td>
				</tr>';
		}

		$c = ['status' => 1, 'content' => $html];
		echo json_encode($c);


	}
	elseif(isset($_POST['new'])) {
		if($_POST['new'] == 1)
		{
			$id			= intval($_POST['new']);
			$username	= stripslashes(trim(urldecode($_POST['username'])));
			$password  	= stripslashes(trim(urldecode($_POST['password'])));
			$fullname	= stripslashes(trim(urldecode($_POST['fullname'])));
			$email		= stripslashes(trim(urldecode($_POST['email'])));
			$department	= intval($_POST['department']);
			$groupid	= intval($_POST['groupid']);
			$student	= 	$db->database("username","user","username='$username'");

			if($student)
			{
				$c 		= 0;
				$html 	= $username. " đã tồn tại.";
			}
			else
			{
				if(!empty($username) && !empty($password) && !empty($fullname) && !empty($email) && !empty($department) && !empty($groupid))
				{
					$usercode	=	rand(1000,9999);
					$password	=	md5(md5($password).$usercode);
					$db->dbinstall("user","username, password, usercode, fullname, email, department, groupid","'$username','$password','$usercode', '$fullname','$email', '$department','$groupid'");
					$id = mysqli_insert_id($connect_database);

					$c 		= 1;
					$html 	= '
													<td>'.$id.'</td>
													<td>'.$username.'</td>
													<td>'.$fullname.'</td>
													<td>'.$email.'</td>
													<td>'.check_department($department).'</td>
													<td>
														<a class="btn btn-outline btn-primary btn-xs" title="Sửa Thành Viên" onclick="edit(1,'.$id.')" href="javascript:void(0)" >Sửa</a>
														<a class="btn btn-outline btn-danger btn-xs btn-delete" title="Xóa Thành Viên" onclick="bk_delete(1,'.$id.')" href="javascript:void(0)">Xóa</a>
													</td>';
				}
				else
				{
					$c 		= 0;
					$html 	= 'Bạn chưa điền đầy đủ thông tin.';
				}
			}
		}
		elseif($_POST['new'] == 2)
		{

		}
		elseif($_POST['new'] == 3)
		{
			$id			= intval($_POST['id']);
			$mssv		= intval($_POST['mssv']);
			$name  		= stripslashes(trim(urldecode($_POST['name'])));
			$department	= intval($_POST['department']);
			$class		= stripslashes(trim(urldecode($_POST['class'])));
			$student	= $db->database("name","student","mssv='$mssv'");

			if($student)
			{
				$c 		= 0;
				$html 	= "Sinh viên ".$name." đã tồn tại.";
			}
			else
			{
				if(!empty($mssv) && !empty($name) && !empty($department) && !empty($class))
				{
					$db->dbinstall("student","mssv, name, department, class","'$mssv','$name','$department','$class'");
					$id = mysqli_insert_id($connect_database);

					$c 		= 1;

					$html 	= '<td>'.$mssv.'</td>
														<td>'.$name.'</td>
														<td>'.$department.'</td>
														<td>'.$class.'</td>
														<td>
															<a class="btn btn-outline btn-primary btn-xs" title="Sửa Sinh Viên" onclick="edit(3,'.$id.')" href="javascript:void(0)" >Sửa</a>
															<a class="btn btn-outline btn-danger btn-xs btn-delete" title="Xóa Sinh Viên" onclick="bk_delete(3,'.$id.')" href="javascript:void(0)">Xóa</a>
														</td>';

				}	
				else
				{
					$c 		= 0;
					$html 	= "Bạn chưa điền đầy đủ thông tin.";
				}
			}
		}

		$e = ['status' => $c, 'id' => $id, 'content' => $html];
		echo json_encode($e);
	}

	elseif(isset($_POST['edit'])) {
		if($_POST['edit'] == 1)
		{
			$id			= intval($_POST['id']);
			$username	= stripslashes(trim(urldecode($_POST['username'])));
			$password  	= stripslashes(trim(urldecode($_POST['password'])));
			$fullname	= stripslashes(trim(urldecode($_POST['fullname'])));
			$email		= stripslashes(trim(urldecode($_POST['email'])));
			$department	= intval($_POST['department']);
			$groupid	= intval($_POST['groupid']);
			$student	= 	$db->database("username","user","id != '$id' AND (username ='$username' OR email = '$email')");

			if($student)
			{
				$c 		= 0;
				$html 	= "Dữ liệu bị trùng với thành viên có trong cơ sỡ dữ liệu.";
			}
			else
			{
				if(!empty($username) && !empty($fullname) && !empty($email) && !empty($department) && !empty($groupid))
				{
					if(!empty($password))
					{
						$usercode	=	rand(1000,9999);
						$password	=	md5(md5($password).$usercode);
						$db->dbupdate("user","username  = 'username',
											 password 	= '$password',
											 usercode	= '$usercode',
											 fullname	= '$fullname',
											 email  	= '$email',
											 department = '$department',
											 groupid	= '$groupid'");
					}
					else
					{
						$db->dbupdate("user","username  = 'username',
											 fullname	= '$fullname',
											 email  	= '$email',
											 department = '$department',
											 groupid	= '$groupid'");
					}
					}

					$c 		= 1;
					$html 	= '
													<td>'.$id.'</td>
													<td>'.$username.'</td>
													<td>'.$fullname.'</td>
													<td>'.$email.'</td>
													<td>'.check_department($department).'</td>
													<td>
														<a class="btn btn-outline btn-primary btn-xs" title="Sửa Thành Viên" onclick="edit(1,'.$id.')" href="javascript:void(0)" >Sửa</a>
														<a class="btn btn-outline btn-danger btn-xs btn-delete" title="Xóa Thành Viên" onclick="bk_delete(1,'.$id.')" href="javascript:void(0)">Xóa</a>
													</td>';
				}
		}
		elseif($_POST['edit'] == 2)
		{
			
		}
		elseif($_POST['edit'] == 3)
		{
			
		}

	}


	elseif(isset($_GET['edit'])) {
		$task	= intval($_GET['task']);
		$id		= intval($_GET['id']);

		if($task == 1) {
			$check = $db->database("id, username, password, fullname, email, groupid, department","user","id='$id'");
			
			if($check)
			{
				$c = ['status' => 1, 'content' => '
					<td colspan="5"><form id="edit-'.$id.'" method="post" enctype="multipart/form-data">
								<input style="display: none" name="edit" value="1">
								<input style="display: none" name="id" value="'.$id.'">
								<div class="form-group">
									<input placeholder="Tên Đăng Nhập" class="form-control" name="username" value="'.$check[0][1].'">
									
									<input placeholder="Nhập Mật Khẩu Mới" class="form-control" name="password" type="password">
								
									<input placeholder="Họ Tên" class="form-control" name="fullname" value="'.$check[0][3].'">

									<input placeholder="Email" class="form-control" name="email" value="'.$check[0][4].'">
								
									<input placeholder="Khoa" class="form-control" name="department" value="'.$check[0][6].'">

									<select class="form-control" name="groupid" value="'.$check[0][5].'">
										<option>Nhóm Thành Viên</option>
										<option value="1" '.($check[0][5] == 1? 'selected':'').'>Nhà Trường</option>
										<option value="2" '.($check[0][5] == 2? 'selected':'').'>Giảng Viên</option>
									</select>
 
								</div>
								
								<button id="submit-'.$id.'" style="display: none"></button>
								
							</form>
							</td>
							<script>
								$(document)["ready"](function() {
									$("#edit-'.$id.'").submit(function(e) {
										e.preventDefault();
										var formdata = new FormData(this);
										$.ajax({
											url: ajaxurl + "/ajax.xr",
											type: "POST",
											data: formdata,
											dataType: "json",
											contentType: false,
											cache: false,
											processData: false,
											success: function(e) {
												if (e.status == 1) $("#id-'.$id.'").html(e.content);
												else if(e.status == 0) $(".desc strong").html(e.content) && $("#pop-alert")["modal"]("show");
											}
										});
									});
								})
							</script>
						</td>

						<td><a class="btn btn-outline btn-primary btn-xs" onclick="save('.$id.')" href="javascript:void(0)">Thêm</a><a class="btn btn-outline btn-danger btn-xs btn-delete" onclick="cancel(1,'.$id.')" href="javascript:void(0)">Hủy</a>
						</td>'];
			}
			else
			{
				$c = ['status' => 0];
			}
			

		}
		elseif ($task == 2) {
			# code...
		}
		elseif($task == 3) {
			$check = $db->database("id, mssv, name, department, class","student","id = '$id'");
			
			if($check)
			{
				$c = ['status' => 1, 'content' => '<td colspan="4"><form id="edit-'.$id.'" method="post" enctype="multipart/form-data">
							<input style="display: none" name="edit" value="3">
							<input style="display: none" name="id" value="'.$id.'">
							<div class="form-group">
								<input placeholder="Mã Số Sinh Viên" class="form-control" name="mssv" value="'.$check[0][1].'">
							
								<input placeholder="Họ Tên" class="form-control" name="name" value="'.$check[0][2].'">
							
								<input placeholder="Khoa" class="form-control" name="department" value="'.$check[0][3].'">
							
								<input placeholder="Lớp" class="form-control" name="class" value="'.$check[0][4].'">
							</div>
							
							<button id="submit-'.$id.'" style="display: none"></button>
							
						</form>
						</td>
						<script>
							$(document)["ready"](function() {
								$("#edit-'.$id.'").submit(function(e) {
									e.preventDefault();
									var formdata = new FormData(this);
									$.ajax({
										url: ajaxurl + "/ajax.xr",
										type: "POST",
										data: formdata,
										dataType: "json",
										contentType: false,
										cache: false,
										processData: false,
										success: function(e) {
											if (e.status == 1) $("#id-'.$id.'").html(e.content);
											else if(e.status == 0) $(".desc strong").html(e.content) && $("#pop-alert")["modal"]("show");
										}
									});
								});
							})
						</script>
					</td>

					<td><a class="btn btn-outline btn-primary btn-xs" onclick="save('.$id.')" href="javascript:void(0)">Lưu</a><a class="btn btn-outline btn-danger btn-xs btn-delete" onclick="cancel(1,'.$id.')" href="javascript:void(0)">Hủy</a>
					</td>'];
			}
			else
			{
				$c = ['status' => 0];
			}
			

		}
		
		echo json_encode($c);
		exit();
	}
	elseif(isset($_POST['delete'])) {
		$task	= intval($_POST['task']);
		$id		= intval($_POST['id']);
		if($task == 1) //user
		{
			$db->dbdelete("user","id = '$id'");
			$c		=	['status' => 1]; 
		}
		elseif($task == 2) //timetable
		{
			$db->dbdelete("timetable","id = '$id'");
			$c		=	['status' => 1]; 
		}
		elseif($task == 3) //student
		{
			$db->dbdelete("student","id = '$id'");
			$c		=	['status' => 1]; 
		}
		echo json_encode($c);
		exit();	
	}
	elseif(isset($_GET['loadLog'])) {
		$c = ['status' => 1, 'content' => read_log()];
		echo json_encode($c);
		exit();	
	}	
	//elseif(isset())
} 

?>