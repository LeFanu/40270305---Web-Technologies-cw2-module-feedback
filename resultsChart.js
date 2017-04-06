$(function(){

var isTableCreated = true;
var resultsTable;
var tableRow = $('<tr/>');
var moduleOneDataApened = false;
var moduleTwoDataApened = false;
var moduleThreeDataApened = false;


var allModules = ["CSN08112", "CSN09101",   "CSN09111",
   "CSN09112",  "IMD08101",    "IMD08104", "IMD09104",
   "IMD09108",  "IMD09128",  "IMD09139",  "IMD10109",  "INF08101",
   "INF08104",  "INF09114",  "SET07102",  "SET08108",  "SET08115",  "SET09103"
];

var comboboX = $("#MOD_CODE");
var comboboX2 = $("#MOD_CODE_Compare");
var comboboX3 = $("#MOD_CODE_Compare2");

for (var i = 0; i < allModules.length; i++) {

  $($("<option/>").attr("value",allModules[i]).text(allModules[i])).appendTo(comboboX);
    $($("<option/>").attr("value",allModules[i]).text(allModules[i])).appendTo(comboboX2);
      $($("<option/>").attr("value",allModules[i]).text(allModules[i])).appendTo(comboboX3);
}

$("select").change(function(){
  $(resultsTable).remove();
    $("#resultsTablesDiv").remove();
  resultsTable = "";
  tableRow = $('<tr/>');

  //setting bool variables for future checks
  isTableCreated = true;
  moduleOneDataApened = false;
  moduleTwoDataApened = false;
  moduleThreeDataApened = false;
});



    $("#go").click(function () {
        //ajax call is taking the data from the output file
        $.ajax({url: 'output.php',
            data: {MOD_CODE: $("#MOD_CODE").val()},
            dataType:'json',
            success: function(dataResult){

                //creating the data for chart containing data from the database
                var dataForChart = {labels: [],
                  datasets:[
                    {
                      label:$("#MOD_CODE").val()+' results',
                      data: [

                      ],
                      backgroundColor: "rgba(255,153,51,0.5)",
                      borderColor: "#ff9933",
                      pointBackgroundColor: "rgba(51,0,0,0.8)",
                      pointBorderColor: "#b30000",
                    }
                  ]};
                  for (var i=0; i<dataResult.length;i++)
                  {
                      dataForChart.labels.push(dataResult[i][0]);
                      dataForChart.datasets[0].data.push(parseFloat(dataResult[i][1]));
                  }


                if (moduleOneDataApened == false) {
                  creatingTables(dataResult);

                  moduleOneDataApened = true;
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
                        },
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
                    datasets: [{label: $("#MOD_CODE_Compare").val() + ' results',
                                data: [],
                                backgroundColor: "rgba(179,0,0,0.5)",
                                borderColor: "#b30000",
                                pointBackgroundColor: "rgba(51,0,0,0.8)",
                                pointBorderColor: "#ffe699",
                                }]
                };

                //looping through the ajax data and fill in data for chart
                for (var i = 0; i < dataResultCompare.length; i++) {
                    dataForChart.labels.push(dataResultCompare[i][0]);
                    dataForChart.datasets[0].data.push(parseFloat(dataResultCompare[i][1]));
                }


                if (moduleTwoDataApened == false) {
                  creatingTables(dataResultCompare);
                  moduleTwoDataApened = true;
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

    });



    $('#goCompare2').click(function(){
        $.ajax({url: 'output.php',
            data: {MOD_CODE: $("#MOD_CODE_Compare2").val()},
            dataType:'json',
            success: function(dataResultCompare){

                //creating the data for chart containing data from teh database
                var dataForChart = {
                    labels: [],
                    datasets: [{label: $("#MOD_CODE_Compare2").val() + ' results',
                                data: [],
                                backgroundColor: "rgba(102,0,0,0.5)",
                                borderColor: "#ffbf00",
                                pointBackgroundColor: "rgba(255,230,153,0.8)",
                                pointBorderColor: "#1a0000",
                                }]
                };

                //looping through the ajax data and fill in data for chart
                for (var i = 0; i < dataResultCompare.length; i++) {
                    dataForChart.labels.push(dataResultCompare[i][0]);
                    dataForChart.datasets[0].data.push(parseFloat(dataResultCompare[i][1]));
                }


                if (moduleThreeDataApened == false) {
                  creatingTables(dataResultCompare);
                  moduleThreeDataApened = true;
                }
                var chartDisplayCompare = $("#myChartCompare2");


                var myChartCompare2 = new Chart(chartDisplayCompare, {
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

    });

function clearTableOrCreate(){
  //creating a div for the table
  $("<div/>").attr("id","resultsTablesDiv").appendTo('body');
  //creating a table and appending it to div
  resultsTable = $("<table>").attr("id","resultsTable");
      $("#resultsTablesDiv").append(resultsTable);

  //adding header rows
  resultsTable.append(tableRow);
}

function creatingTables(dataResult){

  //arrays for building a table
  var $questionCode =[];
  var $averageAnswers =[];
  var $numberOfAnswers =[];
  var $codeNumber = [];
  var $questionContent = [];
  var tableHeaders =
  ["Module", "Question Number", "Question", "% of Satisfaction", "Total Answers" ];


  //looping through the ajax data and fill in data for chart
  for (var i=0; i<dataResult.length;i++)
  {
      $questionCode.push(dataResult[i][0]);
      $averageAnswers.push(parseFloat(dataResult[i][1]));
      $numberOfAnswers.push(dataResult[i][2]);
      $codeNumber.push(dataResult[i][3]);
      $questionContent.push(dataResult[i][4]);
  }



    if ( isTableCreated == true)
    {
        clearTableOrCreate();

          for (var i = 0; i < tableHeaders.length; i++) {
            $('<th/>').text(tableHeaders[i]).appendTo(tableRow);
          }
          resultsTable.append(tableRow);
          isTableCreated = false;

      }



      for (var i = 0; i < dataResult.length; i++) {
          tableRow = $('<tr/>')
          .append($('<td/>',{text: $codeNumber[i]}))
          .append($('<td/>',{text: $questionCode[i], class: "tableEnhance"}))
          .append($('<td/>',{text: $questionContent[i]}))
          .append($('<td/>',{text: $averageAnswers[i].toFixed(2), class: "tableEnhance"}))
          .append($('<td/>',{text: $numberOfAnswers[i]}))
          .appendTo(resultsTable);
      }
}








} );
