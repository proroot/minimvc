'use strict';

/* Services */

var uServices = angular.module('Services', []);

uServices.factory('Test', function($http) {
    return {
        get: function() {
            return $http.put('/api', {
                test: 'api',
                test2: 'api2'
            }).then(function(response) {
                return response.data;
            });
        }
    };
});
