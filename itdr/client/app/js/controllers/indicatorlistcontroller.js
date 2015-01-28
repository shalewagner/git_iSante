/// <reference path="indicatorlistcontroller.js" />
appControllers.controller('IndicatorListCtrl',
  function ($scope, $routeParams, $http, webApiUrl, ngTableParams) {
      $scope.reset = function () {
      };

      $scope.subjectName = 'Malaria';
      $scope.subjectId = 1;
      $scope.userIdentifier = "User 1";
      $scope.indicators = [];
      
      $scope.deleteIndicator = function (userIndicatorId) {
          var obj = indicatorHelper.createDeleteIndicatorRequestObject($scope.subjectId, $scope.userIdentifier, userIndicatorId);
          var request = "requestJson=" + obj;

          // send delete to database
          $http({
              method: 'POST',
              url: webApiUrl.concat('deleteuserindicator.php'),
              data: request,
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              cache: false
          }).success(function(data) {
              $scope.tableParamsIndicators.reload();
          });
      };

      // table management
      $scope.tableParamsIndicators = new ngTableParams({
          page: 1,
          total: 1,
          count: $scope.indicators.length
      },
      {
          counts: [],
          getData: function ($defer, params) {
              var salt = httpHelper.getUniqueIdentifier();
              $http({
                  method: 'GET',
                  url: webApiUrl.concat('userindicator.php?subjectid=1&useridentifier=User+1&includeshared=true&salt=' + salt),
                  cache: false
              }).success(function (data) {
                  $scope.indicators = data.userIndicators;
                  $scope.indicators.forEach(function (element) {
                      element.equation = httpHelper.removeHttpFormatting(element.equation);
                  });

                  $defer.resolve($scope.indicators);
              });
          }
      });
  });
