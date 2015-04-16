'use strict';
WarrantyistApp.controller('UserManagementController', function ($rootScope, $state, $scope, $http, ProfileAccount, $timeout, createDialog) {
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.EmailExpression = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;
    $scope.inviteUserForm = {};
    $scope.$on('$viewContentLoaded', function () {
        ProfileAccount.getUserForManage().success(function (data) {
            console.log(data);
            if (data.active !== false) {
                $scope.row = data.users_data;
            } else {
                $scope.usersnotfound = true;
            }
        });
    });
    /*********launch invite use model start***********/
    $scope.LaunchInviteUserModal = function () {
        createDialog(BASE_URL + "/profile/get_invite_user_form", {
            id: 'ViewInviteUser',
            title: 'Invite A User',
            backdrop: true,
            controller: 'InviteUserActionController',
            footerTemplate: false,
            success: {label: 'Success', fn: function () {
                    console.log('Complex modal closed');
                }}
        }, {Editid: ''}
        );
    };
    /*********launch access role edit model start***********/
    $scope.LaunchAccessLevelModal = function (id) {
        // alert(id);
        createDialog(BASE_URL + "/profile/get_access_role_edit_form", {
            id: 'ViewAccessLevelEdit',
            title: 'Change Access Level',
            backdrop: true,
            controller: 'InviteUserActionController',
            footerTemplate: false,
            success: {label: 'Success', fn: function () {
                    console.log('Complex modal closed');
                }}
        }, {Editid: id}
        );
    };
    /********Set User To Deactiveated Mode *************/
    $scope.setUsertoDeactive = function (id) {
        $scope.loadingtillresponse = true;
        var ChangeUserAccessRoleParams = {user_id: id, role: '4'};
        $http({
            method: 'POST',
            url: BASE_URL + "/profile/change_user_access_role",
            data: ChangeUserAccessRoleParams,
        }).success(function (responsedata) {
            $scope.responsedataDetails = responsedata;
            if ($scope.responsedataDetails.status === true) {

                //$scope.showSubmittedPromptWhenbasic = true;
                $scope.message = responsedata.message;
                // $scope.loadingtillresponse = false;
                $state.go('profile/usermanagement'.destination);
                $state.reload();
            } else {
                $scope.message = responsedata.message;
                // $scope.loadingtillresponse = false;
            }
        });
    };
});

/* Invite User Action Controller Start */
WarrantyistApp.controller('InviteUserActionController', function ($scope, $http, $state, ProfileAccount, Editid) {
    $scope.inviteUserFormData = {};
    
    /*********Send Invitation to User start ***************/
    $scope.inviteusersubmit = function (formValid) {
       
        var SendInvitationParams = {name: $scope.inviteUserFormData.name, email: $scope.inviteUserFormData.Myemail, role: $scope.inviteUserFormData.role};
        if (formValid === true) {
            $scope.loadingtillresponse = true;
            $http({
                method: 'POST',
                url: BASE_URL + "/profile/send_invitation_to_user",
                data: SendInvitationParams,
            }).success(function (responsedata) {
                $scope.responsedataDetails = responsedata;
                if ($scope.responsedataDetails.status === true) {
                    //$scope.showSubmittedPromptWhenbasic = true;
                    $scope.message = responsedata.message;
                    $scope.loadingtillresponse = false;
                    $scope.$modalClose();
                    $state.reload();
                } else {
                    $scope.message = responsedata.message;
                    $scope.loadingtillresponse = false;
                }
            });
        }
    };

    /**********Get Access Edit Data Started ***************/
    if (Editid !== '')
    {
        ProfileAccount.getUserDataForChangeRole(Editid).success(function (data) {
            $scope.inviteUserFormData = data.active;
        });
    }

    $scope.update_role_submit = function () {
        $scope.loadingtillresponse = true;
        var ChangeUserAccessRoleParams = {user_id: $scope.inviteUserFormData.user_id, role: $scope.inviteUserFormData.role};
        // if ($scope.inviteUserFormData.$valid) {
        $http({
            method: 'POST',
            url: BASE_URL + "/profile/change_user_access_role",
            data: ChangeUserAccessRoleParams,
        }).success(function (responsedata) {
            $scope.responsedataDetails = responsedata;
            if ($scope.responsedataDetails.status === true) {
                //$scope.showSubmittedPromptWhenbasic = true;
//                $scope.message = responsedata.message;
                $scope.loadingtillresponse = false;
                $scope.$modalClose();
                $state.reload();
            } else {
                $scope.message = responsedata.message;
                $scope.loadingtillresponse = false;
            }
        });
        //clearForm();
        // }
    };

});



