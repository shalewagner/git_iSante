<script>
Ext.onReady (function(){
/**** Code related to pediatric growth tables/charts - uses WHO datasets
 *    found in data/growth and standard z-score calculator ****/

  // Set a bunch of vars to be used
  var line = null;
  var formWeight, formAge, formLength, formBirthday, isPed;
  var json, jsonPercents, findZScore, arraySelect;
  var chartTitle, xTitle, yTitle, xPoint, yPoint;

  // Constants used for date/time unit conversion. Taken from EW's old
  // graphSetup code.
  growthConstants = {};
  //Days in a tropical (solar) year as of Jan 1, 2000. Source http://en.wikipedia.org/wiki/Tropical_year#Mean_tropical_year_current_value
  //This one isn't much use here. It is approxamtily what you get when you enter 'days in a year' in to Google though. 
  growthConstants.daysInTropicalYear = 365.2421897;
  //Days in a year based on the Gregorian calendar. This is probably the most accurate and useful value to use in the long term. 
  growthConstants.daysInGregorianYear = 365.2425;
  //Days in a year based on the Julian calendar. The only reason this is here is because this is the value specified by the WHO guidelines. 
  growthConstants.daysInJulianYear = 365.25;
  //Nobody disagrees on this. La la la la http://en.wikipedia.org/wiki/Leap_second I can't hear you.
  growthConstants.secondsInADay = 86400;
  growthConstants.millisecondsInAGregorianYear 
      = 1000 * growthConstants.secondsInADay * growthConstants.daysInGregorianYear;
  growthConstants.millisecondsInAGregorianMonth
      = growthConstants.millisecondsInAGregorianYear / 12;
  growthConstants.millisecondsInAJulianMonth
      = 1000 * growthConstants.secondsInADay * growthConstants.daysInJulianYear / 12;

  /** Misc functions to be used **/
  // calculates z-score for l,m,s
  function valueToZScore(l, m, s, value) {
      if (l === 0) {
    return Math.log(value/m) / s;
      } else {
    return (Math.pow(value/m, l) - 1) / (l*s);
      }
  }
  // Calculates BMI
  function calcBMI(weight, height) {
    var resultBMI = weight / (Math.pow((height / 100), 2));
    return resultBMI;
  } 
  // Get age at a certain date
  function getAgeAtDate(apptDate) {
    var birthday = new Date('<?= $patientDOB2 ?>');
    var checkAppt = new Date(apptDate);
    var checkDiff = new Date(checkAppt - birthday);
    return Math.round(checkDiff/1000/60/60/24);
  }
  // Get age in months
  function getMonths(birthDate, date) {
    var age = (date - birthDate) * (1 / growthConstants.millisecondsInAGregorianMonth);
    return age;
  }
  // Get age in years
  function getYears(birthDate, date) {
    var age = (date - birthDate) * (1 / growthConstants.millisecondsInAGregorianYear);
    return age;
  }
  /** End - Misc functions to be used **/
  
  <?php
  $genderData = "";
  $genderData = ($mf == 'H' || $mf == 'M') ? 'M' : 'F';
  ?>
  // Get data on ready. Make sure these load completely before we trigger calculations
  function getJsonData(){
    $.getJSON('data/growth/whoIndicators_<?= $genderData ?>_extended.json', function(data) {
    //$.getJSON('data/growth/whoIndicators_<?= $genderData ?>.json', function(data) {
      json = data;
    }).done(function() {
      $.getJSON('data/z-scores.json', function(data) {
        jsonPercents = data;       
      }).done(function() {
        // Once both json files are loaded we run the calculations
        runPedMeasures();
      });
    });
  }
  getJsonData();
  
  // Grab a bunch of values from PHP for current appt. Might be to able to just
  // use most recent value in array instead and/or just rely on vital signs
  // table above.
  // calcArray - list of measures and their components
  var calcArray = <?= json_encode($measureArray) ?>;
  // Values for most recent appt -- used for runPedMeasures on page
  formWeight = <?= $anthroWeight ?>;
  formLength = <?= $anthroHeight ?>;
  formBirthday = new Date('<?= $patientDOB2 ?>');
  formAge = getAgeAtDate('<?= $anthroDate ?>');
  isPed = <?= $isPed ?>;
  
/** Alert on load -- currently uses top notification bar **/
  function showAlerts() {
    var modalCheck = false;
    var alertText = "<?= $pedGrowthLabels[$lang][15] ?>";
    $("table.nutrition-table tbody tr").each(function(){
      if($(this).hasClass('error')) {
        modalCheck = true;
        measureName = $(this).find("td:first").text();
        alertText += measureName+", ";
      }
    });
    if (modalCheck == true) {
      alertText = alertText.slice(0,-2);
      $('#notification-text').html(alertText);
      $('#notification-bar').addClass('notification-failure');
      $('#notification-pull').addClass('notification-failure');
      setTimeout(showNotificationOverlay,100);
      hideTimer = setTimeout( noShowNotificationOverlay,10000);
    }
  }
  
  /*** Show alert - modal style - not in use. If used, need to create bootstrap
   *   modal first.
  function showAlerts() {
    var modalCheck = false;
    var alertText = "<br />";
    $("table.nutrition-table tbody tr").each(function(){
      if($(this).hasClass('error')) {
        modalCheck = true;
        measureName = $(this).find("td:first").text();
        alertText += "- "+measureName+"<br />";
        //$("#modalAlertBody").append("- " + measureName);
      }
    });
    if (modalCheck == true) {
      $("#modalAlertBody").append(alertText);
      $("#modalAlert").modal();
    }
  } // function showAlerts() modal style
  ***/
  
  /** Main number cruching to get z-scores and percentages **/
  
  // 1st - Main function to display z-score and % for measures on load
  function runPedMeasures(){
    var findZScore, findPercent = null;
      // Generic calculator, uses calcArray
      // Change to only run row when it has needed values?
      for (var i = 0; i < calcArray.length; i++) {
          var xValue, zScoreAbs = null;
          var zScoreWarning = 'success';
          if (calcArray[i][1]  == 'age') {
            xValue = formAge;
          } else {
            xValue = formLength;
          }
          // Calls helper function that gets L,M,S values needed for z-score
          getCalculation('<?= $genderData ?>', xValue, calcArray[i][0]);
          // Now that we have l,m,s we get z-score based on y-axis measure
          if (calcArray[i][2] == 'bmi') {
            findZScore = valueToZScore(line[1], line[2], line[3], <?= $anthroBMI ?>);
          } else if (calcArray[i][2] == 'length') {
            findZScore = valueToZScore(line[1], line[2], line[3], formLength);
          } else {
            findZScore = valueToZScore(line[1], line[2], line[3], formWeight);
          }
          // Set CSS class for table rows based on z-score range (in absolute value)
          // 0-1 = A good score, adds green - class="success"
          // 1-2 = Hmm, adds yellow - class="warning"
          // 2-3.5 = Uhoh, this is a bad score, adds red - class="error"
          // Above 3.5 = Yields N/A for percent - class="error"
          zScoreAbs = Math.abs(findZScore);
          // TODO - zScoreSign can be useful if we need to pass detail for alert
          // such as this patient is severely overweight vs underweight
          var zScoreSign = findZScore > 0 ? 1 : -1;
          if (zScoreAbs > 2) {
            zScoreWarning = 'error';
          } else if ( zScoreAbs > 1 ) {
            zScoreWarning = 'warning';
          }
          $("#anthroCalc" + i).text(findZScore.toFixed(2)).parent('tr').removeClass().addClass(zScoreWarning);
          findPercent = findPercentage(findZScore);
          $("#anthroCalcP" + i).text(findPercent);
      }
      showAlerts();
  } // End - Main function to display z-score 

  // 2nd - We get percent based on z-score 
  function findPercentage(passedZ) {
    // If it's outside z-score range, return N/A
    if (passedZ > 3.5 || passedZ < -3.5) {
      return "N/A";
    }
    var closest = null;
    var percentOutput = null;
    var calcZ = Math.abs(passedZ);
    $.each(jsonPercents, function(){
        for (var i = 0; i < jsonPercents.length; i++) {
            if (closest === null || Math.abs(jsonPercents[i][0] - calcZ) < Math.abs(closest - calcZ)) {
                closest = jsonPercents[i][0];
                percentOutput = jsonPercents[i][1];
            }
        }
    });
    if (passedZ > 0) {
      // Find percentage if above .5, convert to percentage w/ one decimal
      return ((percentOutput * 100).toFixed(1) + "%");    
    } else {
      // Since our z-score table only goes from .5 up, we do some math to find the percent if it's below 50%
      var calcNeg = (0.5 - (percentOutput - 0.5));
      return ((calcNeg * 100).toFixed(1) + "%"); 
    }
  }
 
  // Helper function - Looks at whoIndicators data sets by passing gender, the
  // value on the x-axis and the metric. We match the value in whoIndicators
  // and then get the 3 values that we use to calculate z-scores
  // The xVar matches exactly - either by age in days or length rounded to
  // one decimal.
  function getCalculation(gender, xVar, calcMetric) {
    line = null;
    var closest = null;
    //small private helper
    var findRow = 
      function(arr, xVar) {
        for(var i = 0; i < arr.length; i ++) {
//          if (arr[i][0] == xVar) {
//            line = arr[i];
//            break;
//          }
          // Switch so it doesn't match exactly? FIXME - slow?
          if (closest === null || Math.abs(arr[i][0] - xVar) < Math.abs(closest - xVar)) {
            closest = arr[i][0];
            line = arr[i];
          }
          if (arr[i][0] == xVar) {
            line = arr[i];
            break;
          }
        }
        return line;
      }
    line = findRow(json[calcMetric], xVar);
    return line != null ? line : 'N.A.';
  } 
  
  /*** Functions specific to charting. Could probably be combined with above
   *   to reduce number of functions. ***/
  // runCalcChart - gets percent by first calculating z-scores
  function runCalcChart(measure, xAxis, yAxis, ptDate, ptWeight, ptLength, ptBMI){
    var findZScore, findPercent = null;
    var xValue = null;
    if (xAxis  == 'age') {
      xValue = getAgeAtDate(ptDate);
    } else {
      xValue = ptLength;
    }
    getCalculation('<?= $genderData ?>', xValue, measure);
    if (yAxis == 'bmi') {
      findZScore = valueToZScore(line[1], line[2], line[3], ptBMI);
    } else if (yAxis == 'length') {
      findZScore = valueToZScore(line[1], line[2], line[3], ptLength);
    } else {
      findZScore = valueToZScore(line[1], line[2], line[3], ptWeight);
    }
    findPercent = findPercentage(findZScore);
    return findPercent;
  }
  // Creates appDataChart array and fills it with details from all the appointments
  // for that measure
  // TODO - Since this is similar to the main function, consider consolidating
  // and using this as the main function. Could fill in table with the most
  // recent data point
  function getDetailsForChart(arraySelect, xPoint, yPoint){
    // daydiff and boundary are used to customize x-axis. We can remove this if
    // we just want to display entire range of growth chart.
    function daydiff(first, second) {
      return (second-first)/(1000*60*60*24)
    }
    var i;
    var boundary, passBoundary = 0;
    // Set x-axis limit for age
    if (xPoint == 'age') {
      var dateLast = new Date(apptData[0][2]);
      // Find days between birthday and appt, then divide by 5 (json data has pts
      // for every 5 days). Then add a bit of padding.
      var dateCount = daydiff(formBirthday, dateLast);
      if (dateCount < 1856) {
        boundary = dateCount / 5;
      } else {
        // 371 is 1855/5 -- that's the number of points up to the point where
        // we switch for every 5 days to 30 days
        boundary = Math.ceil(((dateCount - 1855) / 30.416) + 371);
      }
      // Set minimize x-axis to about one year -- 365/5 = 73
      // FIXME - this changes with add'l data for above 5
      if (boundary < 75 ) {
        passBoundary = 75;
      } else {
        passBoundary = Math.ceil(boundary * 1.05);
      }
    } else {
      // Set x-axis limit for height
      boundary = (apptData[0][0] - 45) * 2;
      if (boundary < 65) {
        // Minimum x-axis length is 70
        passBoundary = 70;
      } else {
        // Else boundary count plus a little padding
        passBoundary = boundary + 5;
      }
    }
    for (i = 0; i < apptData.length; ++i) {
      apptDataChart.push([]);
      // Calculate for passing on later
      var apptBMI = calcBMI(apptData[i][1],apptData[i][0]).toFixed(1);
      var dateToPass = new Date(apptData[i][2]);
      // Pass x-value
      if (xPoint == 'age') {
        if (isPed == 1) {
          apptDataChart[i].push(getMonths(formBirthday, dateToPass).toFixed(1));
        } else {
          apptDataChart[i].push(getYears(formBirthday, dateToPass).toFixed(1));
        }
      } else {
        apptDataChart[i].push(apptData[i][0]);
      }
      // Pass y-value
      if (yPoint == 'length') {
        apptDataChart[i].push(apptData[i][0]);
      } else if (yPoint == 'bmi') {
        apptDataChart[i].push(apptBMI);
      } else {
        apptDataChart[i].push(apptData[i][1]);
      }
      // Pass appt date in the dd/mm/yyyy format
      var d = new Date(apptData[i][2]);
      var getDate = d.getDate() + 1; //Days are zero based
      var getMonth = d.getMonth() + 1; //Months are zero based
      var getYear = d.getFullYear();
      apptDataChart[i].push(getDate+"/"+getMonth+"/"+getYear);
      // Pass percentage from runCalcChart function
      apptDataChart[i].push(runCalcChart(arraySelect, xPoint, yPoint, apptData[i][2], apptData[i][1], apptData[i][0], apptBMI));        
    }     
    getChartLines(arraySelect, '<?= $genderData ?>', passBoundary);
  }
  
  // Get the standard deviation lines for this metric and gender for use on 
  // graph
  // TODO - consider loading this after page is complete so we don't have to
  // wait when chart is triggered
  var jsonChartData = [];
  function getChartLines(metric, gender, boundary) {
    // Clear first array
    jsonChartData.length = 0;
    var pointCount;
    $.getJSON('data/growth/dataChartStddevs_<?= $genderData ?>_extended.json', function(data) {
      //for(var i = 0; i < data[metric].length; i ++) {
      if (boundary > data[metric].length) {
        pointCount = data[metric].length;
      } else {
        pointCount = boundary;
      }
      for(var i = 0; i < pointCount; i ++) {
        jsonChartData.push([data[metric][i][0], data[metric][i][1], data[metric][i][2], data[metric][i][3], data[metric][i][4], data[metric][i][5], data[metric][i][6], data[metric][i][7]]); 
      }
      // Executes the drawChart function
      drawChart(metric, jsonChartData);
    });
  }
  /*** End - Functions specific to charting. ***/
	
  /*** Options for Highcharts ***/
  var chart;
  var series = [];
  var chartOptions = {
    chart: {
      renderTo: 'pedGrowthContainer',
   	  plotBorderWidth: 1,
   	  width: 800,
      height: 400
    },
    title: {
      text: null
    },
    credits: {
      enabled: false
    },
    legend: {
    	align: 'right',
    	layout: 'vertical',
    	verticalAlign: 'top'
    },
    yAxis: {
      labels: {
        formatter: function() {
          return this.value
        }
      },
      endOnTick: false,
      gridLineColor: "#eeeeee",
      gridLineWidth: 1
    },
    tooltip: {
      crosshairs: [{
	        width: 1,
	        color: 'red',
	        dashStyle: 'shortdot'
	    }, {
	        width: 1,
	        color: 'red',
	        dashStyle: 'shortdot'
	    }]
    },
    xAxis: {
      title: {
        enabled: true,
        // Need this here and then swap out later
        text: 'x-axis'
      },
      gridLineColor: "#eeeeee",
      gridLineWidth: 1
    },
    plotOptions: {
        scatter: {
            marker: {
                radius: 6,
                symbol: 'diamond'
            },
            showInLegend: false,
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.y}<br>{point.x}'
            }
        },
        spline: {
            color: '#663399',
            marker: {
                enabled: false
            },
            shadow: false,
            enableMouseTracking: false
        }
    },
    series: []
  };
  /*** End - Highcharts options ***/

  /*** Functions to actually draw charts ***/

  // Set variables and fill apptData with the measures from all appts
  var apptDataChart = [];
  var apptData = new Array(<?php
  $apptData;
  for ($i=0; $i<$anthroCount; $i++) {
    $apptData .= "[".$anthroArray[$i]["anthroHeight"].",".$anthroArray[$i]["anthroWeight"].",'".$anthroArray[$i]["anthroDate"]."'],";
  }
  echo substr($apptData, 0, -1);
  ?>);
                  
  // Main chart function - gets all needed data and then opens modal with chart
  function drawChart(passTitle, passLine) {
    var formData = [<?php
    $formData;
    for ($i=0; $i<$anthroCount; $i++) {
      $formData .= "{".$pointStyle."x: Math.abs(apptDataChart[".$i."][0]), y: Math.abs(apptDataChart[".$i."][1]), apptDate: apptDataChart[".$i."][2], apptPercent: apptDataChart[".$i."][3]},";
    }
    echo substr($formData, 0, -1);
    ?>];  	
  	for(var i = 0; i < 7; i ++) {
  		var lineCalc = [];
      // Defaults for line colors - for 3SD
  		var lineColor = "#333333";
  		var lineName = "3SD";
  		for(var k = 1; k < passLine.length; k ++) {
        if (xPoint == 'age') {
          var tomorrow = new Date(formBirthday);
          tomorrow.setDate(tomorrow.getDate() + passLine[k][0]);
          if (isPed == 1) {
            var ageForChart = getMonths(formBirthday, tomorrow);
          } else {
            var ageForChart = getYears(formBirthday, tomorrow);
          }
          lineCalc.push([ageForChart, passLine[k][i+1]]);
        } else {
          lineCalc.push([passLine[k][0], passLine[k][i+1]])
        }
  		}
      // Override default to rename and color based on deviation
  		if (i == 1 || i == 5) {
  			lineColor = "#b94a48";
  			lineName = "2SD";
  		} else if ( i == 2 || i == 4 ) {
  			lineColor = "#c09853";
  			lineName = "1SD";
  		} else if ( i == 3 ) {
  			lineColor = "#468847";
  			lineName = "Median";
  		}
  		if (i > 3) {
  			lineName = "-"+lineName;
  		} else if (i < 3) {
  			lineName = "+"+lineName;
  		}
  		chartOptions.series[i] = {data: lineCalc, type: 'spline', color: lineColor, name: lineName};	
  	}
    if (xPoint == 'age') {
      if (isPed == 1) { 
        // If isPed is 1, xAxis is months, with interval to 6 months, w/ 3 month minor
        chartOptions.xAxis.tickInterval = 6;
        chartOptions.xAxis.minorTickInterval = 3;
      } else if (isPed == 2) {
        // If isPed is 1, xAxis is months, with interval to 6 months, w/ 3 month minor
        chartOptions.xAxis.tickInterval = 1;
        chartOptions.xAxis.minorTickInterval = 0.5;
      } else {
        chartOptions.xAxis.tickInterval = 1;
        //chartOptions.xAxis.minorTickInterval = 1;
      }
    }
    chartOptions.plotOptions.scatter.tooltip.pointFormat = 'Date: {point.apptDate}<br>'+yTitle+': {point.y}<br>'+xTitle+': {point.x}<br>Percentile: {point.apptPercent}';
  	chartOptions.series[7] = {data: formData, name: chartTitle, type: 'scatter'};
    chartOptions.chart.renderTo = 'pedGrowthContainer';

    // Set x and y-axis titles via callback (seemed to work better this way)
    function callback(chart) {
    	chart.yAxis[0].setTitle({
        text: yTitle
      });
    	chart.xAxis[0].setTitle({
        text: xTitle
      });
    }

    // Boom - executes chart drawing
 	  pedGrowthChart = new Highcharts.Chart(chartOptions, callback);
 	  // Passes title to chart modal
    $("#modalChartTitle").html(chartTitle);
    $("#modalChartTitlePrint").html(chartTitle);
    // Opens modal
    $("#modalChart").modal();
  }
  // End - Main chart function
    
  // Start the chart launch process here - grabs relevant data & executues
  // getDetailsForChart function
  $("body").on('click', '.chart-launch', (function() {
    arraySelect = $(this).attr("data-metric");
    chartTitle = $(this).attr("data-metric-title");
    xTitle = $(this).attr("data-xtitle");
    yTitle = $(this).attr("data-ytitle");
    xPoint = $(this).attr("data-xpoint");
    yPoint = $(this).attr("data-ypoint");
    getDetailsForChart(arraySelect, xPoint, yPoint);
    return false;
  }));

  // Empties array items when chart is closed
  $("#modalChart").on('hidden', function () {
    chartOptions.series = [];
    apptDataChart.length = 0;
  });
  /*** End - Functions to actually draw charts ***/
  
/**** End - Code related to pediatric growth tables/charts ****/
});
</script>
