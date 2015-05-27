'use strict';

angular.module('app')
  .service('Image', function ($http, Upload) {
  
    this.deletecontainerimage = function (id, successfunc, errorfunc) {
      $http.delete("api/?containerimages/"+id, {data: {}})
        .success(function (data, status, headers, config) {
          successfunc(data);
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
  this.deleteitemimage = function (id, successfunc, errorfunc) {
      $http.delete("api/?containerimages/"+id, {data: {}})
        .success(function (data, status, headers, config) {
          successfunc(data);
        })
        .error(function (data, status, headers, config) {
          errorfunc(data);
        });
    };
  
  this.uploadcontainerimage = function (id, file, successfunc) {
    Upload.upload({
        url: 'api/?containerimages/'+id,
        fields: {},
        file: file
    }).success(function (data, status, headers, config) {
        successfunc(data);
    });
  };
  
  this.uploaditemimage = function (id, file, successfunc) {
    Upload.upload({
        url: 'api/?itemimages/'+id,
        fields: {},
        file: file
    }).success(function (data, status, headers, config) {
        successfunc(data);
    });
  };
  
});