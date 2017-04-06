<?php

//we only want to continue when the proper module code is passed
if(!array_key_exists('MOD_CODE', $_REQUEST)){
    print "<form><input name='MOD_CODE' value='CSN08101'></form> ";
    exit();
}

//connecting to the Database
$connectionDB = new mysqli('localhost', '40270305','q4BjVJBP','40270305');
    if($connectionDB->connect_error){
        die('connection failure');
    }

//SQL query to obtain  percent value of answers for each chart
$queryResultsOfAllModules = "
    SELECT  INS_RES.QUE_CODE, 
    100*AVG(CASE WHEN RES_VALU IN (4,5) THEN 1 ELSE 0 END)  AS results,
    COUNT(RES_VALU), INS_RES.MOD_CODE, INS_QUE.QUE_TEXT
        FROM INS_RES
        JOIN INS_QUE ON(INS_QUE.QUE_CODE=INS_RES.QUE_CODE)
        WHERE MOD_CODE=?
        GROUP BY INS_RES.MOD_CODE, QUE_CODE,INS_QUE.QUE_TEXT ORDER BY QUE_CODE;
";

    //preparing and executing query
    $statementDataOutput = $connectionDB->prepare($queryResultsOfAllModules)
        or die($connectionDB->error);
    $statementDataOutput->bind_param('s',$_REQUEST['MOD_CODE'])
        or die('bind error');
    $statementDataOutput->execute()
        or die("Failed to delete : ".$connectionDB->error);

    //getting the results to be stored as JSON as we can use AJAX call later to get this data back
        $cursorDataOut = $statementDataOutput->get_result()
            or die('getting results failed: '.@$connectionDB->error);

        print json_encode($cursorDataOut->fetch_all());

?>