'use strict';

var App = angular.module('App', [
    'Controllers',
    'Services'
]);

App.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

function l(data) {
    console.log(data);
}
