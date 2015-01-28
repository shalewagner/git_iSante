/// <reference path="runindicatorscontroller.js" />
appControllers.controller('RunIndicatorsCtrl',
  function ($scope, $routeParams, $http, webApiUrl, ngTableParams) {
      var salt = httpHelper.getUniqueIdentifier();
      $http({
              method: 'GET',
              url: webApiUrl.concat('userindicator.php?subjectid=1&useridentifier=User+1&includeshared=true&salt=' + salt),
              cache: false
          }).success(function (data) {
              $scope.userIndicators = data.userIndicators;
          });

      $scope.subjectName = 'Malaria';
      $scope.subjectId = 1;
      $scope.userIdentifier = "User 1";
      $scope.userIndicators = [];
      $scope.selectedUserIndicators = [];
      $scope.timeLevels = lookups.timeLevelsForRunIndicators;
      $scope.selectedTimeLevel = lookups.timeLevelsForRunIndicators[0];
      $scope.geographyLevels = lookups.geographyLevels;
      $scope.selectedGeographyLevel = lookups.geographyLevels[0];
      
      $scope.indicators = [];
      $scope.interval0Name = "2005";
      $scope.interval1Name = "2006";
      $scope.interval2Name = "2007";
      $scope.interval3Name = "2008";
      $scope.interval4Name = "2009";
      $scope.interval5Name = "2010";
      $scope.interval6Name = "2011";
      $scope.interval7Name = "2012";
      $scope.interval8Name = "2013";
      $scope.interval9Name = "2014";

      $scope.processForm = function () {          
          $scope.tableParamsData.reload();
      };
      
      $scope.tableParamsData = new ngTableParams({
          page: 1,
          count: 1,
          total: 1,
      },
      {
        counts: [],
        getData: function ($defer, params) {
            if ($scope.selectedUserIndicators.length == 0) {
                $defer.resolve([]);
                return;
            }
            var obj = indicatorHelper.createQueryRequestObject($scope.selectedUserIndicators, $scope.selectedTimeLevel.value,$scope.selectedGeographyLevel.value);
            var request = "requestJson=" + obj;

            $http({
                method: 'POST',
                url: webApiUrl.concat('query.php'),
                data: request,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                cache: false
            }).success(function (data) {
               params.total = data.rows.length;
               $defer.resolve(data.rows);
            });
        }        
      });
  });
