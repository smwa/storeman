'use strict';

angular.module('app')
  .controller('headerCtrl', function ($scope, $interval, User) {
  
  $scope.isloggedin = function() {
    return User.isLoggedInVar;
  };
  
    $scope.logout = function() {
      User.logOut();
    };
  User.isLoggedIn();
});