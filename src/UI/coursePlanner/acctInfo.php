<?php
	require("session.php");

	$serverName = 'courseplanner.cs9msqhnvnqr.us-west-2.rds.amazonaws.com';
	$userName = 'courseplanner';
	$password = 'cpen3210';
	$databaseName = 'courseplanner';
    //Create a new database object and connect to it
    $conn = new mysqli($serverName, $userName, $password, $databaseName);

    if($conn->connect_error){
        die("Error: ". $conn->connect_error);
    }

    //Get current session
    $session = Session::getInstance();
    $uid = $session->userID;
	
	//Grab user info for pre-populating HTML inputs
	$sql = "SELECT `Name`,`email`,`remind` FROM `User Profile` WHERE `ID`=$uid";
	$result = $conn->query($sql);
	echo $conn->error;
	if( $result->num_rows > 0 ){
		while ( $row = $result->fetch_assoc() ) {
			$name = $row['Name'];
			$email = $row['email'];
			$remind = $row['remind'];
		}
	} else{
		$name = '';
		$email = '';
		$remind = 'n';
	}
	//Grab course info for pre-populating HTML inputs
	$sql = "SELECT `Title` FROM `Unique Calendar Entry` WHERE `ID`=$uid AND `courseID` IS NOT NULL";
	$result = $conn->query($sql);
	echo $conn->error;
	if( $result->num_rows > 0 ){
		$course = array();
		while ( $row = $result->fetch_assoc() ) {
			$course[] = $row['Title'];
		}
	}

    if( isset($_POST['name']) ){
        $name = htmlspecialchars($_POST['name']);
        if($name !== '' && $name !== ' '){
            $sql = "UPDATE `User Profile` SET `Name` = '$name' WHERE `ID`=$uid";
            if( $conn->query($sql) === TRUE ){
                   //echo "Record updated successfully";
            } else{
                   echo "Error: ". $conn->error;
            }
        }
    }
    
	if( isset($_POST['email']) ){
        $email = htmlspecialchars($_POST['email']);
        if($email !== '' && $email !== ' '){
            $sql = "UPDATE `User Profile` SET `email` = '$email' WHERE `ID`=$uid";
            if( $conn->query($sql) === TRUE ){
                   //echo "Record updated successfully";
            } else{
                   echo "Error: ". $conn->error;
            }
        }
    }
    
    if( isset($_POST['remind']) ){
		$remind = $_POST['remind'];
		$sql = "UPDATE `User Profile` SET `remind` = '$remind' WHERE `ID`=$uid";
		if( $conn->query($sql) === TRUE ){
			//echo "Record updated successfully";
        } else{
			echo "Error: ". $conn->error;
        }
	}
    
    //Array to hold errors from user inputs
	$courseErrArr = array();
    
