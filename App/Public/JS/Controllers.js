'use strict';

/* Controllers */

var uControllers = angular.module('Controllers', []);

uControllers.controller('Test', function($scope, Test) {
    $scope.test = function(name) {
        $scope.tests = Test.get();

        l($scope.tests);
    }
});

uControllers.controller('Test2', function($scope) {

});
