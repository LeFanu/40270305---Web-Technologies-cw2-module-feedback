$(function(){
    $( "#accordion" ).accordion({
        collapsible: true
    });


    $('img.rating').click(function () {
        //this variable will be used for switch
        var iconNumber = $(this).attr("name");

        //getting the name for selecting parent div and then its image children
        var labelName = $(this).parent().attr("for").substr(0,12);
        labelName = labelName.replace(".","d") + " label img";

//FOR DEBUGGING
        console.log(labelName);
        console.log("emoticons/"+iconNumber+iconNumber+".png");

        //removing class for checked pics to revert them to original state
        var questionDiv = $('#'+labelName);
        questionDiv.removeClass("checked");


          $('#'+labelName+" > label > img").each().attr("src","emoticons/"+iconNumber+iconNumber+".png");


        // console.log("questionDiv is " + questionDiv);
        // var divsChildren = [];
        // questionDiv.children().each(function(){
        //   divsChildren.push(this);
        //   console.log("this is " + this);
        // })
        // console.log("divsChildren are " + divsChildren);
        // questionDiv.children('label').each(alert("chuj!"));
        // questionDiv.children('label').each(function(i){
        //   console.log("this is " + this);
        //     var imgToChange = $(this).children('img');
        //     console.log("imgToChange is " + imgToChange);
        //   console.log("emoticons/"+(i+1)+(i+1)+".png");
        //   imgToChange.attr("src","emoticons/"+(i+1)+(i+1)+".png");
        // });

        console.log("passed the loop");
        //
        // for(i=0; i < 5; i++){
        //       console.log(questionDiv[i]);
        //
        //       var divTochange = questionDiv[i];
        //       console.log(divTochange);
        // //  divTochange.attr("src","emoticons/"+i+i+".png");
        // }


        //changing the picture of the clicked element
        switch (iconNumber) {
          case "1":
            $(this).attr("src","emoticons/1.png");
            break;
          case "2":
            $(this).attr("src","emoticons/2.png");
            break;
          case "3":
            $(this).attr("src","emoticons/3.png");
              break;
          case "4":
          $(this).attr("src","emoticons/4.png");
            break;
          case "5":
          $(this).attr("src","emoticons/5.png");
            break;
        }
        //clicked element marked as checked
        $(this).addClass("checked");
    });


    $('img.rating').hover(function() {
      //getting the path for the correct icon
      var $iconSrc = "emoticons/"+$(this).attr("name")+".png";

        $(this).attr("src",$iconSrc);

      }, function(){
        //reverting back to the grey icon
        var $greyIconSrc = "emoticons/"+$(this).attr("name")+$(this).attr("name")+".png";

        if(!$(this).hasClass("checked"))
        {
              $(this).attr("src",$greyIconSrc);
        }
      }
    );

} );
