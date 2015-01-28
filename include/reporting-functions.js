$(document).ready(function () {

  // Get language from filter button on initial load
  var checkLanguage = $("#filterSubmit").attr("data-language");

  /*** Options for Highcharts ***/
  // Set defaults for all charts on pages
  var chart;
  var series = [];
  var chartOptions = {
    chart: {
      renderTo: 'container',
      type: 'line'
    },
    title: {
      text: null
    },
    credits: {
      enabled: false
    },
    yAxis: {
      title: {
        text: null
      },
      labels: {
        formatter: function() {
          return this.value
        }
      },
      min: 0
    },
    tooltip: {
      crosshairs: true,
      shared: true
    },
    xAxis: {
        //type: 'datetime',
    },
    plotOptions: { 
     spline: {
        marker: {
          radius: 4,
          lineColor: '#666666',
          lineWidth: 1
        }
      }
    },
    series: []
  };
  var chartOptionsMany = {
    chart: {
      renderTo: 'containerMany',
      type: 'line'
    },
    title: {
      text: null
    },
    credits: {
      enabled: false
    },
    yAxis: {
      title: {
        text: ''
      },
      labels: {
        formatter: function() {
          return this.value
        }
      },
      min: 0
    },
    tooltip: {
      crosshairs: true,
      shared: true
    },
    xAxis: {
        //type: 'datetime',
    },
    plotOptions: {
      spline: {
        marker: {
          radius: 4,
          lineColor: '#666666',
          lineWidth: 1
        }
      },
      area: {
        stacking: 'normal'
      }
    },
    series: []
  };
  // Draws a chart for single series only.
  function drawChart(passTitle, passCats, passName, passVal) {
    var options = chartOptions;
    options.series[0] = {data: passVal, name: passName};
    options.chart.renderTo = 'container';
    options.xAxis = { categories: passCats };
    chart = new Highcharts.Chart(options);
    $("#modalChartTitle").html(passTitle);
    $("#modalChart").modal();
  }
  // Draws a chart with multiple series
  function drawChartMany(manyTitle, manyCats, manyName, manyVal) {
    var options = chartOptionsMany;
    var count = $(manyVal).length;
    for(var i = 0; i < count; i++) {
      options.series[i] = {data: manyVal[i], name: manyName[i]};  
    }
    options.xAxis = { categories: manyCats };
    chart = new Highcharts.Chart(options);
    $("#modalChartManyTitle").html(manyTitle);
    $("#modalChartMany").modal();
  }
  /*** End Highcharts options ***/

  /*** Options for Datatables ***/
  // Defaults for TableTool export options  
  TableTools.DEFAULTS.aButtons = [ 
    "xls",
    "pdf",
    // FIXME  - Not localized
    { "sExtends": "copy", "sButtonText": "Copier", 
      "fnComplete" : function(nButton, oConfig, flash, text) {
        var
          lines = text.split('\n').length,
          len = this.s.dt.nTFoot === null ? lines-1 : lines-2,
          plural = (len==1) ? "" : "s";
        this.fnInfo( '<div class="alert alert-info" style="margin-top: 20px"><h6>Copié dans le presse-papiers.</h6>'+
          '<p>'+len+' ligne'+plural+' copié dans le Presse-papiers.</p></div>',
          2500
        );
      }
    }  
  ];
  TableTools.DEFAULTS.sSwfPath = [
    "include/copy_csv_xls_pdf.swf"
  ];
  
  // Datatable customizations (based on OpenELIS work)
  // Converts dates from our display format ( dd/mm/yyyy ) to
  // a sortable order
  jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function ( a ) {
        var ukDatea = a.split('/');
        // Handles unknown dates for proper sort
        if (ukDatea[0] == 'XX' || ukDatea[0] == 'xx') {
          ukDatea[0] = '01';
        }
        if (ukDatea[1] == 'XX' || ukDatea[1] == 'xx') {
          ukDatea[1] = '01';
        }
        if (ukDatea[2] == 'XXXX' || ukDatea[2] == 'xxxx') {
          ukDatea[1] = '1000';
        }
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },
    "date-uk-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "date-uk-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
  });
  /* Set the defaults for DataTables initialisation */
  $.extend( true, $.fn.dataTable.defaults, {
    "sDom": "<'row-fluid'<'span3'l><'span4'T><'span5'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
    "sPaginationType": "bootstrap",
    "oLanguage": {
        // FIXME - Not localized
        "sLengthMenu": "Afficher _MENU_ ",
        "sSearch": "Filtrer : ",
        "sInfoFiltered": "(filtrée à partir de _MAX_)",
        "sInfoEmpty": " ",
        "sInfo": " _START_ à _END_ de _TOTAL_",
        "sZeroRecords": "Aucun patient correspondant n'a été trouvé.",
        "sEmptyTable": "Aucun patient correspondant n'a été trouvé.",
        "oPaginate": {
          "sPrevious": " ",
          "sNext": " "
        }
    }
  });
  /* Default class modification */
  $.extend( $.fn.dataTableExt.oStdClasses, {
    "sWrapper": "dataTables_wrapper form-inline"
  });
  /* API method to get paging information */
  $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings ) {
    return {
      "iStart":         oSettings._iDisplayStart,
      "iEnd":           oSettings.fnDisplayEnd(),
      "iLength":        oSettings._iDisplayLength,
      "iTotal":         oSettings.fnRecordsTotal(),
      "iFilteredTotal": oSettings.fnRecordsDisplay(),
      "iPage":          oSettings._iDisplayLength === -1 ?
        0 : Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
      "iTotalPages":    oSettings._iDisplayLength === -1 ?
        0 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
    };
  };
  /* Bootstrap style pagination control */
  $.extend( $.fn.dataTableExt.oPagination, {
    "bootstrap": {
      "fnInit": function( oSettings, nPaging, fnDraw ) {
        var oLang = oSettings.oLanguage.oPaginate;
        var fnClickHandler = function ( e ) {
          e.preventDefault();
          if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
            fnDraw( oSettings );
          }
        };
        $(nPaging).addClass('pagination').append(
          '<ul>'+
            '<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
            '<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
          '</ul>'
        );
        var els = $('a', nPaging);
        $(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
        $(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
      },
      "fnUpdate": function ( oSettings, fnDraw ) {
        var iListLength = 5;
        var oPaging = oSettings.oInstance.fnPagingInfo();
        var an = oSettings.aanFeatures.p;
        var i, ien, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);
        if ( oPaging.iTotalPages < iListLength) {
          iStart = 1;
          iEnd = oPaging.iTotalPages;
        }
        else if ( oPaging.iPage <= iHalf ) {
          iStart = 1;
          iEnd = iListLength;
        } else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
          iStart = oPaging.iTotalPages - iListLength + 1;
          iEnd = oPaging.iTotalPages;
        } else {
          iStart = oPaging.iPage - iHalf + 1;
          iEnd = iStart + iListLength - 1;
        }
        for ( i=0, ien=an.length ; i<ien ; i++ ) {
          // Remove the middle elements
          $('li:gt(0)', an[i]).filter(':not(:last)').remove();
          // Add the new list items and their event handlers
          for ( j=iStart ; j<=iEnd ; j++ ) {
            sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
            $('<li '+sClass+'><a href="#">'+j+'</a></li>')
              .insertBefore( $('li:last', an[i])[0] )
              .bind('click', function (e) {
                e.preventDefault();
                oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                fnDraw( oSettings );
              } );
          }
          // Add / remove disabled classes from the static elements
          if ( oPaging.iPage === 0 ) {
            $('li:first', an[i]).addClass('disabled');
          } else {
            $('li:first', an[i]).removeClass('disabled');
          }

          if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
            $('li:last', an[i]).addClass('disabled');
          } else {
            $('li:last', an[i]).removeClass('disabled');
          }
        }
      }
    }
  });
  /*
   * TableTools Bootstrap compatibility
   * Required TableTools 2.1+
   */
  if ( $.fn.DataTable.TableTools ) {
    // Set the classes that TableTools uses to something suitable for Bootstrap
    $.extend( true, $.fn.DataTable.TableTools.classes, {
      "container": "DTTT btn-group",
      "buttons": {
        "normal": "btn btn-mini",
        "disabled": "disabled"
      },
      "collection": {
        "container": "DTTT_dropdown dropdown-menu",
        "buttons": {
          "normal": "",
          "disabled": "disabled"
        }
      },
      "print": {
        "info": "DTTT_print_info modal"
      },
      "select": {
        "row": "active"
      }
    });

    // Have the collection use a bootstrap compatible dropdown
    $.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
      "collection": {
        "container": "ul",
        "button": "li",
        "liner": "a"
      }
    });
  }
  
  /*** End Datatables options ***/


  /*** Queries for outputting main table ***/

  // Main functions to get data and populate table
  function getData(reportType, timePeriod, timeBack, displayList, indicatorType, hideFilters) {
    $("#resultsByTime").fadeOut('fast', function() {
      $("#hideBox").show();
    });
    $.post('reports-results.php', { reportType: reportType, time : timePeriod, timeBack: timeBack, display: displayList, lang: checkLanguage, indicatorType: indicatorType }, function(data) {
      $("#resultsByTime").html(data);
      fillInTable();
      arrangeSubRows();
      goForwardCheck();
      loadAndDisplay();
      // Get time period for reportTitle header on page.
      var reportTimeFirst = $("th.result-header:first").attr('title');
      var reportTimeLast = $("#datatable thead tr th.result-header").last().attr('title');
      $("#reportTitleTimeStart").html(reportTimeFirst);
      $("#reportTitleTimeEnd").html(reportTimeLast);
    });
  }
  
  // Determine if we want Malaria or Nutrition based on page header attribute
  // Then trigger main function with that reportType. Defaults to Haiti and current
  var reportType = $("h1.page-header").attr("data-report");
  getData(reportType, 'Year', '1', 'Haiti');
  
  // Add view toggles and links to each row
  function fillInTable() {
    var toggleIcon = ' <i class="view-toggle icon-chevron-down icon-gray"></i>';
    $(".report-mainrow").each(function() {
      var rowCount = $(this).nextUntil('.report-mainrow').length;
      if ( rowCount > '0') {
        $(this).find('td.report-row-info span').append(toggleIcon);
        $(this).find('td:first-child').addClass('view-details');
        $(this).children('td').eq(1).find('div').addClass('view-details');
      }
    });
    setTitles(); // Set in main results.php page to localize
  }

  // Add correct rowspan for subrows and add chart link
  // FIXME - Should probably display the chart icon some other way rather than
  // relying on the client to redo.
  function arrangeSubRows() {
    $(".report-mainrow").each(function() {
      var rowCount = $(this).nextUntil('.report-mainrow').length;
      var multiChart = "<td class='subrows-chart' rowspan='" + rowCount +"'><a href='#' class='chart-launch-many'><i></i></a></td>";
      var tooManyRows = "<td class='subrows-chart' rowspan='" + rowCount +"'></td>";
      // Shows link to chart if # of rows is between 1 and 6. This could be tweaked
      // particularly if the graph space is made larger, but too many series make
      // for an ugly chart.
      if (rowCount == '1') {
        $(this).next('tr').prepend("<td class='subrows-chart'></td>");
      } else if ( rowCount > '1' && rowCount < '10' ) {
        $(this).next('tr').prepend(multiChart);
      } else if ( rowCount >= '10' ) {
        $(this).next('tr').prepend(tooManyRows);
      }
    });
  }

  // Shows the report table after data loads
  function loadAndDisplay() {
    $("#hideBox").delay(800).fadeOut('fast', function() {
      $("#resultsByTime").show();
    });
  }

  /*** End functions for outputting main table ***/


  /*** Functions to handle patient and section count modals ***/
 
  // Patient modal open. Uses $.post to query database
  $("#contentArea").on('click', '.patient-launch', (function() {
    var type = $(this).closest('tr').attr('class');
    var sitecode = $(this).closest('tr').attr('sitecode');
    var indicator2 = "";
    if ($(this).hasClass('denom-launch')) {
      var indicator = $(this).closest('tr').attr('data-indicator-d');
      var numType = textDenominator;
    } else if ($(this).hasClass('comp-launch')) {
      // To find complement list, we need both num and denom indicators IDs
      var indicator = $(this).closest('tr').attr('data-indicator-d');
      var indicator2 = $(this).closest('tr').attr('data-indicator');
      var numType = textComplement;
    } else {
      var indicator = $(this).closest('tr').attr('data-indicator');
      var numType = textNumerator;
    }
    var timePeriod = $("#datatable").attr('time');
    var display = $("#datatable").attr('data-display');
    var displayUnit = $(this).closest('tr').attr("name");
    var gender = $(this).attr("data-gender");
    var thisBox = $(this).parent().attr("data-box");
    var year = $('#datatable thead tr th.result-header[data-box="' + thisBox + '"]').attr('year');
    var period = $('#datatable thead tr th.result-header[data-box="' + thisBox + '"]').attr('period');
    var columnTitle = $('#datatable thead tr th.result-header[data-box="' + thisBox + '"]').attr('title');
    $.post('reports-patients.php', { reportType: reportType, lang: checkLanguage, type: type, sitecode: sitecode, display: display, displayUnit: displayUnit, indicator: indicator, indicator2: indicator2, timePeriod: timePeriod, year: year, period: period, gender: gender }, function(data) {
      // Inserts patient list table into modal
      $("#patientOutput").html(data);
      // Gets count of patients and then updates display
      var patientRowCount = $('#patientRowCount').attr('count');  
      $("#patientCount").html(patientRowCount);
      var genderTitle = "";
      if (gender == 1) {
        genderTitle = textGenderF; 
      } else if (gender == 2) {
        genderTitle = textGenderM;
      } else {
        genderTitle = textGenderAll;
      }
      $("#patientNumberType").html(numType);
      $("#patientGender").html(genderTitle);
      loadAndDisplayPatients();
    });
    if (type == 'report-subrow') {
      var graphTitleParent = $(this).closest('tr').prevAll("tr.report-mainrow:first").attr("name");
      var graphTitle = graphTitleParent + " - " + displayUnit;
    } else {
      var graphTitle = displayUnit;
    }
    graphTitle = graphTitle + " - " + columnTitle;
    $("#modalPatientsTitle").text(graphTitle);
    // Updates page title - useful when printing via TableTools
    $("title").text("Liste des patients - " + graphTitle);
    /** Actually open modal window **/
    $("#modalPatients").modal();
    clearAllPopovers();
  }));
  
  // Removes patient table when modal is closed. Prevents flashes of old list
  // when a new list is opened. Also, allow for display of the 'loading' graphic
  $('#modalPatients').on('hidden', function () {
    $('#patientOutput').empty().addClass('invisible');
    $("#hideBoxPatients").show();
    // Revert title back to original
    $("title").text(pageTitleOriginal);
  })
  
  // Address sections modal open. Uses $.post to query database
  $("#contentArea").on('click', '.section-launch', (function() {
    var indicator = $(this).closest('tr').attr('data-indicator');
    var timePeriod = $("#datatable").attr('time');
    var displayUnit = $(this).closest('tr').attr("name");
    var thisBox = $(this).attr("data-box");
    var year = $('#datatable thead tr th.result-header[data-box="' + thisBox + '"]').attr('year');
    var period = $('#datatable thead tr th.result-header[data-box="' + thisBox + '"]').attr('period');
    var columnTitle = $('#datatable thead tr th.result-header[data-box="' + thisBox + '"]').attr('title');
    $.post('reports-sections.php', { reportType: reportType, lang: checkLanguage, indicator: indicator, timePeriod: timePeriod, year: year, period: period, columnTitle: columnTitle }, function(data) {
      // Inserts address section list table into modal
      $("#sectionOutput").html(data);
      loadAndDisplaySections();
    });
    var graphTitle = displayUnit + " - " + columnTitle;
    $("#modalSectionTitle").text(graphTitle);
    // Updates page title - useful when printing via TableTools
    $("title").text("Patient Communes - Localities - " + graphTitle);
    /** Actually open modal window **/
    $("#modalSection").modal();
    clearAllPopovers();
  }));
  // Removes patient table when modal is closed. Prevents flashes of old list
  // when a new list is opened. Also, allow for display of the 'loading' graphic
  $('#modalSection').on('hidden', function () {
    $('#sectionOutput').empty().addClass('invisible');
    $("#hideBoxSection").show();
    // Revert title back to original
    $("title").text(pageTitleOriginal);
  })

  // Shows the patient table in modal after data loads
  function loadAndDisplayPatients() {
    $("#hideBoxPatients").delay(1000).fadeOut('fast', function() {
      var oTable = $('#patientTable').dataTable({
        // Options for proper display, sorting with datatables
        "aoColumnDefs": [
          { "aTargets": [0], "sType": "html" },
          { "aTargets": [4], "sType": "date-uk" }
        ],
        // FIXME - "Tous" not localized
        "aLengthMenu": [[10, 100 , -1], [10, 100, "Tous"]],
        // Empty sorting means we let sql output handle the sorting
        aaSorting: []
      });
      $("#patientOutput").removeClass('invisible');
    });
  }

  // Shows the report table in modal after data loads
  function loadAndDisplaySections() {
    $("#hideBoxSection").delay(1000).fadeOut('fast', function() {
      var oTable = $('#sectionTable').dataTable({
        // FIXME - "Tous" not localized
        "aLengthMenu": [[10, 100 , -1], [10, 100, "Tous"]],
        // Empty sorting means we let sql output handle the sorting
        aaSorting: []
      });
      $("#sectionOutput").removeClass('invisible');
    });
  }
  
  /*** End Functions to handle patient and section count modals ***/ 

  /*** Exporting to CSV function ***/
  
  // Function to export csv from main table - pulls values from table and
  // creates a csv which is either downloaded or opened in a modal.
  // Based on: http://stackoverflow.com/questions/16078544/export-to-csv-using-jquery-and-html
  function exportTableToCSV($table, destination, filename) {

      // Get table header info. Repeating each three times to add numerator
      // and denominator as separate fields to make sorting easier.
      var outputHeader = '"ID",';
      $("#datatable thead tr th").each(function(index) {
        if (index == 0) {
          outputHeader += '"'+$(this).text()+'",';
        } else {
          outputHeader += '"'+$(this).text()+'","'+$(this).text()+' - N","'+$(this).text()+' - D",';
        }
      });
      // Remove final comma from header
      outputHeader = outputHeader.slice(0, - 1);

      var $rows = $table.find('tbody tr:has(td), thead tr:has(th)'),
          // Temporary delimiter characters unlikely to be typed by keyboard
          // This is to avoid accidentally splitting the actual contents
          tmpColDelim = String.fromCharCode(11), // vertical tab character
          tmpRowDelim = String.fromCharCode(0), // null character
          // actual delimiter characters for CSV format
          colDelim = '","',
          rowDelim = '"\r\n"',           

          // Grab text from table into CSV formatted string
          csv = '"' + $rows.map(function (i, row) {
              var $row = $(row),
                  // Get all the columns except the ones that don't have data
                  $cols = $row.find('td:not(.skip-export,.subrows-chart)');

              return $cols.map(function (j, col) {
                  var $col = $(col),
                      rowClass = $col.attr('class');
                      text = $col.text();

                  // Various ways we separate the data into the proper columns
                  // TODO - this could be improved and is dependent on the
                  // format of the cells.
                  // : separates indicator ID and name - for main row
                  if (text.indexOf(" : ") >= 0) {
                    text = text.split(' : ');
                    return text[0]+'","'+text[1];
                  // For subrows get the indicator ID
                  } else if (rowClass == 'report-row-info') {
                    var subrowIndicator = $col.parent().attr('data-indicator');
                    return subrowIndicator+'"," -- '+text;
                  // Need to split ratios to avoid problems with excel 
                  // interpreting as a date.
                  } else if (rowClass == 'cell-no-bl cell-ratio') {
                    // Slash corresponds with indicatorType = 1
                    if (text.indexOf("/") >= 0) {
                      text = text.split('/');
                      return text[0]+'","'+text[1];
                    } else {
                      // If not a ratio, then display the numerator and then
                      // a blank for denom.
                      return text+'","';
                    }
                  } else {
                    if ($(this).find('span').hasClass('data-graph')) {
                      // Otherwise just grab the value. replace might not be
                      // necessary
                      return text.replace('"', '""'); // escape double quotes
                    } else {
                      return "";
                    }
                    
                  }

              }).get().join(tmpColDelim);

          }).get().join(tmpRowDelim)
              .split(tmpRowDelim).join(rowDelim)
              .split(tmpColDelim).join(colDelim) + '"',

          // Data URI
          csvData = 'data:application/vnd.ms-excel,' + encodeURIComponent(outputHeader + csv);

          // Two ways to output CSV, first is textarea within modal
          if (destination == 'modal') {
            $("#csvBox").html(outputHeader + csv);
            $("#modalCsv").modal();
          // Otherwise download csv file
          } else {             
            $(this)
                .attr({
                'download': filename,
                    'href': csvData
            });
          }
  }

  // Two ways to export the table as CSV
  $("#contentArea").on('click', '.export-button', (function() {
      var exportType = $(this).attr('id');
      // Export file
      if (exportType == 'btnExport') {
        var pageName = $("h1.page-header").text();
        exportTableToCSV.apply(this, [$('#exportContainer>table'), 'export', pageName+'-export.csv']);
      // Display csv in modal
      } else {
        exportTableToCSV.apply(this, [$('#exportContainer>table'), 'modal','']);
      }
      clearAllPopovers();
  })); 
  
  /*** End - Exporting to CSV functions ***/

  /*** Charting functions (uses Highcharts) ***/
  
  // Main single line chart used with rows and subrows
  $("#contentArea").on('click', '.chart-launch', (function() {
    // Set chart title and series name
    var graphTitle = $(this).closest('tr').attr("name");
    var graphClass = $(this).closest('tr').attr("class");
    if (graphClass == 'report-subrow') {
      var graphTitleParent = $(this).closest('tr').prevAll("tr.report-mainrow:first").attr("name");
      graphTitle = graphTitleParent + " - " + graphTitle;
    } else {
    	graphTitle = graphTitle;
    }
    seriesName = graphTitle;
    // Set chart data
    var series = { data: [] };
    var tds = $(this).parent().parent().nextAll().find('span.data-graph');
  	$.each(tds, function(index, item) {
  	  series.data.push(parseFloat(item.innerHTML));
  	});
    var cats = $(this).closest('table').find('thead tr th.indicator-name').nextAll();
    var category = { labels: [] };
    $.each(cats, function(index, item) {
  	  category.labels.push(item.innerHTML);
  	});
    // Executes the drawChart function
    drawChart(graphTitle, category.labels, seriesName, series.data);
    clearAllPopovers();
    return false;
  }));
  // Chart for multiple locations (used with subrows and only when 6 or less rows)
  $("#contentArea").on('click', '.chart-launch-many', (function() {
    // Set chart title and series name
    var graphTitle = $(this).closest('tr').prev().attr("name");
    // Set chart data
    var numbersFun = [];
    var namesFun = [];
    var trs = $(this).parents('tr').prev().nextUntil('.report-mainrow');
    $(trs).each(function(index) {
    	var title = $(this).find('.report-row-title').text();
    	namesFun.push(title);
    	var series = { data: [] };
    	var tds = $(this).children('.report-row-info').nextAll().find('span.data-graph');
		  $.each(tds, function(index, item) {
		    series.data.push(parseFloat(item.innerHTML));
		  });
      numbersFun.push(series.data);
    });
    var cats = $(this).closest('table').find('thead tr th.indicator-name').nextAll();
    var category = { labels: [] };
    $.each(cats, function(index, item) {
      category.labels.push(item.innerHTML);
    });
    seriesName = graphTitle;
    drawChartMany(graphTitle, category.labels, namesFun, numbersFun);
    clearAllPopovers();
    return false;
  }));
  
  /*** End - Charting functions (uses Highcharts) ***/


  /*** Filter/viewing functions ***/
  
  // Filter buttons that pass attributes to the main #filterSubmit button
  var filterDisplay, filterTime, filterIndicatorType = '';
  $("#chooserDisplay").on("change", function() {
    filterDisplay = $(this).val();
    $('#filterSubmit').attr('data-display', filterDisplay).attr('timeBack', '1');
  });
  $("#chooserTime .btn").click(function() {
    filterTime = $(this).attr('name');
    $('#filterSubmit').attr('time', filterTime).attr('timeBack', '1');
  });
  $("#chooserIndicatorType").on("change", function() {
    filterIndicatorType = $(this).val();
    $('#filterSubmit').attr('data-indicator-type', filterIndicatorType);
  });
  // Filter submit function -- passes all attributes to getData
  $('#filterSubmit').click(function() {
    var timePeriod = $(this).attr('time');
    var timeBack = $(this).attr('timeBack');
    var display = $(this).attr('data-display');
    var hide = $(this).attr('hide');
    var indicatorType = $(this).attr('data-indicator-type');
    getData(reportType, timePeriod, timeBack, display, indicatorType, hide);
  });
  
  /*** End - Filter/viewing functions ***/
  
  
  /*** Functions for the back/forward buttons to navigate through time periods. ***/
  
  // Checks whether goForward link should be enabled
  function goForwardCheck() {
    var goForwardChecker = $("#goForward").attr('name');
    if ( goForwardChecker > '0' ) {
      $("#goForward").removeClass('disabled').removeAttr("disabled");
    } 
  }
  // Click behavior for back/forward buttons
  $("#contentArea").on('click', '#goBack', (function() {
    filterBack = $("#goBack").attr('name');
    $('#filterSubmit').attr('timeBack', filterBack).trigger('click');
  }));
  $("#contentArea").on('click', '#goForward', (function() {
    filterForward = $("#goForward").attr('name');
    $('#filterSubmit').attr('timeBack', filterForward).trigger('click');
  }));

  /*** End  - back/forward functions ***/
  
  /*** Popover functions ***/
  
  // Add little button to close popover
  function addPopoverClose() {
    $(".popover-title").wrapInner('<span />').prepend('<button type="button" id="closePopover" class="close">&times;</button>');
  }
  function clearAllPopovers() {
    $('.popover:visible').prev().popover('destroy').removeClass('open-pop');
  }
  // Main function to trigger popovers
  $("#contentArea").on('click', '[rel="popover"]', (function() {
    // Get rid of any popovers that are visible
    $('.popover:visible').prev().popover('destroy');
    if($(this).hasClass('open-pop')) {
        $(this).removeClass('open-pop');
    // If not already visible then create popover
    } else {
      // Get indicator title
      var getIndicator = $(this).closest('tr').attr("name");
      // Need to remove class from any launch-definitions so that they open properly
      // next time
      $('.launch-definition').removeClass('open-pop');
      // Trigger popovers with bootstrap options and title
      if ($(this).hasClass("launch-definition")) {
        // Popover for indicator definitions
        $(this)
          .popover({placement: 'top', html: true, title: getIndicator})
          .popover('show').addClass('open-pop');
      } else if ($(this).hasClass("launch-list")) {
        // Popover for patient lists
        var thisBox = $(this).attr("data-box");
        var displayUnit = $(this).closest('tr').attr("name");
        var columnTitle = $('#datatable thead tr th.result-header[data-box="' + thisBox + '"]').attr('title');
        var dataCount = "";
        if ($(this).hasClass("subrow-list")) {
          var parentTitle = $(this).closest('tr').prevAll("tr.report-mainrow:first").attr("name");
          var displayTitle = parentTitle;
          dataCount += '<h3 style="margin-bottom: 0.5em">'+displayUnit+' - '+columnTitle+'</h3>';
        } else {
          var displayTitle = displayUnit + ' - ' + columnTitle;
        }
        // Create block of content for patient list
        dataCount += "<div class='count-gender'><div>"+textTotal+"<br />"+textGenderF+"<br />"+textGenderM+"</div>";
        if ($(this).attr('data-percent')) {
          dataCount += "<div>" + $(this).attr('data-percent') + "<br />" + $(this).attr('data-percent-f') + "<br />" + $(this).attr('data-percent-m') + "</div>";
        }
        dataCount += "<div data-box='"+thisBox+"'><a href='#' class='patient-launch' data-gender='' title='"+patientText+" - "+textNumerator+"'>"+$(this).attr('data-count')+"</a>";
        if ($(this).attr('data-count-d')) {
          dataCount += " / <a href='#' class='patient-launch denom-launch' data-gender='' title='"+patientText+" - "+textDenominator+"'>"+$(this).attr('data-count-d')+"</a>";
        }
        dataCount += "<br /><a href='#' class='patient-launch' data-gender='1' title='"+patientText+" - "+textNumerator+"'>" + $(this).attr('data-count-f') + "</a>";
        if ($(this).attr('data-count-fd')) {
          dataCount += " / <a href='#' class='patient-launch denom-launch' data-gender='1' title='"+patientText+" - "+textDenominator+"'>"+$(this).attr('data-count-fd')+"</a>";
        }
        dataCount += "<br /><a href='#' class='patient-launch' data-gender='2' title='"+patientText+" - "+textNumerator+"'>" + $(this).attr('data-count-m') + "</a>";
        if ($(this).attr('data-count-md')) {
          dataCount += " / <a href='#' class='patient-launch denom-launch' data-gender='2' title='"+patientText+" - "+textDenominator+"'>"+$(this).attr('data-count-md')+"</a>";
        }
        dataCount += "</div>"; // End of ratios
        if ($(this).attr('data-percent')) {
          dataCount += "<div data-box='"+thisBox+"'>";
          var compP, compPF, compPM = "";
          compP = (100 - parseFloat($(this).attr('data-percent'))).toFixed(1);
          if (compP > 0) {
            dataCount += "<a href='#' class='patient-launch comp-launch' data-gender='' title='"+patientText+" - "+textComplement+"'>"+compP+"%</a><br />";
          } else {
            dataCount += compP+"%<br />";
          }
          if ($(this).attr('data-percent-f')) {
            compPF = (100 - parseFloat($(this).attr('data-percent-f'))).toFixed(1);
            if (compPF > 0) {
              dataCount += "<a href='#' class='patient-launch comp-launch' data-gender='1' title='"+patientText+" - "+textComplement+"'>"+compPF+"%</a><br />";
            } else {
              dataCount += compPF+"%<br />";
            }           
          } else {
            dataCount += "<br />";
          }
          if ($(this).attr('data-percent-m')) {
            compPM = (100 - parseFloat($(this).attr('data-percent-m'))).toFixed(1);
            if (compPM > 0) {
              dataCount += "<a href='#' class='patient-launch comp-launch' data-gender='2' title='"+patientText+" - "+textComplement+"'>"+compPM+"%</a><br />";
            } else {
              dataCount += compPM+"%<br />";
            }
          } else {
            dataCount += "<br />";
          }
          dataCount += "</div>";
        }
        dataCount += "</div>";
        // Include button for patient commune-town list
        if (!$(this).hasClass("subrow-list")) {
          dataCount += '&nbsp; <button href="#" class="section-launch btn btn-small" data-box="'+thisBox+'">'+textTitleSection+'</button>';
        }
        $(this)
          .popover({placement: 'top', html: true, title: displayTitle, content: dataCount})
          .popover('show').addClass('open-pop');
      } else if ($(this).hasClass("csv-list")) {
        // Popover for downloading CSV
        var listContent = '<div style="white-space: nowrap"><a class="btn btn-small export-button" id="btnExport">'+textSaveCsv+'</a> &nbsp; <a class="btn btn-small export-button" id="btnShow">'+textShowCsv+'</a></div>';
        $(this)
          .popover({placement: 'top', html: true, title: 'Excel', content: listContent})
          .popover('show').addClass('open-pop');
      }
      addPopoverClose();
    }
    return false;
  }));
  // On closing popover, clear all
  $('#contentArea').on('click', '#closePopover', function() {
    clearAllPopovers();
  });
  
  /*** End - Popover functions ***/
  
  /*** Misc functions ***/

  // Getting <title>. Used later when title changes with TableTools
  var pageTitleOriginal = $("title").text();
  
  // Use toggle to view subrows
  $("#contentArea").on('click', '.view-details', (function() {
    $(this).parents('tr').toggleClass('report-row-open').nextUntil('.report-mainrow').toggle();
    $(this).parents('tr').find('.view-toggle').toggleClass('icon-chevron-down').toggleClass('icon-chevron-up');
    setSubTitles();
  }));
  
  // Function to print main table
  $("#contentArea").on('click', '#btnPrint', (function() {
    $("h1.page-header").html("iSante - " + $("h1.page-header").text());
    $("#banner").addClass('print-hide');
    window.print();
  }));
  
  // Opens Help modal
  $("#helpLaunch").click(function() {
    $("#modalHelp").modal();
    clearAllPopovers();
  }); 
  // Reset series values on close of modal chart
  $("#modalChartMany").on('hidden', function () {
    chartOptionsMany.series = [];
  });
  $("#modalChart").on('hidden', function () {
    chartOptions.series = [];
  });
  
  /*** End - misc functions ***/

