'use strict';

angular.module('app')
  .controller('qrCtrl', function ($scope, $location, $routeParams) {
  $scope.id = $routeParams.id;
  $scope.data = $location.absUrl().replace("qr/","");
  
});