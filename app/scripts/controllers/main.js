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
    
  };
  
  $scope.deleteContainer = function(id) {
    
  };
  
  $scope.deleteItem = function(id) {
    
  };
  
  Location.getAll(function(data) {
    $scope.locations = data
  }, function(data){
    $scope.error = data.error;
  });
  
  Container.getAll(function(data){
    for (var i in data) {
      if (data.hasOwnProperty(i)) {
        if (!data[i].location) {
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
        if (!data[i].location && !data[i].container) {
          $scope.containers.push(data[i]);
        }
      }
    }
  },function(data){
    $scope.error = data.error;
  });
  
});