/*
$("#csvMain").click(function(){
  $("table.report-table").toCSV();
})
jQuery.fn.toCSV = function() {
  var data = $(this).first(); //Only one table
  var csvData = [];
  var tmpArr = [];
  var tmpStr = '';
  data.find("tr").each(function() {
      if($(this).find("th").length) {
          $(this).find("th").each(function() {
            tmpStr = $(this).text().replace(/"/g, '""');
            tmpArr.push('"' + tmpStr + '"');
          });
          csvData.push(tmpArr);
      } else {
          tmpArr = [];
             $(this).find("td").each(function() {
                  if($(this).text().match(/^-{0,1}\d*\.{0,1}\d+$/)) {
                      tmpArr.push(parseFloat($(this).text()));
                  } else {
                      tmpStr = $(this).text().replace(/"/g, '""');
                      tmpArr.push('"' + tmpStr + '"');
                  }
             });
          csvData.push(tmpArr.join(','));
      }
  });
  var output = csvData.join('\n');
  var uri = 'data:text/csv;charset=UTF-8,' + encodeURIComponent(output);
  window.open(uri, 'table.csv');
}  
*/ 
/*** Functions not currently in use ***/


  /*** Experimenting with calling the patient data via Datatables JSON post. 
   *   Not working yet.Would be significantly faster.
      $('#patientTable').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": 'reports-' + reportType + '-patients2.php',
      "aoColumns": [
        { "mData": "patientid" },
        { "mData": "fname" },
        { "mData": "lname" },
        { "mData": "sex" },
        { "mData": "dobDd" }
      ],
      "fnServerData": function ( sSource, aoData, fnCallback ) {
            aoData.push( { lang: lang, type: type, sitecode: sitecode, display: display, displayUnit: displayUnit, indicator: indicator, timePeriod: timePeriod, year: year, period: period } );
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            } );
        }
    });
  */

/** Hide emptry rows - depends on 0 or 0.00% in cell
function hideZero() {
  $('table tr.report-subrow').each(function(){
    $(this).find('td.subrows-chart').remove();
    var hide = true;
    $(this).find('td.report-row-info').nextAll().each(function(){
        if($(this).text() != '0' && $(this).text() != '0.00%')
            hide = false;
    });
    if(hide)
        $(this).remove();
  });
  $("#reportTitleZero").show();
}
// This would be added to the filters
$("#hideZeroButton").click(function() {
  if ($('#hideZeroButton').is(':checked')) {
    filterHide = $(this).attr('value');
  } else {
    filterHide = '';
  }
  $('#filterSubmit').attr('hide', filterHide);
});
**/

});
