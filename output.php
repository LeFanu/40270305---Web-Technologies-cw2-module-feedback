


<?php


if(!array_key_exists('MOD_CODE', $_REQUEST)){
    print "<form><input name='MOD_CODE' value='CSN08101'></form> ";
    exit();
}

//connecting to the Database
$connectionDB = new mysqli('localhost', '40270305','q4BjVJBP','40270305');
if($connectionDB->connect_error){
    die('connection failure');
}

$queryResultsOfAllModules = "
    SELECT QUE_CODE, 100*AVG(CASE WHEN RES_VALU IN (4,5) THEN 1 ELSE 0 END)  AS results
        FROM INS_RES 
        WHERE MOD_CODE=?
        GROUP BY QUE_CODE ORDER BY QUE_CODE;
";

$statementDataOutput = $connectionDB->prepare($queryResultsOfAllModules)
    or die($connectionDB->error);
$statementDataOutput->bind_param('s',$_REQUEST['MOD_CODE'])
    or die('bind error');
$statementDataOutput->execute()
    or die("Failed to delete : ".$connectionDB->error);

$cursorDataOut = $statementDataOutput->get_result()
    or die('getting results failed: '.@$connectionDB->error);
//print_r($cursorDataOut->fetch_all());
print json_encode($cursorDataOut->fetch_all());

?>