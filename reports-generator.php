<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/report.php';
require_once 'labels/menu.php';
       
// Get requested report. Defaults to malaria if not specified
$reportRequest = 'malaria';
if (isset ($_REQUEST['rpt'])) $reportRequest = $_REQUEST['rpt'];

// The main query - uses left join to show all potential indicators
if ($reportRequest == 'tb' || $reportRequest == 'malaria' || $reportRequest == 'dataquality'|| $reportRequest =='mer') {
  $sqlByType = "select distinct subGroup$lang from dw_".$reportRequest."ReportLookup";
  $resultByType = databaseSelect()->query($sqlByType)->fetchAll(PDO::FETCH_ASSOC);
}


// Get localized name to display
switch ($reportRequest) {
  case 'nutrition':
  $reportTranslateName = 10;
  break;
  case 'malaria':
  $reportTranslateName = 9;
  break;
  case "tb":
  $reportTranslateName = 11;
  break;
  case "obgyn":
  $reportTranslateName = 13;
  break;
   case "dataquality":
  $reportTranslateName = 14;
  break;
     case "mer":
  $reportTranslateName = 15;
  break;
}

if (DEBUG_FLAG) print_r($_GET);
echo "
<title>".$menuReports[$lang][$reportTranslateName]." - ".$topLabels[$lang][3]."</title>
";
?>
<link rel="stylesheet" type="text/css" href="bootstrap.css?<?= urlencode(APP_VERSION) ?>">
<link rel="stylesheet" type="text/css" href="reporting.css">
<script type="text/javascript" src="include/bootstrap.js"></script>
<script type="text/javascript" src="include/reporting-functions.js"></script>
<script type="text/javascript" src="Highcharts-2.2.3/js/highcharts.js"></script>
<script type="text/javascript" src="include/jquery.datatables.js"></script>
<script type="text/javascript" src="include/ZeroClipboard.js"></script>
<script type="text/javascript" src="include/jquery.datatables.tabletools.js"></script>
</head>
<body>

<?php
include ("bannerbody.php");
require_once 'backendAddon.php'; 
?>

  
<div id="contentArea" class="contentArea">
  
  <div class="row-fluid">
    <div class="span12">
      <h1 class="page-header" data-report="<?= $reportRequest ?>"><?= $menuReports[$lang][$reportTranslateName]; ?></h1>      
    </div>
  </div>
  
  <div class="row-fluid print-hide">
    <div class="span12">
      <div class="pull-right">
        <button type="button" class="btn btn-mini" id="helpLaunch" title="<?php echo $reportFilteringLabels[$lang][41]?>"><i class="icon-question-sign"></i> <?php echo $topLabels[$lang][6]?></button>
      </div>          
      <h3 class="filter-title"><?php echo $reportFilteringLabels[$lang][32]?>:</h3>
    </div>
  </div>

  <div class="row-fluid print-hide">
    <div class="filter-box">
      
          <?php 
          $filterCount = 1;
          // Add indicator type selection for TB. Could expand to all report types
          if ($reportRequest == 'tb' || $reportRequest == 'malaria' || $reportRequest == 'dataquality'|| $reportRequest == 'mer') { ?>
          <div class="span">
            <div class="filter-header"><?php 
              echo $filterCount.'. '.$reportFilteringLabels[$lang][51];
              $filterCount++;
            ?></div>
            <select id="chooserIndicatorType" style="margin-top: 6px">
              <option value=""><?php echo $reportFilteringLabels[$lang][50]?></option>
              <?php
              for ($i = 0; $i < count($resultByType); $i++) {
                echo '<option>'.$resultByType[$i]['subGroup'.$lang].'</option>';
              }
              ?>
            </select>
          </div>
          <?php } // if ($reportRequest == 'tb' || $reportRequest == 'malaria') ?>
          <div class="span">
            <div class="filter-header"><?php 
              echo $filterCount.'. '.$reportFilteringLabels[$lang][9];
              $filterCount++;
            ?></div>
            <div class="btn-group" data-toggle="buttons-radio" id="chooserTime" style="margin-top: 6px">
              <button type="button" class="btn btn-small active" id="byYear" name="year"><?php echo $reportFilteringLabels[$lang][4]?></button>
              <button type="button" class="btn btn-small" id="byMonth" name="month"><?php echo $reportFilteringLabels[$lang][3]?></button>
              <button type="button" class="btn btn-small" id="byWeek" name="week"><?php echo $reportFilteringLabels[$lang][2]?></button>
            </div>
          </div>
          <div class="span" style="font-size: 10.5px">
            <div class="filter-header"><?php 
              echo $filterCount.'. '.$reportFilteringLabels[$lang][12];
              $filterCount++;
            ?></div>
            <div  style="margin-top: 6px">
              <?php echo $reportFilteringLabels[$lang][13]?>:
              <select id="chooserDisplay">
                <option value="Haiti"><?php echo $reportFilteringLabels[$lang][11]?></option>
                <option value="Network"><?php echo $kickLabel['groupLevel'][$lang][5]; ?></option>
                <option value="Department"><?php echo $kickLabel['groupLevel'][$lang][4]; ?></option>
                <option value="Commune"><?php echo $kickLabel['groupLevel'][$lang][3]; ?></option>
                <option value="SiteCode"><?php echo $kickLabel['groupLevel'][$lang][2]; ?></option>
              </select>
            </div>
          </div>
          <div class="span">
            <div class="filter-header"><?php 
              echo $filterCount.'. '.$reportFilteringLabels[$lang][36];
            ?></div>
            <button id="filterSubmit" class="btn btn-primary filter-button" data-indicator-type="" time="year" data-display="Haiti" timeBack="1" data-language="<?php echo $lang ?>"><?php echo $reportFilteringLabels[$lang][10] ?></button>
          </div>                        
      </div>
  </div>
  

  <div class="row-fluid">
    <div class="span12">
      <div style="display: none" class="loading-box" id="hideBox"></div>
      <div class="detail-container" id="resultsByTime"></div>
    </div>
  </div>

    
