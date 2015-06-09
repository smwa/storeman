'use strict';

angular.module('app')
  .controller('mainCtrl', function ($scope, User, $route, $location, Location, Container, Item, $timeout) {
  $scope.locations = [];
  $scope.containers = [];
  $scope.items = [];
  $scope.msg = null;
  $scope.error = null;
  $scope.helper = false;
  $scope.notLoggedInTimeout = null;
  
  User.requireLoginLanding(function(){
    if ($scope.notLoggedInTimeout !== null) {
      $timeout.cancel($scope.notLoggedInTimeout);
      $scope.notLoggedInTimeout = null;
    }
  });

  $scope.deleteLocation = function(id) {
    Location.delete(id, function(data){
      $route.reload();
    }, function(data){
      $scope.error = data.error;
    });
  };
  
  $scope.deleteContainer = function(id) {
    Container.delete(id, function(data){
      $route.reload();
    }, function(data){
      $scope.error = data.error;
    });
  };
  
  $scope.deleteItem = function(id) {
    Item.delete(id, function(data){
      $route.reload();
    }, function(data){
      $scope.error = data.error;
    });
  };
  
  Location.getAll(function(data) {
    $scope.locations = data
  }, function(data){
    $scope.error = data.error;
  });
  
  Container.getAll(function(data){
    for (var i in data) {
      if (data.hasOwnProperty(i)) {
        if (!data[i].location || parseInt(data[i].location,10) < 1) {
          $scope.containers.push(data[i]);
        }
      }
    }
  },function(data){
    $scope.error = data.error;
  });
  
  Item.getAll(function(data){
    for (var i in data) {
      if (data.hasOwnProperty(i)) {
        if ((!data[i].location || parseInt(data[i].location,10) < 1) && (!data[i].container || parseInt(data[i].container,10) < 1)) {
          $scope.items.push(data[i]);
        }
      }
    }
  },function(data){
    $scope.error = data.error;
  });
  
  //give the user a few seconds before checking the helper
  $scope.notLoggedInTimeout = $timeout(function(){
    if ($scope.containers.length < 1 && $scope.items.length < 1 && $scope.locations.length < 1) {
      $scope.helper = true;
    }
  },2500);
  
});