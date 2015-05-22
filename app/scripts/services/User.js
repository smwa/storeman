'use strict';

angular.module('app')
  .service('User', function ($http) {
    this.isLoggedInVar = false;
  
    this.isLoggedIn = function (successfunc, errorfunc) {
      var t = this;
      $http.get("api/?users", {params: {}})
        .success(function (data, status, headers, config) { if (successfunc) successfunc(data); t.isLoggedInVar = true; })
        .error(function (data, status, headers, config) { if (errorfunc) errorfunc(data); t.isLoggedInVar = false; });
    };
  
    this.logIn = function (email, password, successfunc, errorfunc) {
      var t = this;
      $http.post("api/?sessions", {email: email, password: password})
        .success(function (data, status, headers, config) {
          successfunc(data);
          t.isLoggedInVar = true;
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
    this.logOut = function () {
      $http.delete("api/?sessions", {data: {}});
      this.isLoggedInVar = false;
    };
  
  this.changePassword = function(oldpassword, password, successfunc, errorfunc) {
    $http.put("api/?users", {oldpassword: oldpassword, password:password})
    .success(function(data,status,headers,config){
        successfunc(data);
    }).error(function(data,status,headers,config){
        errorfunc(data);
    });
  };
  
  this.deleteUser = function(password, successfunc, errorfunc) {
    $http.delete("api/?sessions", {data: {}})
    .success(function(data,status,headers,config) {
        successfunc(data);
    })
    .error(function(data,status,headers,config) {
        errorfunc(data);
    });
  }
  
  this.createUser = function(email, password, successfunc, errorfunc) {
    $http.post("api/?users", {email: email, password: password})
    .success(function(data,status,headers,config) {
        successfunc(data);
    })
    .error(function(data,status,headers,config) {
        errorfunc(data);
    });
  };
});