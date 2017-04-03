$(function(){
    $( "#accordion" ).accordion({
        collapsible: true
    });


    $('img.rating').click(function () {
        //this variable will be used for switch
        var icon = $(this).attr("name");

        //getting the name for selecting parent div and then its image children
        var labelName = $(this).parent().attr("for").substr(0,12);
        labelName = labelName.replace(".","d") + " label img";

        console.log(labelName);

        //removing class for checked pics to revert them to original state
        var questionDiv = $('#'+labelName);
        questionDiv.removeClass("checked");
        questionDiv.attr("src","emoticons/0.png");

        //changing the picture of the clicked emelent
        switch (icon) {
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
        //clicked element marked as clicked
        $(this).addClass("checked");
    });

    $('img.rating').hover(function() {
      var $iconSrc = "emoticons/"+$(this).attr("name")+".png";
      console.log("icon class is " + $iconSrc);
        $(this).attr("src",$iconSrc);

      }, function(){
        if($(this).hasClass("checked"))
        {

        }else {
            $(this).attr("src","emoticons/0.png");
        }

      }
    );

} );
