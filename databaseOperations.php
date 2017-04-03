<?php

$connectionDB = new mysqli('LOCALHOST', '40270305','q4BjVJBP','40270305');

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



//===========================================================================================
//select statement for existing results previously entered
$previousAnswersSelectQuery = "
    SELECT MOD_CODE, QUE_CODE, RES_VALU
    FROM INS_RES
    WHERE SPR_CODE=? AND AYR_CODE='2016/7' AND PSL_CODE='TR1';
";

//preparing and executing statement
$statementPreviousAnswersSelect = $connectionDB->prepare($previousAnswersSelectQuery)
    or die($connectionDB->error);
$statementPreviousAnswersSelect->bind_param('s',$_REQUEST['u'])
    or die('bind error');

$cursorPreviousAnswers;
$previousAnswers;
//we fetch all the results into array as we want to run through all of them all the time.
function fetchAllResults(){
    global $previousAnswers,$cursorPreviousAnswers, $statementPreviousAnswersSelect;

    $statementPreviousAnswersSelect->execute()
    or die('execute error');

    $cursorPreviousAnswers = $statementPreviousAnswersSelect->get_result();
    $previousAnswers = mysqli_fetch_all($cursorPreviousAnswers, 1);
}
fetchAllResults();

//===============================================================
//next statement to get the modules details
$SelectModulesQuery = "
 SELECT CAM_SMO.MOD_CODE, MOD_NAME
 FROM CAM_SMO
 JOIN INS_MOD ON (CAM_SMO.MOD_CODE=INS_MOD.MOD_CODE)
 WHERE SPR_CODE=? AND AYR_CODE='2016/7' AND PSL_CODE='TR1';
";

    //module details with staff details
    $SelectModulesQueryWithStaff = "
         SELECT CAM_SMO.MOD_CODE, MOD_NAME, PRS_FNM1, PRS_SURN
         FROM CAM_SMO
            JOIN INS_MOD ON (CAM_SMO.MOD_CODE=INS_MOD.MOD_CODE)
            LEFT JOIN INS_PRS ON (INS_MOD.PRS_CODE=INS_PRS.PRS_CODE)
         WHERE SPR_CODE='50200036' AND AYR_CODE='2016/7' AND PSL_CODE='TR1';
";

//preparing and executing statement for module details
$statementSelectModule = $connectionDB->prepare($SelectModulesQuery)
    or die($connectionDB->error);
$statementSelectModule->bind_param('s',$_REQUEST['u'])
    or die('bind error');
$statementSelectModule->execute()
    or die('execute error');
$cursorSelectModule = $statementSelectModule->get_result();



//========================================================================
//query for getting questions details
$selectQuestionsQuery = "
    SELECT QUE_CODE, QUE_TEXT, CAT_NAME
        FROM INS_QUE
        JOIN INS_CAT ON (INS_CAT.CAT_CODE=INS_QUE.CAT_CODE);
";

//preparing and executing statement for questions
$statementQuestions = $connectionDB->prepare($selectQuestionsQuery)
or die($connectionDB->error);
$statementQuestions->execute()
or die('execute error');
$cursorQuestions = $statementQuestions->get_result();



?>
