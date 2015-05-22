'use strict';

angular.module('app')
  .controller('mainCtrl', function ($scope, User, $location) {
    User.isLoggedIn(function(){
    
    }, function(){
      $location.path("/landing");
    });
  });