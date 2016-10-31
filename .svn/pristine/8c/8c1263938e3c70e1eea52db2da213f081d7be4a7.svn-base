
'use strict';

var AngularSpringApp = {};

var app = angular.module('AngularSpringApp', [ 
     'ngRoute',
     'ngFlash', 
     'ngAnimate',
     'validation',
     'angular-confirm',
     'ui.bootstrap'
     ]);

// Declare app level module which depends on filters, and service
app.config(['$routeProvider', function ($routeProvider) {
	// cycle type
	$routeProvider.when('/cycletype/list/:pageNumber?', {
		templateUrl : 'cycletype/list',
		controller : CycleTypeController
	});
	
	$routeProvider.when('/cycletype/detail/:id?', {
		templateUrl : 'cycletype/detail',
		controller : 'CycleTypeDetailController'
	});
	
	// service group
	$routeProvider.when('/servicegroup/list/:pageNumber?', {
		templateUrl : 'servicegroup/list',
		controller : 'ServiceGroupListController'
	});
	
	$routeProvider.when('/servicegroup/detail/:id?', {
		templateUrl : 'servicegroup/detail',
		controller : 'ServiceGroupDetailController'
	});

    //$routeProvider.otherwise({redirectTo: '/'});
}]);

