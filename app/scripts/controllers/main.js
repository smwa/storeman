'use strict';

angular.module('app')
  .controller('mainCtrl', function ($scope, User, $location, Location, Container, Item) {
  $scope.locations = [];
  $scope.containers = [];
  $scope.items = [];
  $scope.msg = null;
  $scope.error = null;

  User.isLoggedIn(function(){

  }, function(){
    $location.path("/landing");
  });
  
  $scope.deleteLocation = function(id) {
    Location.delete(id, function(data){
      $location.path("#/");
    }, function(data){
      $scope.error = data.error;
    });
  };
  
  $scope.deleteContainer = function(id) {
    Container.delete(id, function(data){
      $location.path("#/");
    }, function(data){
      $scope.error = data.error;
    });
  };
  
  $scope.deleteItem = function(id) {
    Item.delete(id, function(data){
      $location.path("#/");
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
  
});