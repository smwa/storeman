'use strict';

angular.module('app')
  .controller('headerCtrl', function ($scope, $timeout, User, $location) {
  
  $scope.isloggedin = function() {
    return User.isLoggedInVar;
  };
  
    $scope.logout = function() {
      User.logOut();
      $timeout(function() {
        $location.path("#/landing");
      },250);
    };
  User.isLoggedIn();
});