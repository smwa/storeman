'use strict';

angular.module('app')
  .service('Location', function ($http) {
  
    this.getAll = function (successfunc, errorfunc) {
      $http.get("api/?locations", {params: {}})
        .success(function (data, status, headers, config) { successfunc(data); })
        .error(function (data, status, headers, config) { errorfunc(data); });
    };
  
    this.getOne = function (id, successfunc, errorfunc) {
      $http.get("api/?locations/"+id, {params: {}})
        .success(function (data, status, headers, config) { successfunc(data); })
        .error(function (data, status, headers, config) { errorfunc(data); });
    };
  
    this.create = function (title, description, successfunc, errorfunc) {
      $http.post("api/?locations", {title: title, description: description})
        .success(function (data, status, headers, config) {
          successfunc(data);
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
    this.delete = function (id, successfunc, errorfunc) {
      $http.delete("api/?locations/"+id, {data: {}})
        .success(function (data, status, headers, config) {
          successfunc(data);
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
  this.update = function(id, title, description, successfunc, errorfunc) {
    $http.put("api/?locations/"+id, {title: title, description:description})
    .success(function(data,status,headers,config){
        successfunc(data);
    }).error(function(data,status,headers,config){
        errorfunc(data);
    });
  };
});