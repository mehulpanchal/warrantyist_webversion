'use strict';
WarrantyistApp.controller('UserAccountDetailsController', function ($rootScope, $state, $scope, $http, ProfileAccount, $timeout) {
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.editaccountdetails = {};
    $scope.$on('$viewContentLoaded', function () {
        ProfileAccount.getProfileAccountDetails().success(function (data) {
            if (data.active !== false) {
                $scope.row = data.active;
            } else {
                $scope.row = {accountname: '', timezone: '', dateformate: '', typeofcompany: '', peoplesincompany: '', howoldcompany: ''};
            }
        });
    });

    /*********Change Account Detail start ***************/
    $scope.editaccountdetailsupdate = function () {
        var EditaccountDetails = {accountname: $scope.row.accountname, timezone: $scope.row.timezone, dateformate: $scope.row.dateformate, typeofcompany: $scope.row.typeofcompany, peoplesincompany: $scope.row.peoplesincompany, howoldcompany: $scope.row.howoldcompany, action: ''};
        $http({
            method: 'POST',
            url: BASE_URL + "/profile/change_account_details",
            data: EditaccountDetails,
        }).success(function (responsedata) {
            $scope.responsedataDetails = responsedata;
            if ($scope.responsedataDetails.status === true) {
                $scope.ShowSuccessMessageInAccountDetails = true;
                $timeout(function () {
                    $scope.ShowSuccessMessageInAccountDetails = false;
                }, 3000);
            }
        });
    };

});