</div>
 
<!-- Help Modal -->
  <div id="modalHelp" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalHelpTitle" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="modalHelpTitle"><?php echo $reportFilteringLabels[$lang][41]?></h3>
    </div>
    <div class="modal-body">

         <?php include ("helpfiles/reports-help$lang.php"); ?>
      
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $repReturn[$lang] ?></button>
    </div>
  </div>

<!-- Main Chart Modal -->
  <div id="modalChart" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalChartTitle" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="modalChartTitle"></h3>
    </div>
    <div class="modal-body">
      <div id="container" style="width: 713px; height: 400px; margin: 0 auto"></div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $repReturn[$lang] ?></button>
    </div>
  </div>

  <!-- Multichart Modal -->
  <div id="modalChartMany" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalChartManyTitle" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="modalChartManyTitle"></h3>
    </div>
    <div class="modal-body">
      <div id="containerMany" style="width: 713px; height: 400px; margin: 0 auto"></div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $repReturn[$lang] ?></button>
    </div>
  </div>  
  
  <!-- Patient List Modal -->
  <div id="modalPatients" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalPatientsTitle" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="modalPatientsTitle"></h3>
      <div>
        <span style="font-weight: bold"><?php echo $reportFilteringLabels[$lang][7]?></span>: <span id="patientNumberType"></span><br />
        <span style="font-weight: bold"><?php echo $reportFilteringLabels[$lang][27]?></span> : <span id="patientGender"></span><br />
        <span style="font-weight: bold"><?php echo $reportFilteringLabels[$lang][23]?></span> : <span id="patientCount"></span>
      </div>
    </div>
    <div class="modal-body">
      <div class="loading-box" id="hideBoxPatients"></div>
      <div id="patientOutput" class="invisible">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $repReturn[$lang] ?></button>
    </div>
  </div>
  
  <!-- Address Section List Modal -->
  <div id="modalSection" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalSectionTitle" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="modalSectionTitle"></h3>
    </div>
    <div class="modal-body">
      <div class="loading-box" id="hideBoxSection"></div>
      <div id="sectionOutput" class="invisible">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $repReturn[$lang] ?></button>
    </div>
  </div>

  <!-- CSV Output Modal -->
  <div id="modalCsv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalCsvTitle" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="modalCsvTitle">CSV Output</h3>
    </div>
    <div class="modal-body">
      <textarea id="csvBox" cols=80 rows=18 wrap="off" ></textarea>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $repReturn[$lang] ?></button>
    </div>
  </div>
   
</body>
</html>
