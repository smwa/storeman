'use strict';

angular.module('app')
  .controller('locationeditCtrl', function ($scope, $route, $location, $routeParams, Location) {
  $scope.msg = null;
  $scope.error = null;
  $scope.id = null;
  $scope.title = "";
  $scope.description = "";
  
  if ($routeParams.hasOwnProperty("id")) {
    $scope.id = $routeParams.id;
    Location.getOne($scope.id, function(data){
      $scope.title = data.title;
      $scope.description = data.description;
    }, function(data) {
      $scope.error = data.error;
    });
  }
  
  $scope.save = function() {
    if ($scope.id) {
      //put
      Location.update($scope.id, $scope.title, $scope.description, function(data){
        //success
        $scope.msg = "Location updated";
        $route.reload();
      }, function(data) {
        //error
        $scope.error = data.error;
      });
    } else {
      //post
      Location.create($scope.title, $scope.description, function(data){
        //success
        $scope.msg = "Location created";
        $location.path("/location/"+data.id);
      }, function(data) {
        //error
        $scope.error = data.error;
      });
    }
  }
  
});