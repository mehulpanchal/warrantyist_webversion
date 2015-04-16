'use strict';
WarrantyistApp.controller('UserExportDataController', function ($rootScope, $state, $scope, $http, ProfileAccount, $timeout) {
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.backupform = {};
    $scope.successmessagewhenexported = false;
    $scope.loadingtillresponse = false;
    $scope.chckedIndexs = [];
    $scope.Items = [{
            Name: "All"
        }, {
            Name: "Warranties",
        }, {
            Name: "Licenses",
        }, {
            Name: "Documents",
        }, {
            Name: "AMCs",
        }, {
            Name: "Services Schedule",
        }];

    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
            //alert('single select ' + id);
            $scope.chckedIndexs.push(id);
        }
        else {
            $scope.chckedIndexs.splice($scope.chckedIndexs.indexOf(id), 1);
        }
    };
    $scope.checkAll = function () {
        if ($scope.selectedAll) {

            $scope.selectedAll = true;

        } else {
            $scope.selectedAll = false;
        }
        angular.forEach($scope.Items, function (row, key) {
            $scope.chckedIndexs.push($scope.Items[key].Name);
            row.checked = $scope.selectedAll;
        });

    };

    $scope.sendbackupoptions = function () {
        $scope.loadingtillresponse = true;
        var data = $scope.chckedIndexs;
        var ForgetDeviceParams = {};
        if ( $.inArray( 'All', data ) > -1 ){
            ForgetDeviceParams = {export: ['All']};
        }else{
            ForgetDeviceParams = {export: data};
        }
        $http({
            method: 'POST',
            url: BASE_URL + "/exportdata/data_export",
            data: ForgetDeviceParams,
        }).success(function (responsedata) {
            $scope.responsedataDetails = responsedata;
            if ($scope.responsedataDetails.status === true) {
                $scope.successmessagewhenexported = true;
                $scope.loadingtillresponse = false;
            }else{
                $scope.loadingtillresponse = false;
            }
        });
    };
});



