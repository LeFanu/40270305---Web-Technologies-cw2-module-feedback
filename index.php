<?php
print "<link rel=stylesheet href=module-feedback.css>";

print "<h1>Module Feedback</h1>";
	if(!array_key_exists( 'u', $_REQUEST)){
		print "Whoe are you?<form><input name='u' value='50200036'><input type=submit></form>";
		exit();
	}



$connectionDB = new mysqli('LOCALHOST', '40270305','q4BjVJBP','40270305');
if($connectionDB->connect_error){
	die('connection failure');
}
$SQLquery = "SELECT SPR_FNM1, SPR_SURN FROM INS_SPR WHERE SPR_CODE=?";
$statement = $connectionDB->prepare($SQLquery)
	or die($connectionDB->error);
	$statement->bind_param('s',$_REQUEST['u'])
		or die('bind error');
	$statement->execute()
		or die('execute error');

$cursor = $statement->get_result();
if (!($row = $cursor->fetch_array())) {
	echo 'Invalid mattriculation number';
	exit();
}

print "Welcome student: ".$row[0]." ".$row[1];

$statement->close();

//next statement to get the modules details
$SQLmodulesQuery = " SELECT CAM_SMO.MOD_CODE, MOD_NAME,INS_PRS.PRS_CODE, PRS_FNM1, PRS_SURN
 		FROM CAM_SMO
    	JOIN INS_MOD ON (CAM_SMO.MOD_CODE=INS_MOD.MOD_CODE)
    	LEFT JOIN INS_PRS ON (INS_MOD.PRS_CODE=INS_PRS.PRS_CODE)
 		WHERE SPR_CODE=? AND AYR_CODE='2016/7' AND PSL_CODE='TR1';
";
$statement = $connectionDB->prepare($SQLmodulesQuery)
	or die($connectionDB->error);
	$statement->bind_param('s',$_REQUEST['u'])
		or die('bind error');
	$statement->execute()
		or die('execute error');
$cursor = $statement->get_result();

    print "<form METHOD='post' action='storefeedback.php'>";
		while ($row = $cursor->fetch_row()) {
			print "<div class=module>";
			print "<h2>Please answer questions about $row[0]</h2>";
			print "<p>WHat do you think about it?</p>";
			print "<input type=\"radio\" name=\"$row[0]_Q1\" value=\"5\"/>Definitely Agree
                <input type=\"radio\" name=\"$row[0]_Q1\" value=\"4\"/>Mostly Agree
                <input type=\"radio\" name=\"$row[0]_Q1\" value=\"3\"/>Neither 
                <input type=\"radio\" name=\"$row[0]_Q1\" value=\"2\"/>Mostly Disgree
                <input type=\"radio\" name=\"$row[0]_Q1\" value=\"1\"/>Definitely Disgree            
                ";
			print '</div>';
		}
    print "<input type=hidden name=u value=$_REQUEST[u]>";
    print "<input type=submit>";
    print "</form>";
?>
