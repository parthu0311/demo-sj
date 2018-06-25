'use strict';

/**
 * @ngdoc service
 * @name app.ApiService
 * @description
 * # ApiService
 * Factory in the app.
 */
angular.module('app')
    .factory('ApiService', function (api, ApiEndpoint) {

        var getModel = function (url_part)
        {
            var url = ApiEndpoint.getUrl(ApiEndpoint.URLS.QUERY) + url_part;
            return api.get(url);
        };

        var getModelViaPost = function (url_part, data)
        {
            var url = ApiEndpoint.getUrl(ApiEndpoint.URLS.QUERY) + url_part;
            return api.post(url, data);
        };

        var postModel = function(model_name, data) {
            var url = ApiEndpoint.getUrl(ApiEndpoint.URLS.QUERY) + model_name;
            return api.post(url, data);
        };

        var putModel = function(model_name, data) {
            var url = ApiEndpoint.getUrl(ApiEndpoint.URLS.QUERY) + model_name;
            return api.put(url, data);
        };

        var deleteModel = function(model_name, id) {
            var url = ApiEndpoint.getUrl(ApiEndpoint.URLS.QUERY) + model_name + '/' + id;
            return api.delete(url);
        };



        return {
            getModel: getModel,
            postModel : postModel,
            putModel : putModel,
            deleteModel : deleteModel,
            getModelViaPost : getModelViaPost
        };

    });