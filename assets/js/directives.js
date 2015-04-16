/***
 GLobal Directives
 ***/

// Route State Load Spinner(used on page or content load)
WarrantyistApp.directive('ngSpinnerBar', ['$rootScope',
    function ($rootScope) {
        return {
            link: function (scope, element, attrs) {
                // by defult hide the spinner bar
                element.addClass('hide'); // hide spinner bar by default

                // display the spinner bar whenever the route changes(the content part started loading)
                $rootScope.$on('$stateChangeStart', function () {
                    element.removeClass('hide'); // show spinner bar
                    Layout.closeMainMenu();
                });

                // hide the spinner bar on rounte change success(after the content loaded)
                $rootScope.$on('$stateChangeSuccess', function () {
                    element.addClass('hide'); // hide spinner bar
                    $('body').removeClass('page-on-load'); // remove page loading indicator
                    Layout.setMainMenuActiveLink('match'); // activate selected link in the sidebar menu

                    // auto scorll to page top
                    setTimeout(function () {
                        Metronic.scrollTop(); // scroll to the top on content load
                    }, $rootScope.settings.layout.pageAutoScrollOnLoad);
                });

                // handle errors
                $rootScope.$on('$stateNotFound', function () {
                    element.addClass('hide'); // hide spinner bar
                });

                // handle errors
                $rootScope.$on('$stateChangeError', function () {
                    element.addClass('hide'); // hide spinner bar
                });
            }
        };
    }
])

// Handle global LINK click
WarrantyistApp.directive('a',
        function () {
            return {
                restrict: 'E',
                link: function (scope, elem, attrs) {
                    if (attrs.ngClick || attrs.href === '' || attrs.href === '#') {
                        elem.on('click', function (e) {
                            e.preventDefault(); // prevent link click for above criteria
                        });
                    }
                }
            };
        });

// Handle Dropdown Hover Plugin Integration
WarrantyistApp.directive('dropdownMenuHover', function () {
    return {
        link: function (scope, elem) {
            elem.dropdownHover();
        }
    };
});

WarrantyistApp.directive('datepickerPopup', function () {
    return {
        restrict: 'EAC',
        require: 'ngModel',
        link: function (scope, element, attr, controller) {
            //remove the default formatter from the input directive to prevent conflict             
            controller.$parsers.push(function (modelValue) {
                var date = new Date(modelValue).toUTCString();
                return date;
            });
            // controller.$formatters.shift();
        }
    };
});

WarrantyistApp.directive('validPasswordC', function () {
    return {
        restrict: 'EAC',
        require: 'ngModel',
        link: function (scope, elm, attrs, ctrl) {
            ctrl.$parsers.push(function (viewValue) {
                var noMatch = viewValue !== scope.editpasswordprofile.new_password.$viewValue;
                ctrl.$setValidity('noMatch', !noMatch);
            })
        }
    }
});
