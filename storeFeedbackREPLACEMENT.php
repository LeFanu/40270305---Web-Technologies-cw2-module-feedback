
<?php
//checking if the proper mattriculation number was passed
	if(!array_key_exists( 'u', $_REQUEST)){
		die("Who are you?");
	}
	$matriculationNumber = $_POST['u'];
	//connecting to the Database
    $connectionDB = new mysqli('localhost', '40270305','q4BjVJBP','40270305');
        if($connectionDB->connect_error){
            die('connection failure');
        }
     //query to delete existing record for this student
    $SQLdelete = "DELETE FROM INS_RES WHERE SPR_CODE=? AND AYR_CODE='2016/7' AND PSL_CODE='TR1';";
        $statement = $connectionDB->prepare($SQLdelete)
            or die($connectionDB->error);
        $statement->bind_param('s',$matriculationNumber)
            or die('bind error');
        $statement->execute()
            or die("Failed to delete : ".$connectionDB->error);
    //after successful deletion new results are stored
    $SQLquery = "INSERT INTO INS_RES VALUES (?,?,'2016/7','TR1',?,?)";
    $statement = $connectionDB->prepare($SQLquery)
        or die($connectionDB->error);
    $statement->bind_param('sssi',$matriculationNumber, $moduleCode, $questionNumber, $result)
        or die('bind error');
foreach ($_REQUEST as $key=>$value) {
    //echecking if the
    if ($key == 'u') {
        continue;
    }
    //replacing the output given by php to the correct format
    $key = preg_replace('/_/', '.', $key);
    //splitting string for module and question number
    $string = preg_split('/Q/', $key);
    $moduleCode = $string[0];
    $questionNumber = $string[1];
    $result = $value;
    $statement->execute()
    or die();
    if ($statement->error) {
        printf("Error: %s.\n", $statement->error);
    }
}
	exit();
?>

