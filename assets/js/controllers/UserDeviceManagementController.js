'use strict';
WarrantyistApp.controller('UserDeviceManagementController', function ($rootScope, $state, $scope, $http, ProfileAccount, $timeout) {
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.editaccountdetails = {};
    $scope.$on('$viewContentLoaded', function () {
        ProfileAccount.getUserDevicesForManage().success(function (data) {
            console.log(data);
            if (data.active !== false) {
                
                $scope.row = data.alldevices;
            } else {
                $scope.devicenotfound = true;
            }
        });
    });

    /*********Manage Device Mamagement start ***************/
    $scope.isDisabled = {};
    $scope.isDisabledUn = {};
    $scope.loading = false;
    $scope.forgetdevice = function (id, $index) {
        //alert($index);
        $scope.loading[$index] = true;
        var ForgetDeviceParams = {forgetid: id};
        $http({
            method: 'POST',
            url: BASE_URL + "/profile/change_deviceto_forget",
            data: ForgetDeviceParams,
        }).success(function (responsedata) {
            $scope.responsedataDetails = responsedata;
            if ($scope.responsedataDetails.status === true) {
                $scope.isDisabled[id] = true;
            }
        });
    };
    $scope.unforgetdevice = function (id) {
        var UnForgetDeviceParams = {forgetid: id};
        $http({
            method: 'POST',
            url: BASE_URL + "/profile/change_deviceto_unforget",
            data: UnForgetDeviceParams,
        }).success(function (responsedata) {
            $scope.responsedataDetails = responsedata;
            if ($scope.responsedataDetails.status === true) {
                $scope.isDisabledUn[id] = true;
            }
        });
    };

});



