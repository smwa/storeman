'use strict';

angular.module('app')
  .controller('itemeditCtrl', function ($scope, $route, $location, $routeParams, Location, Container, Item, Image, User) {
  $scope.msg = null;
  $scope.error = null;
  $scope.id = null;
  $scope.title = "";
  
  User.requireLogIn();
  
  $scope.originallocation = 0;
  $scope.originalcontainer = 0;
  
  $scope.location = 0;
  $scope.locations = [{id:0, title: "No Location"}];
  $scope.locationsSelected = 0;
  
  $scope.container = 0;
  $scope.containers = [{id:0, title: "No Container"}];
  $scope.containersSelected = 0;
  
  $scope.locationClick = function(index, loc, $event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.locationsSelected = index;
    $scope.location = loc;
    $scope.containersSelected = 0;
    $scope.container = 0;
  };
  
  $scope.containerClick = function(index, loc, $event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.location = 0;
    $scope.locationsSelected = 0;
    $scope.containersSelected = index;
    $scope.container = loc;
  };
  
  if ($routeParams.hasOwnProperty("id")) {
    $scope.id = $routeParams.id;
    Item.getOne($scope.id, function(data){
      $scope.title = data.title;
      $scope.location = data.location;
      $scope.container = data.container;
      $scope.originalcontainer = data.container;
      $scope.originallocation = data.location;
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
    
    Container.getAll(function(data){
      for (var i in data) {
        $scope.containers.push(data[i]);
        if (data[i].id == $scope.container) {
          $scope.containersSelected = parseInt(i,10)+1;
        }
      }
    }, function(data){});
    
  }, 500);
  
  $scope.save = function() {
    $scope.originalcontainer = $scope.container;
    $scope.originallocation = $scope.location;
    if ($scope.id) {
      //put
      Item.update($scope.id, $scope.title, $scope.location, $scope.container, function(data){
        //success
        $scope.msg = "Item updated";
        $route.reload();
      }, function(data) {
        //error
        $scope.error = data.error;
      });
    } else {
      //post
      Item.create($scope.title, $scope.location, $scope.container, function(data){
        //success
        $scope.msg = "Item created";
        $location.path("/item/"+data.id);
      }, function(data) {
        //error
        $scope.error = data.error;
      });
    }
  }
  
  $scope.imageupload = function(files) {
    if (files.length) {
      Image.uploaditemimage($scope.id, files[0], function(data){
        $route.reload();
      });
    }
  };

});