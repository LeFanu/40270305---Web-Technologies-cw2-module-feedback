<html lang="en-US">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dominion University Module Feedback</title>

    <meta name="author" content="Karol Pasierb">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!--Additional fonts from Google page for better looking design-->
    <link href="https://fonts.googleapis.com/css?family=Alegreya|Archivo+Black|Crete+Round|Oxygen|Playfair+Display+SC|Righteous" rel="stylesheet">


    <!--links to the css, javascript, etc-->
    <link rel=stylesheet href=module-feedback.css>
     <script type="text/javascript" src=jquery.min.js></script>
     <link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css'>

     <script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
     <script type="text/javascript" src='feedback_jQuery.js'></script>

</head>
<body>
 <div id="wrapper">
<?php
//checking if the proper matriculation number was passed
	if(!array_key_exists( 'u', $_REQUEST)){
		print   "<p>We are very sorry, but we do not know a student with this matriculation number.
                <br>
                    Please go back to the beginning of the survey: 
                    <a href='index.php'>Click!</a>
                </p>";
	    die();
	}
    print "<h1>Dominion University <br> Module Feedback</h1>";

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

$statementOK = false;
foreach ($_REQUEST as $key=>$value) {
    //checking if the key matches the value passed
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
        print   "<p>We are very sorry, but we could not store your results at the moment.
                    We advise to contact the administrator of this page.
                <br>
                    Or you can go back to the beginning of the survey and try again: 
                    <a href='index.php'>Click!</a>
                </p>";
    }
    else {
        $statementOK = true;
    }
}
if ($statementOK == true){
    print "<h3>Thank you for completing the survey!
               <br>Your responses were recorded.
               </h3>";
    print "<p>You may go back to the beginning and provide different responses any time you like.
               <a href='index.php'>Click!</a>
               </p>";

    print "
               <div id=\"tutorSection\">
                    <h4>Survey Results Comparison</h4>
                        <p>You may access part of the Tutor's section to view the results of the surveys completed by all students.</p>
                        <p>Click <a href=\"output.html\">here</a> to enter this section.</p>

                </div>";
}

exit();

?>

    <!--//closing wrapper div-->
    </div>
</body>
</html>
