'use strict';

angular.module('app')
  .controller('loginregisterCtrl', function ($scope, User, $location) {
  
    $scope.msg = null;
    $scope.error = null;
  
    $scope.loginemail = "";
    $scope.loginpassword = "";
    $scope.registeremail = "";
    $scope.registerpassword = "";
  
    $scope.login = function() {
      $scope.msg = null;
      $scope.error = null;
      User.logIn($scope.loginemail, $scope.loginpassword, function(data) {
        $location.path("/");
        $scope.loginemail = "";
        $scope.loginpassword = "";
      }, function(data){
       $scope.error = data.error;
      });
    };
    $scope.register = function() {
      $scope.msg = null;
      $scope.error = null;
      User.createUser($scope.registeremail, $scope.registerpassword, function(data) {
        $scope.msg = "You have been registered, you can now log in."
        $scope.registeremail = "";
        $scope.registerpassword = "";
      }, function(data){
       $scope.error = data.error;
      });
    };
  });