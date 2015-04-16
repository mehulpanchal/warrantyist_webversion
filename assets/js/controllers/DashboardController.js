'use strict';

WarrantyistApp.controller('DashboardController', function($rootScope, $scope,Amc,Warranty,Service,LicenseFactory) {
      $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;

    $scope.$on('$viewContentLoaded', function() {           
        Service.sortalldash().success(function (data) {
            $scope.service = data;
        });
        Amc.sortalldash().success(function (data) {
            $scope.amc = data;       
        });       
        LicenseFactory.sortalldash().success(function (data) {
            $scope.licenses = data;       
        });        
        Warranty.sortalldash().success(function (data) {
            $scope.warranty = data;
        });                        
    });
});