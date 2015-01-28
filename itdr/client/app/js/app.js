'use strict';

/* App Module */

var iSanteReportingApp = angular.module('iSanteReportingApp', [
  'ngRoute',
  'ngTable',
  'ngDraggable',  
  'appControllers'
]);

// vm
iSanteReportingApp.value("webApiUrl", "https://192.168.1.110/isante/itdr/webapi/");
iSanteReportingApp.value("baseUrl", "https://192.168.1.110/isante/itdr/client/");

iSanteReportingApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/dataoverview', {
        templateUrl: 'partials/dataoverview.html',
        controller: 'DataOverviewCtrl'
      }).
      when('/indicatorlist', {
        templateUrl: 'partials/indicatorlist.html',
        controller: 'IndicatorListCtrl'
      }).
      when('/runindicators', {
          templateUrl: 'partials/runindicators.html',
          controller: 'RunIndicatorsCtrl'
      }).
      when('/createindicators', {
          templateUrl: 'partials/createindicators.html',
          controller: 'CreateIndicatorsCtrl'
      }).
      otherwise({
        redirectTo: '/dataoverview'
      });
  }]);

iSanteReportingApp.config(['$httpProvider', function($httpProvider) {
    // disable http caching
    // TODO: This is not currently working
    $httpProvider.defaults.cache = false;
}]);

var appControllers = angular.module('appControllers', []);
