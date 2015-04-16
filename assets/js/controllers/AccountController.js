'use strict';

WarrantyistApp.controller('AccountController', function($rootScope, $scope, $http, $timeout) {
    $scope.$on('$viewContentLoaded', function() {   
        // initialize core components
       // alert('dashboard js');
        Metronic.initAjax();
        
    });
});