
WarrantyistApp.controller('AmcController', function (Amc, $scope, $rootScope,$state, createDialog) {

$rootScope.settings.layout.pageAutoScrollOnLoad = 1500;

    $scope.$on('$viewContentLoaded', function () {
        Amc.getAmc().success(function (data) {
            $scope.amc = data;
        });
    });

    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
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
        angular.forEach($scope.amc, function (a, key) {
            $scope.chckedIndexs.push($scope.amc[key].amc_id);
            a.checked = $scope.selectedAll;
        });
    };
    $rootScope.deleteamc = function ()
    {
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to delete Amc?',
            backdrop: true,
            controller: 'AmcAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                     if($scope.chckedIndexs.length != 0)
                     {
                        Amc.deleteamcs($scope.chckedIndexs).success(function (data) {
                            // console.log(data);
                        }).then(function () {
                        return $timeout(function () {
                            $scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                    }
                }}

        }, {
            myVal: '',
            Wrty_Id:'',
            Edit:''
            
        });

    };

    $rootScope.addAmcView = function () {

        createDialog(BASE_URL + "/amc/addAmcView", {
            id: 'addAmc',
            title: 'Add Amc',
            backdrop: true,
            controller: 'AmcAddController',
            footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add Amc modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
        }
        , {
            myVal: 'cat',
            Wrty_Id:'',
            Edit:''
        }
        );
    };

    $rootScope.amcviewdetails = function (id) {
        createDialog(BASE_URL + "/amc/amcviewdetails", {
            id: 'amcdetails',
            title: 'Amc Details',
            backdrop: true,
            controller: 'AmcAddController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                    console.log('Amc modal closed');
                }}
        }, {
            myVal:'',
            Edit: id,
            Wrty_Id:''
        });
    };
    $rootScope.sortby = function (a)
    {
        $state.go("amc_" + a);
    };

});

WarrantyistApp.controller('AmcAddController', function ($scope, $state,Edit, myVal, Category, Amc, Wrty_Id,createDialog) {
    $scope.frm = {};
    if (myVal === 'cat')
    {
        Category.getamccat().success(function (data) {
            $scope.category = data;
        });
    }
    if (Edit !== '' )
    {
        Amc.geteditAmc(Edit).success(function (data) {
            $scope.amcdetails = data;          
        });
    }
    if(Wrty_Id !== '')
    {
        Amc.bindAmc(Wrty_Id).success(function (data) {
           // console.log(data);
            $scope.frm = data;          
        });
    }

    $scope.editAmcView = function (id)
    {
        $scope.$modalClose();
        createDialog(BASE_URL + "/amc/editAmcView", {
            id: 'editAmc',
            title: 'Edit Amc',
            backdrop: true,
            controller: 'AmcEditController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                    console.log('Edit amc modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }
            }
        },
        {
            myVal: 'cat',
            Edit: id,
            Wrty_Id:''            
        }
        );

    };
    $scope.proccesaddamc = function ()
    {        
        Amc.addAmc($.param($scope.frm)).success(function () {
            $scope.$modalClose();
            $state.reload();
        });
    };
    
    $scope.deleteamc = function (id)
    {
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to delete Amc?',
            backdrop: true,
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    Amc.deleteamcs(id).success(function (data) {
                        $scope.$modalClose();
                        $state.reload();
                    });
                }}

        });
    };
});

WarrantyistApp.controller('AmcEditController', function ($scope, $state, myVal, Edit, Amc, Category) {
    $scope.frm = {};
    if (Edit !== '')
    {
        Amc.geteditAmc(Edit).success(function (data) {
            $scope.frm = data;
        });
    }
    if (myVal === 'cat')
    {
        Category.getamccat().success(function (data) {
            $scope.category = data;
        });
    }

    $scope.editamcsave = function ()
    {
        Amc.editAmcSave($.param($scope.frm)).success(function () {
            $scope.$modalClose();
            $state.reload();
        });
    };
});

WarrantyistApp.controller('AmcSortController', function ($scope,$state, Amc,createDialog,$timeout) {

    $scope.$on('$viewContentLoaded', function () {
        $scope.sortval='status';
        Amc.statussort().success(function (data) {
            $scope.amcexpired = data.expired;
            $scope.amcexpiring = data.expiring;
            $scope.amcactive = data.active;
        });
    });
    
    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
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
            $scope.chckedIndexs.length = 0;
        }
        angular.forEach($scope.amcexpired, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.amcexpired[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
        angular.forEach($scope.amcexpiring, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.amcexpiring[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
        angular.forEach($scope.amcactive, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.amcactive[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
    };
      $scope.deleteamc = function ()
    {
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to delete Amc?',
            backdrop: true,
            controller: 'AmcAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    if($scope.chckedIndexs.length !== 0)
                     {
                        Amc.deleteamcs($scope.chckedIndexs).success(function (data) {
                            // console.log(data);
                        }).then(function () {
                        return $timeout(function () {
                            $scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                    }          
                }}

        }, {
            myVal: '',
            Wrty_Id:'',
            Edit:''
            
        });

    };

});

WarrantyistApp.controller('AmcSortCatController', function ($scope,$state, Amc,createDialog,$timeout) {

    
    $scope.$on('$viewContentLoaded', function () {
        $scope.sortval='category';
        Amc.categorysort().success(function (data) {
            $scope.amccat = data;            
        });
    });

    $scope.deleteamc = function ()
    {
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to delete Amc?',
            backdrop: true,
            controller: 'AmcAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    if($scope.chckedIndexs.length !== 0)
                     {
                        Amc.deleteamcs($scope.chckedIndexs).success(function (data) {
                            // console.log(data);
                        }).then(function () {
                        return $timeout(function () {
                            $scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                    }          
                }}

        }, {
            myVal: '',
            Wrty_Id:'',
            Edit:''
            
        });

    };

    
    
    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
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
             $scope.chckedIndexs.length = 0;
        }
         
       angular.forEach($scope.amccat, function (ab, keyab) {         
            angular.forEach(ab, function (pr, key) {                
               $scope.chckedIndexs.push(ab[key].product_id);
                pr.checked = $scope.selectedAll;
            });
            });
          };    
        
   
});