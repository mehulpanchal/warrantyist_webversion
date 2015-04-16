'use strict';
WarrantyistApp.controller('UserDeactivateAccountController', function ($rootScope, $state, $scope, $http, ProfileAccount, $timeout) {
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.pauseyouraccount = {};
    var PauseAccountParams = {};
    $scope.$on('$viewContentLoaded', function () {
        ProfileAccount.getUserprofile().success(function (data) {
            $scope.formData = data.active;
        });
    });
    $scope.sendpauseoptions = function () {
        $scope.loadingtillresponse = true;
        PauseAccountParams = {checkflag: $scope.formData.deactivate};
        $http({
            method: 'POST',
            url: BASE_URL + "/profile/change_deactivated_account",
            data: PauseAccountParams,
        }).success(function (responsedata) {
            $scope.responsedataDetails = responsedata;
            if ($scope.responsedataDetails.status === true) {
                $scope.successactionfinished = true;
                $scope.loadingtillresponse = false;
            }
        });
    };
});



