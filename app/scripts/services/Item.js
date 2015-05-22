'use strict';

angular.module('app')
  .service('Item', function ($http) {
  
    this.getAll = function (successfunc, errorfunc) {
      $http.get("api/?items", {params: {}})
        .success(function (data, status, headers, config) { successfunc(data); })
        .error(function (data, status, headers, config) { errorfunc(data); });
    };
  
    this.getOne = function (id, successfunc, errorfunc) {
      $http.get("api/?items/"+id, {params: {}})
        .success(function (data, status, headers, config) { successfunc(data); })
        .error(function (data, status, headers, config) { errorfunc(data); });
    };
  
    this.create = function (title, location, container, successfunc, errorfunc) {
      $http.post("api/?items", {title: title, location: location, container: container})
        .success(function (data, status, headers, config) {
          successfunc(data);
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
    this.delete = function (id, successfunc, errorfunc) {
      $http.delete("api/?items/"+id, {data: {}})
        .success(function (data, status, headers, config) {
          successfunc(data);
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
  this.update = function(id, title, location, container, successfunc, errorfunc) {
    $http.put("api/?items/"+id, {title: title, location:location, container: container})
    .success(function(data,status,headers,config){
        successfunc(data);
    }).error(function(data,status,headers,config){
        errorfunc(data);
    });
  };
});