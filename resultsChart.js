$(function(){

    $("#go").click(function () {
        //ajax call is taking the data from the output file
        $.ajax({url: 'output.php',
            data: {MOD_CODE: $("#MOD_CODE").val()},
            dataType:'json',
            success: function(dataResult){

                //creating the data for chart containing data from teh database
                var dataForChart = {labels: [],
                  datasets:[
                    {
                      label:$("#MOD_CODE").val()+' results',
                      data: [

                      ],
                      backgroundColor: "rgba(205,92,92,0.4)",
                      borderColor: "#8B0000",
                    }
                  ]};
                //looping through the ajax data and fill in data for chart
                for (var i=0; i<dataResult.length;i++)
                {
                    dataForChart.labels.push(dataResult[i][0]);
                    dataForChart.datasets[0].data.push(parseFloat(dataResult[i][1]));
                      //dataForChart.datasets[1].push(backgroundColor: "rgba(179,181,198,0.2)");
                    //dataForChart.datasets[0].borderColor.push("rgba(179,181,198,1)");

                }

                //creating chart with dataset
                var chartDisplay = $("#myChart");
                var myChart =  new Chart(chartDisplay, {
                    type: 'radar',
                    data: dataForChart,
                    options: {
                        responsive: false,
                        scale: {
                            ticks: {
                                beginAtZero: true
                            }
                        }
                    }});

            }});
    });



    $('#goCompare').click(function(){
        $.ajax({url: 'output.php',
            data: {MOD_CODE: $("#MOD_CODE_Compare").val()},
            dataType:'json',
            success: function(dataResultCompare){

                //creating the data for chart containing data from teh database
                var dataForChart = {
                    labels: [],
                    datasets: [{label: $("#MOD_CODE_Compare").val() + ' results', data: []}]
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
