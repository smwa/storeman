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
      .when('/container/:id', {
          templateUrl: 'views/container.html',
          controller: 'containerCtrl'
      })
      .when('/container/edit/:id', {
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
  });