if( isset($_POST['courseName']) ){
	//for passing course info to database and do the comparsion
	$nvals = count($_POST['courseName']);
	//for each course entered by the user
	for( $i = 0; $i < $nvals; $i++ ){
		$courseName = htmlspecialchars($_POST['courseName'][$i]);
		$courseNumber = htmlspecialchars($_POST['courseNumber'][$i]);
        $courseSection = htmlspecialchars($_POST['courseSection'][$i]);
    
        $sql = "SELECT `ID`, `dept`, `courseID`, `sectionID`, `course_type`,
					`course_title`, `course_info`, `course_credit`, `course_location`,
					`course_term`, `course_schedule_term_row1`, `course_schedule_day_row1`,
					`course_schedule_day_start_row1`, `course_schedule_day_end_row1`, 
					`course_schedule_building_row1`, `course_schedule_room_row1`, 
					`course_schedule_term_row2`, `course_schedule_day_row2`, 
					`course_schedule_day_start_row2`, `course_schedule_day_end_row2`, 
					`course_schedule_building_row2`, `course_schedule_room_row2`, 
					`course_instructors`, `course_book1`, `course_book2`, `course_book3` 
					FROM `course` WHERE dept='$courseName' AND courseID='$courseNumber' 
					AND sectionID='$courseSection'";
		$result = $conn->query($sql);
		if( $result->num_rows > 0 ){
			while ( $row = $result->fetch_assoc() ) {
				$cid = $row['ID'];
				$title = $row["dept"]." ".$row["courseID"]." ".$row["sectionID"];
				$info = 'Course: '.$title."<br>".$row["course_title"].'. '.$row["course_info"]."<br>".'Type: '.
						$row["course_type"]."<br>".'Credit: '.$row["course_credit"]."<br>".'Location: '.$row["course_location"].
						"<br>".'Course term: '.$row["course_term"]."<br>".'Instructors: '.$row["course_instructors"]."<br>".
						'Books info: '."<br>".$row["course_book1"]."<br>".$row["course_book2"]."<br>".$row["course_book3"]."<br>";
				$location1 = $row["course_schedule_building_row1"].' Room: '.$row["course_schedule_room_row1"];
				$location2 = $row["course_schedule_building_row2"].' Room: '.$row["course_schedule_room_row2"];			
				$course_schedule_term_row1= $row["course_schedule_term_row1"];
				$course_schedule_day_row1= $row["course_schedule_day_row1"];
				$course_schedule_day_start_row1= $row["course_schedule_day_start_row1"];
				$course_schedule_day_end_row1= $row["course_schedule_day_end_row1"];
				$course_schedule_term_row2= $row["course_schedule_term_row2"];
				$course_schedule_day_row2= $row["course_schedule_day_row2"];
				$course_schedule_day_start_row2= $row["course_schedule_day_start_row2"];
				$course_schedule_day_end_row2= $row["course_schedule_day_end_row2"];
				
				$term_date = explode('(' , rtrim($row['course_term'], ')'));
				$term_date_SE = explode('to', $term_date[1]);
				$start_date_array = array_filter(preg_split("/[\s,]+/", $term_date_SE[0]));
				$end_date_array = array_filter(preg_split("/[\s,]+/", $term_date_SE[1]));
				$start_date = $start_date_array[2].'/'.date('m', strtotime($start_date_array[0])).'/'.$start_date_array[1];
				$end_date = $end_date_array[3].'/'.date('m', strtotime($end_date_array[1])).'/'.$end_date_array[2];
			}

			if( $course_schedule_day_row1 != NULL ){
				$date1 = explode(" ", $course_schedule_day_row1);
		
				foreach($date1 as $item){ 							//ampersand?? &$item?
					//check exist
					$check = $conn->query("SELECT `ID` FROM `Unique Calendar Entry`
					 WHERE `userID`=$uid and `Title`='$title' and `date`='$item'
					 and `Location`='$location1' and `Start_Date`='$start_date' and
					 `End_Date`='$end_date'");
					if($check->num_rows == 0){//no exist
						$sql = "INSERT INTO `Unique Calendar Entry`(`Title`,
								`Location`, `Info`, `date`, `start`, `end`,
								`userID`,`Start_Date`, `End_Date`, `courseID`) VALUES 
								('$title','$location1','$info','$item',
								'$course_schedule_day_start_row1',
								'$course_schedule_day_end_row1',$uid,
								'$start_date','$end_date',$cid)";
					}
					else{//exist
						$sql="UPDATE `Unique Calendar Entry` SET `Title`='$title',
						`Location`='$location1',`Info`='$info',`date`='$item',
						`start`='$course_schedule_day_start_row1',
						`end`='$course_schedule_day_end_row1' WHERE `userID`=$uid
						 and `Title`='$title' and `date`='$item' and `Location`='$location1'
						 and `Start_Date`='$start_date' and `End_Date`='$end_date' and `courseID`=$cid";
					}
					if ($conn->query($sql) != TRUE) {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				}
			}
	
			if($course_schedule_day_row2!=NULL){
				$date2 = explode(" ", $course_schedule_day_row2);
		
				foreach($date2 as $item){
					//check exist
					$check = $conn->query("SELECT `ID` FROM `Unique Calendar Entry`
					 WHERE `userID`=$uid and `Title`='$title' and `date`='$item'
					 and `Location`='$location2' and `Start_Date`='$start_date' and
					 `End_Date`='$end_date'");
					if($check->num_rows == 0){//no exist
						$sql = "INSERT INTO `Unique Calendar Entry`(`Title`, `Location`,
						 `Info`, `date`, `start`, `end`,`userID`,`Start_Date`, `End_Date`, `courseID`)
						 VALUES ('$title','$location2','$info','$item',
						 '$course_schedule_day_start_row2','$course_schedule_day_end_row2',
						 $uid,'$start_date','$end_date',$cid)";
					}
					else{//exist
						$sql="UPDATE `Unique Calendar Entry` SET `Title`='$title',
						`Location`='$location2',`Info`='$info',`date`='$item',
						`start`='$course_schedule_day_start_row2',
						`end`='$course_schedule_day_end_row2' WHERE `userID`=$uid
						and `Title`='$title' and `date`='$item' and `Location`='$location2'
						and `Start_Date`='$start_date' and `End_Date`='$end_date' and `courseID`=$cid";
					}
					if ($conn->query($sql) != TRUE) {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				}
			}
		} else{
			//store course info to display error.
			$courseErrArr[] = array( "name" => $courseName,
									 "number" => $courseNumber,
									 "section" => $courseSection );
		}
	}
}
    //closing connection
    $conn->close();
    if( isset($_POST['submitted']) ){
		$errMessage = '<script>';
		$numErr = count($courseErrArr);
		if( $numErr > 0 ){
			//print out messages to user
			$errMessage .= 'alert("Some of the courses you have entered were not found in our database. Please check that the information you entered was for an existing UBC course and try again:\n\n';
			for( $i = 0; $i < $numErr; $i++){
				$errMessage .= $courseErrArr[$i]['name']." ".$courseErrArr[$i]['number']." ".$courseErrArr[$i]['section']."\\n";
			}
			$errMessage .= '"); ';
		} else if( $numErr == 0 ){
			$errMessage .= 'alert("Your profile and course information has been succesfully updated!"); ';
		}	
		if( $_POST['submitted'] == 'refresh' ){
			$errMessage .= "window.location.href='".$_SERVER['REQUEST_URI']."'; </script>";
		} else if( $_POST['submitted'] == 'redirect' ){
			if( $numErr > 0 ){
				$errMessage .= "window.location.href='courseRegister.php'; </script>";
			} else{
				$errMessage .= "window.location.href='mainPanel.php'; </script>";
			}
		}
		echo $errMessage;
	}
?>
