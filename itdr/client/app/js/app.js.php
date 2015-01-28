'use strict';

/* App Module */

var iSanteReportingApp = angular.module('iSanteReportingApp', [
  'ngRoute',
  'ngTable',
  'ngDraggable',  
  'appControllers'
]);

iSanteReportingApp.value("webApiUrl", "<?=substr($_SERVER['HTTP_REFERER'],0,strpos($_SERVER['HTTP_REFERER'],'client'))?>webapi/");
iSanteReportingApp.value("baseUrl", "<?=substr($_SERVER['HTTP_REFERER'],0,strpos($_SERVER['HTTP_REFERER'],'app'))?>");

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
