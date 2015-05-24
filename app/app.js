angular
  .module('app', [
    'ngRoute'
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
      .when('/location/:id', {
          templateUrl: 'views/location.html',
          controller: 'locationCtrl'
      })
      .when('/location/edit/:id', {
          templateUrl: 'views/locationedit.html',
          controller: 'locationeditCtrl'
      })
      .when('/location/edit', {
          templateUrl: 'views/locationedit.html',
          controller: 'locationeditCtrl'
      })
      .when('/container/:id', {
          templateUrl: 'views/container.html',
          controller: 'containerCtrl'
      })
      .when('/container/edit/:id', {
          templateUrl: 'views/containeredit.html',
          controller: 'containereditCtrl'
      })
      .when('/container/edit', {
          templateUrl: 'views/containeredit.html',
          controller: 'containereditCtrl'
      })
      .when('/item/:id', {
          templateUrl: 'views/item.html',
          controller: 'itemCtrl'
      })
      .when('/item/edit/:id', {
          templateUrl: 'views/itemedit.html',
          controller: 'itemeditCtrl'
      })
      .when('/item/edit', {
          templateUrl: 'views/itemedit.html',
          controller: 'itemeditCtrl'
      })
      .when('/item/qr/:id', {
          templateUrl: 'views/itemqr.html',
          controller: 'qrCtrl'
      })
      .when('/container/qr/:id', {
          templateUrl: 'views/containerqr.html',
          controller: 'qrCtrl'
      })
      .when('/location/qr/:id', {
          templateUrl: 'views/locationqr.html',
          controller: 'qrCtrl'
      })
      .otherwise({
          redirectTo: '/'
      });
  })

.directive('locationList', function() {
  return {
    scope: {
      locations: "=locations"
    },
    template: '<div class="list-group"><div class="list-group-item clearfix" ng-hide="{{locations.length}}">There are no locations available</div><div class="list-group-item clearfix" ng-repeat="loc in locations"><a class="col-sm-10" ng-href="#/location/{{loc.id}}">{{loc.title}}</a><div class="col-sm-2"><button ng-click="deleteLocation(loc.id)" class="btn btn-primary btn-sm pull-right">Delete</button></div></div></div>'
  };
})
.directive('containerList', function() {
  return {
    scope: {
      containers: "=containers"
    },
    template: '<div class="list-group"><div class="list-group-item clearfix" ng-hide="{{containers.length}}">There are no containers available</div><div class="list-group-item clearfix" ng-repeat="loc in containers"><a class="col-sm-10" ng-href="#/container/{{loc.id}}">{{loc.title}}</a><div class="col-sm-2"><button ng-click="deleteContainer(loc.id)" class="btn btn-primary btn-sm pull-right">Delete</button></div></div></div>'
  };
})
.directive('itemList', function() {
  return {
    scope: {
      items: "=items"
    },
    template: '<div class="list-group"><div class="list-group-item clearfix" ng-hide="{{items.length}}">There are no items available</div><div class="list-group-item clearfix" ng-repeat="loc in items"><a class="col-sm-10" ng-href="#/item/{{loc.id}}">{{loc.title}}</a><div class="col-sm-2"><button ng-click="deleteItem(loc.id)" class="btn btn-primary btn-sm pull-right">Delete</button></div></div></div>'
  };
});
