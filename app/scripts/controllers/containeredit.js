'use strict';

angular.module('app')
  .controller('containereditCtrl', function ($scope, $location, $routeParams, Location, Container) {
  $scope.msg = null;
  $scope.error = null;
  $scope.id = null;
  $scope.title = "";
  $scope.location = 0;
  
  $scope.locations = [{id:0, title: "No Location"}];
  $scope.locationsSelected = 0;
  
  $scope.locationClick = function(index, loc, $event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.locationsSelected = index;
    $scope.location = loc;
  };
  
  if ($routeParams.hasOwnProperty("id")) {
    $scope.id = $routeParams.id;
    Container.getOne($scope.id, function(data){
      $scope.title = data.title;
      $scope.location = data.location;
    }, function(data) {
      $scope.error = data.error;
    });
  }
  
  setTimeout(function(){
    Location.getAll(function(data){
      for (var i in data) {
        $scope.locations.push(data[i]);
        if (data[i].id == $scope.location) {
          $scope.locationsSelected = parseInt(i,10)+1;
        }
      }
    }, function(data){});
  }, 250);
  
  $scope.save = function() {
    if ($scope.id) {
      //put
      Container.update($scope.id, $scope.title, $scope.location, function(data){
        //success
        $scope.msg = "Container updated";
        $location.path("/container/"+$scope.id);
      }, function(data) {
        //error
        $scope.error = data.error;
      });
    } else {
      //post
      Container.create($scope.title, $scope.location, function(data){
        //success
        $scope.msg = "Container created";
        $location.path("/container/"+data.id);
      }, function(data) {
        //error
        $scope.error = data.error;
      });
    }
  }

});