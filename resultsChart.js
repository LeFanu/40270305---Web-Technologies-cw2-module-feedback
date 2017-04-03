$(function(){

    $("#go").click(function () {
        //ajax call is taking the data from the output file
        $.ajax({url: 'output.php',
            data: {MOD_CODE: $("#MOD_CODE").val()},
            dataType:'json',
            success: function(dataResult){



                //creating the data for chart containing data from teh database
                var dataForChart = {labels: [], datasets:[{label:$("#MOD_CODE").val()+' results', data: []}]};
                //looping through the ajax data and fill in data for chart
                for (var i=0; i<dataResult.length;i++)
                {
                    dataForChart.labels.push(dataResult[i][0]);
                    dataForChart.datasets[0].data.push(parseFloat(dataResult[i][1]));
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

} );
