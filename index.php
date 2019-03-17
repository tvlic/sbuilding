<?php
define('iBK',true);
require('include/config.php');
require('include/function.php');
$xr	=	$_GET['xr'];
$value	=	explode("/",$xr);
require_once('template/actions.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$title?> - Smart Campus - Hệ Thống Quản Lý Điểm Danh Sinh Viên</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=MAIN_URL?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=MAIN_URL?>/assets/css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=MAIN_URL?>/assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?=MAIN_URL?>/assets/css/morris.css" rel="stylesheet">
	
	<link href="<?=MAIN_URL?>/assets/css/tables/dataTables.responsive.css" rel="stylesheet">
	<link href="<?=MAIN_URL?>/assets/css/tables/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- Admin CSS -->
    <link href="<?=MAIN_URL?>/assets/css/styles.css" rel="stylesheet">
	
	<script type="text/javascript">var	ajaxurl	=	'<?=MAIN_URL?>';</script>
	
	<script type="text/javascript" src="<?=MAIN_URL?>/assets/js/jquery-1.9.1.min.js"></script>
    <!-- jQuery -->

</head>

<body>

<?php
if($_SESSION['adminid']) {
?>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=MAIN_URL?>">Smart Campus - Hệ Thống Quản Lý Điểm Danh Sinh Viên </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
					<li class="sidebar-search" style="display: none;" >
                            <!--<div class="input-group custom-search-form">
                                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm phim...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
								</span>
							
                            </div>-->
                     </li>
				
                    </ul>
                </div>
            </div>
            <!-- /.navbar-static-side -->
        </nav>

<?php
	// GET template
	if(in_array($value[0], array('index','home','trang-chu',''))) 		
		require_once("./template/home.php");
	elseif($value[0] == 'lessons')
		require_once("./template/lessons.php");
	elseif($value[0] == 'timetable')
		require_once("./template/timetable.php");
	elseif($value[0] == 'student')
		require_once("./template/student.php");
	elseif($value[0] == 'user' && $groupid == 1)
		require_once("./template/member.php");
	elseif($value[0] == 'graph')
		require_once("./template/graph.php");
	else
		header("Location: ../");
?>
    </div>
    <!-- /#wrapper -->

	<!-- Modal -->
	<div class="modal fade modal-subs modal-delete" id="pop-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
				</div>
				<div class="modal-body text-center" style="color: black;">
					<h4 style="margin: 0 0 20px">Bạn có muốn xóa <?=$element?> này?</h4>
					<div class="clearfix"></div>
					<p class="desc"><strong><?=$warning?></strong></p>
					<div class="block mt10">
						<a id="yes-delete" class="btn btn-success" href="javascript:void(0)">Có</a>
						<a id="no-delete" data-dismiss="modal" class="btn btn-default">Không</a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ modal -->

	<!-- Modal alert -->
	<div class="modal fade modal-subs modal-alert" id="pop-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
				</div>
				<div class="modal-body text-center" style="color: black;">
					<h4 style="margin: 0 0 20px">Thông báo</h4>
					<div class="clearfix"></div>
					<p class="desc"><strong></strong></p>
				</div>
			</div>
		</div>
	</div>
	<!--/ modal -->
	<?php }
	else {
	?>
	
    <div class="container">
	
        <div class="row">
		<div><image src="../assets/images/banner.png"></div>
			<h1 class="text-center" style="text-transform: uppercase;">Smart Campus - Hệ Thống Quản Lý Điểm Danh Sinh Viên</h1>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Vui lòng đăng nhập</h3>
                    </div>
                    <div class="panel-body">
                        <form id="login" role="form" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Tên đăng nhập" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value="">
                                </div>
								<div id="alert"></div>
                                <button class="btn btn-lg btn-success btn-block">Đăng nhập</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<?php } ?>
	
	<!-- Custom Theme JavaScript -->
	<?php if($groupid == 1 || $groupid == 2) {?>
	<script type="text/javascript" src="<?=MAIN_URL?>/assets/js/admin.js"></script>
	<!--<?=($ipid[0] == 'edit')? '<script src="assets/js/movies.js"></script>':''?>-->
	<script src="<?=MAIN_URL?>/assets/js/jsite.js"></script>
	<?php }
	else { ?>
	<script type="text/javascript" src="<?=MAIN_URL?>/assets/js/login.js"></script>
	<?php }?>
    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?=MAIN_URL?>/assets/js/bootstrap.min.js"></script>
	
	    <!-- DataTables JavaScript -->
    <script src="<?=MAIN_URL?>/assets/js/tables/jquery.dataTables.min.js"></script>
    <script src="<?=MAIN_URL?>/assets/js/tables/dataTables.bootstrap.min.js"></script>
    <script src="<?=MAIN_URL?>/assets/js/tables/dataTables.responsive.js"></script>
	    <script>
    $(document).ready(function() {
        $('#dataTables-bk').DataTable({
            responsive: true
        });
    });
    </script>
	<?php
	if($value[0] == 'graph')
	{?>
	    <!-- Morris Charts JavaScript -->
    <script src="<?=MAIN_URL?>/assets/js/chart/raphael.min.js"></script>
    <script src="<?=MAIN_URL?>/assets/js/chart/morris.min.js"></script>
    <script src="<?=MAIN_URL?>/assets/js/chart/morris-data.js"></script>
	<?php } ?>
	
</body>

</html>