'use strict';

angular.module('app')
    .constant('ApiEndpoint', {
        ServerUrl:  'http://localhost/',
        BaseUrl: 'http://localhost/',
        Methods: {GET: 'GET', POST: 'POST', PUT: 'PUT', DELETE: 'DELETE'},
        Models: {
            get_questionnaire_by_id:"admin/get_questionnaire_by_id",
            get_questionnaire_by_id_edit: "admin/get_questionnaire_by_id_edit",

        },
        URLS: {
            QUERY: 'admin/'
        },
        getUrl: function (url) {
            //alert(window.location.host);
            var host=window.location.host;
            var protocol=window.location.protocol ;
            //return protocol+"//"+"jwlbeta.jewelxy.com/"+url;
            if (host=="suril-jain.local"){
                return protocol+"//"+host+"/";
            } else if(host=="35.154.111.123"){
                return protocol+"//"+host+"/";
            }
        }
    });