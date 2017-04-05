$(function(){

    // $("#go").click(function () {
    //     //ajax call is taking the data from the output file
    //     $.ajax({url: 'output.php',
    //         data: {MOD_CODE: $("#MOD_CODE").val()},
    //         dataType:'json',
    //         success: function(dataResult){
    //
    //             //creating the data for chart containing data from the database
    //             var dataForChart = {labels: [],
    //               datasets:[
    //                 {
    //                   label:$("#MOD_CODE").val()+' results',
    //                   data: [
    //
    //                   ],
    //                   backgroundColor: "rgba(255,153,51,0.5)",
    //                   borderColor: "#ff9933",
    //                   pointBackgroundColor: "rgba(51,0,0,0.8)",
    //                   pointBorderColor: "#b30000",
    //                 }
    //               ]};
    //             //looping through the ajax data and fill in data for chart
    //             for (var i=0; i<dataResult.length;i++)
    //             {
    //                 dataForChart.labels.push(dataResult[i][0]);
    //                 dataForChart.datasets[0].data.push(parseFloat(dataResult[i][1]));
    //             }
    //
    //             //creating chart with dataset
    //             var chartDisplay = $("#myChart");
    //             var myChart =  new Chart(chartDisplay, {
    //                 type: 'radar',
    //                 data: dataForChart,
    //                 options: {
    //                     responsive: false,
    //                     scale: {
    //                         ticks: {
    //                             beginAtZero: true
    //                         }
    //                     },
    //                 }});
    //
    //         }});
    // });


    $("#go").click(function () {
        //ajax call is taking the data from the output file
        var dataFromFirstCall;

        $.ajax({url: 'output.php',
            data: {MOD_CODE: $("#MOD_CODE_Compare").val()},
            dataType:'json',
            // async: true,
            success: function(dataResultCompare){
                dataFromFirstCall = dataResultCompare;
                console.log(dataResultCompare);
            }});


        console.log(dataFromFirstCall);
        // $.ajax({url: 'output.php',
        //     data: {MOD_CODE: $("#MOD_CODE").val()},
        //     dataType:'json',
        //     async: true,
        //     success: function(dataResult){
        //
        //         //creating the data for chart containing data from the database
        //         var dataForChart = {labels: [],
        //           datasets:[
        //             {
        //               label:$("#MOD_CODE").val()+' results',
        //               data: [
        //               ],
        //               backgroundColor: "rgba(255,153,51,0.5)",
        //               borderColor: "#ff9933",
        //               pointBackgroundColor: "rgba(51,0,0,0.8)",
        //               pointBorderColor: "#b30000",
        //             },
        //             {
        //               label: $("#MOD_CODE_Compare").val() + ' results',
        //               data: [
        //
        //               ],
        //               backgroundColor: "rgba(179,0,0,0.5)",
        //               borderColor: "#b30000",
        //               pointBackgroundColor: "rgba(51,0,0,0.8)",
        //               pointBorderColor: "#ffe699",
        //                       // pointHoverBackgroundColor: "#b30000",
        //                       // pointHoverBorderColor: "rrgba(51,0,0,0.8)",
        //
        //             }
        //           ]};
        //
        //         //looping through the ajax data and fill in data for chart
        //         for (var i=0; i<dataResult.length;i++)
        //         {
        //             dataForChart.labels.push(dataResult[i][0]);
        //             dataForChart.datasets[0].data.push(parseFloat(dataResult[i][1]));
        //             //dataForChart.datasets[1].data.push(parseFloat(dataFromFirstCall[i][1]));
        //         }
        //
        //         //creating chart with dataset
        //         var chartDisplay = $("#myChart");
        //         var myChart =  new Chart(chartDisplay, {
        //             type: 'radar',
        //             data: dataForChart,
        //             options: {
        //                 responsive: false,
        //                 scale: {
        //                     ticks: {
        //                         beginAtZero: true
        //                     }
        //                 },
        //             }});
        //
        //     }});




    });





    $('#goCompare').click(function(){
        $.ajax({url: 'output.php',
            data: {MOD_CODE: $("#MOD_CODE_Compare").val()},
            dataType:'json',
            success: function(dataResultCompare){
console.log(dataResultCompare.chuj);
                //creating the data for chart containing data from teh database
                var dataForChart = {
                    labels: [],
                    datasets: [{label: $("#MOD_CODE_Compare").val() + ' results',
                                data: [],
                                backgroundColor: "rgba(179,0,0,0.5)",
                                borderColor: "#b30000",
                                pointBackgroundColor: "rgba(51,0,0,0.8)",
                                pointBorderColor: "#ffe699",
                                // pointHoverBackgroundColor: "#b30000",
                                // pointHoverBorderColor: "rrgba(51,0,0,0.8)",
                                }]
                };

                //looping through the ajax data and fill in data for chart
                for (var i = 0; i < dataResultCompare.length; i++) {
                    dataForChart.labels.push(dataResultCompare[i][0]);
                    dataForChart.datasets[0].data.push(parseFloat(dataResultCompare[i][1]));
                }

                var chartDisplayCompare = $("#myChartCompare");


                var myChartCompare = new Chart(chartDisplayCompare, {
                    type: 'radar',
                    data: dataForChart,
                    options: {
                        responsive: false,
                        scale: {
                            ticks: {
                                beginAtZero: true
                            }
                        }
                    }
                });
        }});

    })
} );
