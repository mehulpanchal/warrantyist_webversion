'use strict';
WarrantyistApp.controller('UserChangeProfileController', function ($rootScope, $state, $scope, $http, ProfileAccount, $timeout, FileUploader) {
    // var ctrl = this
    $scope.editprofile = {};
    $scope.editpasswordprofile = {};
    $scope.showprogressbar = false;
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.word = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;

    $scope.$on('$viewContentLoaded', function () {
        ProfileAccount.getUserprofile().success(function (data) {
            $scope.row = data.active;
        });
        ProfileAccount.getGroupUsersDataforView().success(function (data) {
            if (data.status === 1) {
                $scope.gridrow = data.users_data;
            } else {
                $scope.gridrow = data.message;
            }
        });

    });
    /******** profile image upload code *************/
    var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL + '/profile/change_profile_image'

    });
    // FILTERS
    uploader.filters.push({
        name: 'imageFilter',
        fn: function (item /*{File|FileLikeObject}*/, options) {

            var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
            var typeofindex = '|jpg|png|jpeg|bmp|gif|'.indexOf(type);

            if (typeofindex !== -1)
                $scope.isError = false;
            else
                $scope.isError = true;

            return typeofindex !== -1;
        }
    });
    // CALLBACKS
    uploader.onAfterAddingAll = function (addedFileItems) {
        $scope.editprofile.profile_image = addedFileItems[0].file.name;
    };
    uploader.onProgressAll = function (progress) {
        $scope.showprogressbar = true;
        console.info('onProgressAll', progress);
    };

    /*********basic information changed start ***************/
    $scope.basicinfochanging = function () {
        var BasicInfoChange = {username: $scope.row.username, firstname: $scope.row.firstname, lastname: $scope.row.lastname, email: $scope.row.email};
        if ($scope.editprofile.$valid) {
            $http({
                method: 'POST',
                url: BASE_URL + "/profile/change_basic_info",
                data: BasicInfoChange,
            }).success(function (responsedata) {
                $scope.responsedataDetails = responsedata;
                if ($scope.responsedataDetails.status === true) {
                    $scope.showSubmittedPromptWhenbasic = true;
                }
            });
            //clearForm();
        }
    };

    /***********generate Password ***************/
    $scope.passwordLength = 12;
    $scope.addUpper = true;
    $scope.addNumbers = true;
    $scope.addSymbols = true;
    $scope.createPassword = function () {
        var lowerCharacters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        var upperCharacters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        var numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var symbols = ['!', '"', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~'];
        var finalCharacters = lowerCharacters;
        if ($scope.addUpper) {
            finalCharacters = finalCharacters.concat(upperCharacters);
        }
        if ($scope.addNumbers) {
            finalCharacters = finalCharacters.concat(numbers);
        }
        if ($scope.addSymbols) {
            finalCharacters = finalCharacters.concat(symbols);
        }
        var passwordArray = [];
        for (var i = 1; i < $scope.passwordLength; i++) {
            passwordArray.push(finalCharacters[Math.floor(Math.random() * finalCharacters.length)]);
        }
        ;
        $scope.password = passwordArray.join("");
    };

    /*********Change Password start ***************/
    $scope.password = '';
    $scope.newpassword = '';
    $scope.confirmpassword = '';
    $scope.changepasswordsubmit = function () {
        var PasswordInfoChange = {password: $scope.editpasswordprofile.password, newpassword: $scope.editpasswordprofile.newpassword};
        if ($scope.editpasswordprofile.$valid) {
            $http({
                method: 'POST',
                url: BASE_URL + "/profile/change_password",
                data: PasswordInfoChange,
            }).success(function (responsedata) {
                $scope.responsedataDetails = responsedata;
                if ($scope.responsedataDetails.status === 'updated') {
                    $scope.showSubmittedPromptfail = false;
                    $scope.showSubmittedPromptSuccess = true;
                } else {
                    $scope.showSubmittedPromptSuccess = false;
                    $scope.showSubmittedPromptfail = true;
                }
            });
            //clearForm();
        }
    };

    /*********Change Notification start ***************/
    $scope.setnotificationsubmit = function () {
        var PasswordInfoChange = {security_notification: $scope.gridrow.security_notification, login_notification: $scope.gridrow.login_notification};
        $http({
            method: 'POST',
            url: BASE_URL + "/profile/change_notifications",
            data: PasswordInfoChange,
        }).success(function (responsedata) {
                $scope.responsedataDetails = responsedata;
                if ($scope.responsedataDetails.status === true) {
                    $scope.shownotificationmessagesuccess = true;
                }
            });
    };

});



