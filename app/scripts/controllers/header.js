'use strict';

angular.module('app')
  .controller('headerCtrl', function ($scope, $interval, User, $location) {
  
  $scope.isloggedin = function() {
    return User.isLoggedInVar;
  };
  
    $scope.logout = function() {
      User.logOut();
	  $location.path("#/landing");
    };
  User.isLoggedIn();
});