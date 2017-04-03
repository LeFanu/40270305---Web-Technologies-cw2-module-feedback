<html lang="en-US">
<head>
    <title>Dominion University Module Feedback</title>

    <meta name="author" content="Karol Pasierb">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">


<?php
    //links to the css, javascript, etc
    print "<link rel=stylesheet href=module-feedback.css>";
    print "<script src=jquery.min.js></script>";
    print "<link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css'>";
    print "<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>";

    //using jQuery UI
    print "<script src='feedback_jQuery.js'></script>";

?>
</head>
<body>

<?php
//wrapper div for the whole page
print "<div id='wrapper'>";

    //top of the page
    print "<h1>Dominion University Module Feedback</h1>";
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
            echo mysqli_connect_error()."</br>";
        }

        //including file that contains all of our SQL related operations
        require "databaseOperations.php";

        //printing the details obtained
        print "<div id='studentDetails'>";
            print "Welcome student: <span id='studentName'>".$rowSelectStudent[0]." ".$rowSelectStudent[1]."</span>";
        print "</div>";


        //html form for questions
        print "<form METHOD='post' action='storeFeedback.php'>";
//print "<form METHOD='post' action='output.php'>";
        //accordion starts here
            print "<div id='accordion'>";

                $radioButtonsValues = array(1 => "DD",2 => "MD",3 => "N",4 => "MA",5 => "DA");
                //loop for getting details from the database for each module for the survey
                while ($rowSelectModule = $cursorSelectModule->fetch_row()) {

                    print "<h3>Please answer questions about $rowSelectModule[0]</h3>";
                        print "<div class='accordionSection'>";

                     //executing  questions query each time on the module
                    $statementQuestions->execute()
                        or die('execute error');
                    $cursorQuestions = $statementQuestions->get_result();

                    //variable for tracking array keys
                    $i=0;
                            //loop for getting all the questions from the database
                            while ($rowQuestions = $cursorQuestions->fetch_row()) {
                                $fetchedQuestion = "Q".$rowQuestions[0];

                                //value for the button to check
                                $buttonToCheck ="";

                                    //this loop goes through all the answers stored for this student looking for a match with teh current question
                                    foreach ($previousAnswers as $answer)
                                    {
                                        //checking if previous answer matches current question
                                        if ($answer['MOD_CODE']==$rowSelectModule[0]&& $answer['QUE_CODE']==$rowQuestions[0])
                                        {
                                           // assing the value of the previous question
                                            $buttonToCheck = $answer['RES_VALU'];

                                            //we remove the value from an array to speed up next search as this value is no longer needed
                                            unset($previousAnswers[$i]);
                                            //we need this to remove correct key
                                            $i++;
                                            break;
                                        }
                                    }



                                //printing question
                                //changing the name of the div's id to avoid errors later

                                $divname = preg_replace('/\./','d',$fetchedQuestion);
                                print "<div id='$rowSelectModule[0]$divname'>";
                                print "<p class='questionTitle'>Question ".$rowQuestions[0].":</p>";
                                print "<p>".$rowQuestions[1]."</p>";

                                //checking all the previous answers to find a match
                                    foreach ($radioButtonsValues as $key => $value) {
                                        if ($key == $buttonToCheck)
                                        {
                                            //if there is a much we want to add some bits to the radio buttons
                                            $check='checked="checked"';
                                            $imgSrc="src=\"emoticons\/$key.png\"";
                                            $checked="checked";
                                        }
                                        else
                                        {
                                            $check="";
                                            $imgSrc='src="emoticons/0.png"';
                                            $checked="";
                                        }

                                        //wrapping radio button an an image into the label so we can display that as a smiley face
                                        print "<label for=\"$rowSelectModule[0]$fetchedQuestion$value\">";
                                        print "<input type=\"radio\"
                                            name=\"$rowSelectModule[0]$fetchedQuestion\"
                                            value=\"$key\"
                                            $check
                                            class=\"rating\" id=\"$rowSelectModule[0]$fetchedQuestion$value\" />";
                                            print "<img $imgSrc class=\"rating icon$key $checked\" name=\"$key\" />";

                                        print "</label>";
                                    }
                                //closing each question's div
                                print '</div>';
                                }

                        print '</div>';
                }

            //closing accordion div
            print '</div>';
            print "<input type=hidden name=u value=$_REQUEST[u]>";
            print "<input type=submit>";
        print "</form>";


        //closing all of our statements for the DB and DB connection
        $statementSelectStudent->close();
        $statementSelectModule->close();
        $statementQuestions->close();
        $connectionDB->close();

//closing wrapper div
print '</div>';
?>
</body>
</html>
