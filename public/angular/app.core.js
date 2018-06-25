'use strict';
angular.module('app', [
    'ngSanitize',
    'ngResource',
    'ngStorage'

])
    .config(function( $locationProvider,$compileProvider,$interpolateProvider){
        //$tooltipProvider.options({animation: false});
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    })

    .run(function($rootScope,$window) {

        var d = new Date();

    });