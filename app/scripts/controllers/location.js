'use strict';

angular.module('app')
  .controller('locationCtrl', function ($scope, $location, $routeParams, Location, Container, Item) {
  $scope.msg = null;
  $scope.error = null;
  $scope.id = null;
  $scope.title = "";
  $scope.description = "";
  
  $scope.containers = [];
  $scope.items = [];
  
  if ($routeParams.hasOwnProperty("id")) {
    $scope.id = $routeParams.id;
    Location.getOne($scope.id, function(data){
      $scope.title = data.title;
      $scope.description = data.description;
    }, function(data) {
      $scope.error = data.error;
    });
  } else {
    $scope.error = "Invalid location"
  }
  
  Container.getAll(function(data){
    for (var i in data) {
      if (data.hasOwnProperty(i)) {
        if (data[i].location == $scope.id) {
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
        if (data[i].location == $scope.id && (!data[i].container || data[i].container < 1)) {
          $scope.items.push(data[i]);
        }
      }
    }
  },function(data){
    $scope.error = data.error;
  });
  
  $scope.deleteContainer = function(id) {
    Container.delete(id, function(){
      $location.path("#/location/"+$scope.id);
    }, function(){});
  };
  
  $scope.deleteItem = function(id) {
    Item.delete(id, function(data){
      $location.path("#/location/"+$scope.id);
    }, function(){});
  };

});