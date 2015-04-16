'use strict';
WarrantyistApp.controller('UserContactInformationController', function ($rootScope, $state, $scope, $http, ProfileAccount, $timeout) {
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.formData = {};
    $scope.$on('$viewContentLoaded', function () {
        ProfileAccount.getProfileAccountDetails().success(function (data) {
            if (data.active !== false) {
                $scope.formData = data.active;
                $scope.companyAddressscope = data.active.companyaddress;
            } else {
                //  $scope.row = {contactpersonname: '', companyname: '', companywebsite: '', companyaddress: '', companyemail: ''};
            }
        });
    });

    /*********Change Account Detail start ***************/
    $scope.companydetailsupdate = function (formValid) {
        var EditCompanyDetails = {contactpersonname: $scope.formData.contactpersonname, companyname: $scope.formData.companyname, companywebsite: $scope.formData.companywebsite, companyaddress: $scope.formData.companyaddress, companyemail: $scope.formData.companyemail, action: 'contactinfo'};
        if (formValid === true) {
            $scope.loadingtillresponse = true;
            $http({
                method: 'POST',
                url: BASE_URL + "/profile/change_account_details",
                data: EditCompanyDetails,
            }).success(function (responsedata) {
                $scope.responsedataDetails = responsedata;
                if ($scope.responsedataDetails.status === true) {
                    $scope.showContactInfoSuccessMsg = true;
                    $scope.loadingtillresponse = false;
                    $timeout(function () {
                        $scope.showContactInfoSuccessMsg = false;
                    }, 3000);
                }
            });
        }
    };

});



