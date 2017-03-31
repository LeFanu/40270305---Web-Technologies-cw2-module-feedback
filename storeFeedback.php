<?php


	if(!array_key_exists( 'u', $_REQUEST)){
		die("Who are you?");
	}
	$matriculationNumber = $_POST['u'];
    $connectionDB = new mysqli('localhost', '40270305','q4BjVJBP','40270305');
        if($connectionDB->connect_error){
            die('connection failure');
        }
    $SQLdelete = "DELETE FROM INS_RES WHERE SPR_CODE=? AND AYR_CODE='2016/7' AND PSL_CODE='TR1'";
        $statement = $connectionDB->prepare($SQLdelete)
            or die($connectionDB->error);
        $statement->bind_param('s',$matriculationNumber)
        or die('bind error');
    $statement->execute()
        or die("Failed to delete : ".$connectionDB->error);


    $SQLquery = "INSERT INTO INS_RES VALUES (?,?,'2016/7','TR1',?,?)";
    $statement = $connectionDB->prepare($SQLquery)
        or die($connectionDB->error);
    $statement->bind_param('sssi',$matriculationNumber, $moduleCode, $questionNumber, $result)
        or die('bind error');


foreach ($_REQUEST as $key=>$value)
{
    echo "This is the key:".$key."</br>";
    if ($key == 'u')
    {
        continue;
    }
 	$key = preg_replace('/d/','.',$key);
    print "<li>$value"."</br>";
    $string = preg_split('/_Q/', $key);
    echo "this is string0 = ".$string[0]."</br>";
    $moduleCode = $string[0];
    $questionNumber = $string[1];
    echo "this is string1 = ".$string[1]."</br>";
    $result = $value;


    $statement->execute();
//    or die();
    printf("Error: %s.\n", $statement->error);

    print  "<li><span>TEST - Done and inserted </span>".$matriculationNumber." ".$moduleCode." ".$questionNumber." ".$result;
}

print json_encode($matriculationNumber);
	exit();

?>
