<?php
//links to the css, javascript, etc
print "<link rel=stylesheet href=module-feedback.css>";
print "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";
print "<link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css'>";
print "<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>";

//using jQuery UI accordion
    print "<script>
      $( function() {
        $( \"#accordion\" ).accordion({
            collapsible: true
            });
      } );
      </script>";


//wrapper div for the whole page
print "<div id='wrapper'>";

//top of the page
print "<h1>Module Feedback</h1>";
    //checking if user existis by getting mattriculation number
	if(!array_key_exists( 'u', $_REQUEST)){
		print "Who are you?<form><input name='u' value='50200036'><input type=submit></form>";
		//if user enters wrong mattriculation number we don't want to continue
		exit();
	}

//making connection to the database
	$connectionDB = new mysqli('LOCALHOST', '40270305','q4BjVJBP','40270305');
	//if can't connect print error
	if(mysqli_connect_error()){
		die('connection failure');
	}
	else{
		echo "this is the error: ".mysqli_connect_error()."</br>";
	}

//sql query for selecting given student from Database
	$StudentSelectQuery = "SELECT SPR_FNM1, SPR_SURN FROM INS_SPR WHERE SPR_CODE=?";
//preparing and executing statement
    $statementSelectStudent = $connectionDB->prepare($StudentSelectQuery)
		or die($connectionDB->error);
    $statementSelectStudent->bind_param('s',$_REQUEST['u'])
		or die('bind error');
    $statementSelectStudent->execute()
		or die('execute error');

	//cursor is holding the results of our query
	$cursorSelectStudent = $statementSelectStudent->get_result();
	if (!($rowSelectStudent = $cursorSelectStudent->fetch_array())) {
		echo 'Invalid mattriculation number';
		exit();
	}

	//printing the details obtained
	print "<div id='studentDetails'>";
	print "Welcome student: <span id='studentName'>".$rowSelectStudent[0]." ".$rowSelectStudent[1]."</span>";
	print "</div>";



//next statement to get the modules details
    $SelectModulesQuery = " SELECT CAM_SMO.MOD_CODE, MOD_NAME,INS_PRS.PRS_CODE, PRS_FNM1, PRS_SURN
 		FROM CAM_SMO
    	JOIN INS_MOD ON (CAM_SMO.MOD_CODE=INS_MOD.MOD_CODE)
    	LEFT JOIN INS_PRS ON (INS_MOD.PRS_CODE=INS_PRS.PRS_CODE)
 		WHERE SPR_CODE=? AND AYR_CODE='2016/7' AND PSL_CODE='TR1';
        ";
    //preparing and executing statement for module details
        $statementSelectModule = $connectionDB->prepare($SelectModulesQuery)
            or die($connectionDB->error);
        $statementSelectModule->bind_param('s',$_REQUEST['u'])
                or die('bind error');
        $statementSelectModule->execute()
                or die('execute error');
        $cursorSelectModule = $statementSelectModule->get_result();


    //html form for questions
    print "<form METHOD='post' action='storeFeedback.php'>";

    //accordion starts here
    print "<div id='accordion'>";

        //loop for getting details from the database
		while ($rowSelectModule = $cursorSelectModule->fetch_row()) {

			print "<h3>Please answer questions about $rowSelectModule[0]</h3>";
                print "<div class='accordionSection'>";
                    print "<p>What do you think about it?</p>";
                    print "<input type=\"radio\" name=\"$rowSelectModule[0]_Q1d1\" value=\"5\"/>Definitely Agree
                        <input type=\"radio\" name=\"$rowSelectModule[0]_Q1d1\" value=\"4\"/>Mostly Agree
                        <input type=\"radio\" name=\"$rowSelectModule[0]_Q1d1\" value=\"3\"/>Neither 
                        <input type=\"radio\" name=\"$rowSelectModule[0]_Q1d1\" value=\"2\"/>Mostly Disgree
                        <input type=\"radio\" name=\"$rowSelectModule[0]_Q1d1\" value=\"1\"/>Definitely Disgree            
                        ";


                        print "<p>Staff are good at explaining things</p>";
                        print "<input type=\"radio\" name=\"$rowSelectModule[0]_Q1d2\" value=\"5\"/>Definitely Agree
                            <input type=\"radio\" name=\"$rowSelectModule[0]_Q1d2\" value=\"4\"/>Mostly Agree
                            <input type=\"radio\" name=\"$rowSelectModule[0]_Q1d2\" value=\"3\"/>Neither 
                            <input type=\"radio\" name=\"$rowSelectModule[0]_Q1d2\" value=\"2\"/>Mostly Disgree
                            <input type=\"radio\" name=\"$rowSelectModule[0]_Q1d2\" value=\"1\"/>Definitely Disgree            
                            ";
                print '</div>';

		}
    //closing accordion section
    print '</div>';


    print "<input type=hidden name=u value=$_REQUEST[u]>";
    print "<input type=submit>";
    print "</form>";


    //closing all of our statements for the DB and DB connection
	$statementSelectStudent->close();
    $statementSelectModule->close();
    $connectionDB->close();

    //closing wrapper div
print '</div>';
?>
