$(function(){
    $( "#accordion" ).accordion({
        collapsible: true
    });


    $('img.rating').click(function () {
        //this variable will be used for switch
        var iconNumber = $(this).attr("name");

        //getting the name for selecting parent div and then its image children
        var labelName = $(this).parent().attr("for").substr(0,12);
        labelName = labelName.replace(".","d");

        //removing class for checked pics to revert them to original state
        var iconsToChange =   $('#'+labelName).find('img');
        for(i=0; i < 5; i++){
          $(iconsToChange[i]).removeClass("checked");
            $(iconsToChange[i]).attr("src","emoticons/"+(i+1)+(i+1)+".png");
        }

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
