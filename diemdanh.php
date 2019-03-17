<?php

$diemdanh1 = $_GET['id'];

define('iBK',true);
require('include/config.php');
require('include/function.php');

$diemdanh = explode(":",$diemdanh1);

date_default_timezone_set("Asia/Ho_Chi_Minh");

switch(date("l"))
{
	case 'Monday':
		$day = 2;
		break;
	case 'Tuesday':
		$day = 3;
		break;
	case 'Wednesday':
		$day = 4;
		break;
	case 'Thursday':
		$day = 5;
		break;
	case 'Friday':
		$day = 6;
		break;
	case 'Satuday':
		$day = 7;
		break;
	case 'Sunday':
		$day = 8;
		break;
}

$day = 2;

$date = date("H:i");

function check_lesson($date)
{
	if($date >= '07:00' && $date < '07:50')
		$lesson = 1;
	elseif($date >= '08:00' && $date < '08:50')
		$lesson = 2;
	elseif($date >= '09:00' && $date < '09:50')
		$lesson = 3;
	elseif($date >= '10:00' && $date < '10:50')
		$lesson = 4;
	elseif($date >= '11:00' && $date < '11:50')
		$lesson = 5;
	elseif($date >= '12:30' && $date < '13:20')
		$lesson = 6;
	elseif($date >= '13:30' && $date < '14:20')
		$lesson = 7;
	elseif($date >= '14:30' && $date < '15:20')
		$lesson = 8;
	elseif($date >= '15:30' && $date < '16:20')
		$lesson = 9;
	elseif($date >= '16:30' && $date < '17:20')
		$lesson = 10;
	else
		$lesson = 1;
	return $lesson;
}

function check_late($lesson)
{
	switch($lesson)
	{
		case 1:
			$time = '07:15';
			break;
		case 2:
			$time = '08:15';
			break;
		case 3:
			$time = '09:15';
			break;
		case 4:
			$time = '10:15';
			break;
		case 5:
			$time = '11:15';
			break;
		case 6:
			$time = '12:45';
			break;
		case 7:
			$time = '13:45';
			break;
		case 8:
			$time = '14:45';
			break;
		case 9:
			$time = '15:45';
			break;
		case 10:
			$time = '16:45';
			break;
	}
	
	return $time;
}

$check	=	$db->database("id, name, room, lessons, teacher, day","timetable","room = '$diemdanh[1]' AND day = '$day'");

if(!$check)
{
	echo "Phong ".$diemdanh[1]." khong co lich vao ".date("l"); //Log
	if(isset($diemdanh[1]))
	{
		write_log("1:".time().":".$diemdanh[1].":".date("l"));
	}
}
else
{
	for($i = 0; $i < count($check); $i++)
	{
		$checklesson = explode(":",$check[$i][3]);
		
		if(check_lesson($date) >= $checklesson[0] && check_lesson($date) <= $checklesson[1])
		{
			$student		=	$db->database("id, name, mssv, class, log, timetable","student","timetable LIKE '%:".$check[$i][0].",%' AND mssv = '$diemdanh[0]'");
			if(!$student)
			{
				echo "Khong co sinh vien nao mang mssv ".$diemdanh[0]." hoc phong ".$diemdanh[1]." luc nay ca"; //Log
				write_log("2:".time().":".$diemdanh[0].":".$diemdanh[1]);
			}
			else
			{
				$log = explode(",", $student[0][4]);
				
				if($log[0] == date("Y-m-d") && (check_lesson($log[1]) >= $checklesson[0] && check_lesson($log[1]) <= $checklesson[1]))
				{
					echo "Sinh vien nay da duoc diem danh"; //Log
					write_log("3:".time().":".$diemdanh[0].":".$diemdanh[1]);
				}
				else
				{
					$timetable = explode(":",$student[0][5]);
					for($j = 1; $j < count($timetable) - 1; $j++)
					{
						$timetable1 = explode(",",$timetable[$j]);
						if($timetable1[0] == $check[$i][0])
						{
							if($date <= check_late($checklesson[0]))
							{
								$timetable1[1]++;
							}
							else
							{
								$timetable1[2]++;
							}
						}
						$timetable[$j] = implode(",", $timetable1);
					}
					
					$timetable = implode(":", $timetable);
					
					echo "Da diem danh sinh vien ".$student[0][1]." - MSSV: ".$diemdanh[0]. " hoc lop ".$check[$i][1]." phong ".$diemdanh[1]; //Log
					write_log("4:".time().":".$student[0][1].":".$diemdanh[0].":".$check[$i][1].":".$diemdanh[1]);
					$db->dbupdate("student","	timetable 	= 	'$timetable',
												log			= 	'".date("Y-m-d").",$date'","mssv = '$diemdanh[0]'");
				}
			}
			//echo "That right ".$checklesson[0]." - ".$checklesson[1];
		}
	}
} 

?>