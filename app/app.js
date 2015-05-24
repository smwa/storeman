angular
  .module('app', [
    'ngRoute',
    'monospaced.qrcode'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
          templateUrl: 'views/main.html',
          controller: 'mainCtrl'
      })
      .when('/landing', {
          templateUrl: 'views/landing.html'
      })
      .when('/login', {
          templateUrl: 'views/loginregister.html',
          controller: 'loginregisterCtrl'
      })
    
      .when('/location/qr/:id', {
          templateUrl: 'views/qr.html',
          controller: 'qrCtrl'
      })
      .when('/location/edit/:id', {
          templateUrl: 'views/locationedit.html',
          controller: 'locationeditCtrl'
      })
      .when('/location/edit', {
          templateUrl: 'views/locationedit.html',
          controller: 'locationeditCtrl'
      })
      .when('/location/:id', {
          templateUrl: 'views/location.html',
          controller: 'locationCtrl'
      })
    
    
      .when('/container/qr/:id', {
          templateUrl: 'views/qr.html',
          controller: 'qrCtrl'
      })
      .when('/container/edit/:id', {
          templateUrl: 'views/containeredit.html',
          controller: 'containereditCtrl'
      })
      .when('/container/edit', {
          templateUrl: 'views/containeredit.html',
          controller: 'containereditCtrl'
      })
      .when('/container/:id', {
          templateUrl: 'views/container.html',
          controller: 'containerCtrl'
      })
    
      .when('/item/edit', {
          templateUrl: 'views/itemedit.html',
          controller: 'itemeditCtrl'
      })
      .when('/item/qr/:id', {
          templateUrl: 'views/qr.html',
          controller: 'qrCtrl'
      })
      .when('/item/:id', {
          templateUrl: 'views/itemedit.html',
          controller: 'itemeditCtrl'
      })
      
      .otherwise({
          redirectTo: '/'
      });
  })
 
.directive('locationList', function() {
  return {
    template: '<div class="list-group" ng-hide="locations.length"><div class="list-group-item clearfix">There are no locations available</div></div>  <div ng-show="locations.length" class="list-group"><div ng-class="{active: $index == locationsSelected}" ng-click="locationClick($index, loc.id, $event)" class="list-group-item clearfix" ng-repeat="loc in locations"><a class="col-sm-10" ng-href="#/location/{{loc.id}}">{{loc.title}}</a><div class="col-sm-2"><button ng-hide="locationsSelected != undefined" ng-click="deleteLocation(loc.id)" class="btn btn-primary btn-sm pull-right">Delete</button></div></div></div>'
  };
})
.directive('containerList', function() {
  return {
    template: '<div ng-hide="containers.length" class="list-group"><div class="list-group-item clearfix">There are no containers available</div></div><div ng-show="containers.length" class="list-group"><div ng-class="{active: $index == containersSelected}" class="list-group-item clearfix" ng-click="containerClick($index, loc.id, $event)" ng-repeat="loc in containers"><a class="col-sm-10" ng-href="#/container/{{loc.id}}">{{loc.title}}</a><div class="col-sm-2"><button ng-hide="containersSelected != undefined" ng-click="deleteContainer(loc.id)" class="btn btn-primary btn-sm pull-right">Delete</button></div></div></div>'
  };
})
.directive('itemList', function() {
  return {
    template: '<div class="list-group" ng-hide="items.length"><div class="list-group-item clearfix" ng-hide="items.length">There are no items available</div></div>  <div class="list-group" ng-show="items.length"><div ng-class="{active: $index == itemsSelected}" ng-click="itemClick($index, loc.id, $event)" class="list-group-item clearfix" ng-repeat="loc in items"><a class="col-sm-10" ng-href="#/item/{{loc.id}}">{{loc.title}}</a><div class="col-sm-2"><button ng-hide="itemsSelected != undefined" ng-click="deleteItem(loc.id)" class="btn btn-primary btn-sm pull-right">Delete</button></div></div></div>'
  };
});
