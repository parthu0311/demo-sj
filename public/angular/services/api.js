'use strict';

/**
 * @ngdoc service
 * @name app.api
 * @description
 * # api
 * Factory in the app.
 */
angular.module('app')
    .factory('api', function ($rootScope,ApiEndpoint, $http, $q,$timeout) {


        var call = function (config)
        {

            var deffered = $q.defer();
            if (config.method === 'GET' || config.method === 'DELETE') {
                $http({
                    url: config.url,
                    method: config.method
                }).success(function (response) {
                    //console.log(response);
                    deffered.resolve(response);
                }).error(function (response) {
                    //console.log(response);
                    deffered.resolve(response);
                });
            } else {

                var deffered = $q.defer();
                $http({
                    url: config.url,
                    method: config.method,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    async: false,
                    // headers : {
                    //     'Content-Type' : 'application/json'
                    // },
                    transformRequest: function(obj) {
                        var str = [];
                        for(var p in obj)
                            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                        return str.join("&");
                    },
                    data: config.data
                }).success(function (response) {
                    //console.log(response);
                    deffered.resolve(response);
                }).error(function (response) {
                    //console.log(response);
                    deffered.resolve(response);
                });
                return deffered.promise;
            }
            return deffered.promise;
        };

        var get = function (url) {
            var config = {url: url, method: ApiEndpoint.Methods.GET};
            return this.call(config);
        };

        var del = function (url) {
            var config = {url: url, method: ApiEndpoint.Methods.DELETE};
            return this.call(config);
        };

        var post = function (url, data) {
            var config = {url: url, method: ApiEndpoint.Methods.POST, data: data};
            return this.call(config);
        };

        var put = function (url, data) {
            var config = {url: url, method: ApiEndpoint.Methods.PUT, data: data};
            return this.call(config);
        };

        return {call: call, get: get, post: post, del: del, put: put};
    });