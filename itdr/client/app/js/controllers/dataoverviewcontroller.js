appControllers.controller('DataOverviewCtrl',
  function ($scope, $http, $filter, webApiUrl, baseUrl, ngTableParams) {
      //Functions
      $scope.initialize = function () {
          $scope.subjects = lookups.subjects;
          $scope.timeLevels = lookups.timeLevelsForDataOverview;
          $scope.geographyLevels = lookups.geographyLevels;
          $scope.selectedSubject = [];
          $scope.selectedGeographyLevel = [];
          $scope.selectedTimeLevel = [];

          $scope.setSelections();
          $scope.setHiddenFields();
          
          // jquery-to get around issues with angular in downloading file
          //document.downloadRawForm.action = webApiUrl.concat('downloadraw.php');
          $scope.baseUrl = baseUrl;
      };

      $scope.setSelections = function () {
          $scope.selectedSubject = $scope.subjects[0];
          $scope.selectedGeographyLevel = $scope.geographyLevels[0];
          $scope.selectedTimeLevel = $scope.timeLevels[0];
          $scope.groupOnAge = false;
          $scope.groupOnGender = false;
      };

      $scope.getSelectionsAsQueryString = function () {
          var groupAge = $scope.groupOnAge ? 1 : 0;
          var groupGender = $scope.groupOnGender ? 1 : 0;          
          var queryString = '?subjectId='.concat($scope.selectedSubject.value, '&timeLevel=', $scope.selectedTimeLevel.value, '&geographyLevel=', $scope.selectedGeographyLevel.value, '&ageLevel=', groupAge, '&genderLevel=', groupGender, '&start=0&limit=100');
          return queryString;
      };

      $scope.setHiddenFields = function () {
          $('#subjectIdRaw').val($scope.selectedSubject.value);
          $('#subjectIdSel').val($scope.selectedSubject.value);
          $('#timeLevelSel').val($scope.selectedTimeLevel.value);
          $('#geographyLevelSel').val($scope.selectedGeographyLevel.value);
          var groupAge = $scope.groupOnAge ? 1 : 0;
          var groupGender = $scope.groupOnGender ? 1 : 0;
          $('#ageLevelSel').val(groupAge);
          $('#genderLevelSel').val(groupGender);
      };
      
      $scope.performAction = function() {
          $scope.tableParamsFields.reload();
          $scope.setHiddenFields();
      };

      // Run  
      $scope.initialize();

      // TODO: this should page
      $scope.tableParamsFields = new ngTableParams({
              page: 1,             
              total: 1,
              count: 10,
              sorting: {
                  'TimeLevel': 'asc'                  
              }
            },
          {
              getData: function ($defer, params) {
                  $http.get(webApiUrl.concat('aggregateddata.php', $scope.getSelectionsAsQueryString())).success(function (response) {
                        var orderedData = params.sorting() ?
                                                    $filter('orderBy')(response.rows, params.orderBy()) :
                                                    response.rows;
                        $defer.resolve(orderedData);
                      //$defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                    });
              }
          });
  });