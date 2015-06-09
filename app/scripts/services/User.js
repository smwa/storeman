'use strict';

angular.module('app')
  .service('User', function ($http, $timeout, $location) {
    this.isLoggedInVar = true;
    this.waitingOnIsLoggedIn = true;
    this.prevUrl = null;
  
    this.isLoggedIn = function (successfunc, errorfunc) {
      var t = this;
      $http.get("api/?users", {params: {}})
        .success(function (data, status, headers, config) { if (successfunc) successfunc(data); t.isLoggedInVar = true; t.waitingOnIsLoggedIn = false; })
        .error(function (data, status, headers, config) { if (errorfunc) errorfunc(data); t.waitingOnIsLoggedIn = false; t.isLoggedInVar = false; });
    };
  
    this.logIn = function (email, password, successfunc, errorfunc) {
      var t = this;
      $http.post("api/?sessions", {email: email, password: password})
        .success(function (data, status, headers, config) {
          successfunc(data);
          t.isLoggedInVar = true;
          if (t.prevUrl !== null) {
            $location.url(t.prevUrl);
            t.prevUrl = null;
          }
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
  
  this.requireLoginLanding = function(f) {
    if (this.waitingOnIsLoggedIn) {
      var t = this;
      $timeout(function(){
        t.requireLoginLanding();
      },100);
    }
    if (!this.isLoggedInVar) {
      if (f) {
        f();
      }
      $location.path("/landing");
    }
  }
  
  this.requireLogIn = function(f) {
    if (this.waitingOnIsLoggedIn) {
      var t = this;
      $timeout(function(){
        t.requireLoginLanding();
      },100);
    }
    if (!this.isLoggedInVar) {
      this.prevUrl = $location.path();
      if (f) {
        f();
      }
      $location.path("/login");
    }
  };
  
  this.gotoMain = function() {
    $location.path("/");
  };
  
  this.isLoggedIn();
});