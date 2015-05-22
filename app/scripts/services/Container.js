'use strict';

angular.module('app')
  .service('Container', function ($http) {
  
    this.getAll = function (successfunc, errorfunc) {
      $http.get("api/?containers", {params: {}})
        .success(function (data, status, headers, config) { successfunc(data); })
        .error(function (data, status, headers, config) { errorfunc(data); });
    };
  
    this.getOne = function (id, successfunc, errorfunc) {
      $http.get("api/?containers/"+id, {params: {}})
        .success(function (data, status, headers, config) { successfunc(data); })
        .error(function (data, status, headers, config) { errorfunc(data); });
    };
  
    this.create = function (title, location, successfunc, errorfunc) {
      $http.post("api/?containers", {title: title, location: location})
        .success(function (data, status, headers, config) {
          successfunc(data);
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
    this.delete = function (id, successfunc, errorfunc) {
      $http.delete("api/?containers/"+id, {data: {}})
        .success(function (data, status, headers, config) {
          successfunc(data);
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
  this.update = function(id, title, location, successfunc, errorfunc) {
    $http.put("api/?containers/"+id, {title: title, location:location})
    .success(function(data,status,headers,config){
        successfunc(data);
    }).error(function(data,status,headers,config){
        errorfunc(data);
    });
  };
});