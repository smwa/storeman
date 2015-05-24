'use strict';

angular.module('app')
  .controller('containerCtrl', function ($scope, $location, $routeParams, Container, Item, Location) {
  $scope.msg = null;
  $scope.error = null;
  $scope.id = null;
  $scope.title = "";
  $scope.location = null;
  $scope.items = [];
  
  if ($routeParams.hasOwnProperty("id")) {
    $scope.id = $routeParams.id;
    Container.getOne($scope.id, function(data){
      $scope.title = data.title;
      $scope.location = {id: data.location};
      Location.getOne($scope.location.id, function(data){
        $scope.location = data;
      }, function(data){})
    }, function(data) {
      $scope.error = data.error;
    });
  } else {
    $scope.error = "Invalid container"
  }
  
  Item.getAll(function(data){
    for (var i in data) {
      if (data.hasOwnProperty(i)) {
        if (data[i].container == $scope.id) {
          $scope.items.push(data[i]);
        }
      }
    }
  },function(data){
    $scope.error = data.error;
  });
  
  
  $scope.deleteItem = function(id) {
    Item.delete(id, function(data){
      $location.path("#/container/"+$scope.id);
    }, function(){});
  };

});