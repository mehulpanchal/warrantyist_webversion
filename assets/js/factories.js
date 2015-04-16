/***
 WarrantyistApp Factories
 ***/
/********** Setup global settings ***********************/
WarrantyistApp.factory('settings', ['$rootScope', function ($rootScope) {
        // supported languages
        var settings = {
            layout: {
                pageAutoScrollOnLoad: 1000 // auto scroll to top on page load
            },
            layoutImgPath: Metronic.getAssetsPath() + 'admin/layout/img/',
            layoutCssPath: Metronic.getAssetsPath() + 'admin/layout/css/'
        };
        $rootScope.settings = settings;
        return settings;
    }]);
/**********  Product Factory*******************************/
WarrantyistApp.factory("Product", function ($http) {
    var factory = {};
    factory.getWarranty = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/warranties/viewproducts',
            responseType: 'json'
        });
    };
    factory.getPagination = function (start, end) {
        return $http({
            method: 'POST',
            data: 'start=' + start + "end=" + end,
            url: BASE_URL + '/warranties/viewproducts',
            responseType: 'json'
        });
    };
    factory.getproductedit = function (pid)
    {
        return $http({
            method: 'POST',
            data: 'product_id=' + pid,
            url: BASE_URL + '/warranties/editproductview',
            responseType: 'json'
        });
    };
    factory.getproductdetails = function (pid)
    {
        return $http({
            method: 'POST',
            url: BASE_URL + '/warranties/productdetails',
            data: "pid=" + pid,
            responseType: "JSON"
        });
    };
    return factory;

});
/**********  Category Factory*******************************/
WarrantyistApp.factory("Category", function ($http) {
    var factory = {};
    factory.getcat = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/warranties/get_category',
            responseType: 'json'
        });
    };
    factory.getamccat = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/amc/get_category',
            responseType: 'json'
        });
    };
    factory.getservicecat = function ()
    {
        return $http({
            method: 'GET',
            url: BASE_URL + '/service/get_category',
            responseType: 'json'
        });
    };
    return factory;
});
/**********  Warranty Factory*******************************/
WarrantyistApp.factory("Warranty", function ($http) {
    var factory = {};

    factory.addWarranty = function (frm) {
        var url = BASE_URL + '/warranties/addWarranty';
        return $http.post(url, frm);
    };
    factory.editWarranty = function (frm) {
        var url = BASE_URL + '/warranties/editWarranty';
        return $http.post(url, frm);
    };
    factory.deleteWarranty = function (pid) {
        return $http({
            method: 'POST',
            data: 'id=' + pid,
            url: BASE_URL + '/warranties/deleteWarranty',
            responseType: 'json'
        });
    };
    factory.statussort = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/warranties/statussort',
            responseType: 'json'
        });
    };
    factory.categorysort = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/warranties/getproductcatwise',
            responseType: 'json'
        });
    };
    factory.sortalldash = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/warranties/sortalldash',
            responseType: 'json'
        });
    };
    return factory;
});
/********** AMC Factory*******************************/
WarrantyistApp.factory("Amc", function ($http) {
    var factory = {};

    factory.getAmc = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/amc/getAmc',
            responseType: 'json'
        });
    };
    factory.geteditAmc = function (id) {
        return $http({
            method: 'POST',
            data: 'amc_id=' + id,
            url: BASE_URL + '/amc/editAmc',
            responseType: 'json'
        });
    };
    factory.addAmc = function (frm) {
        var url = BASE_URL + '/amc/addAmc';
        return $http.post(url, frm);
    };
    factory.editAmcSave = function (frm) {
        var url = BASE_URL + '/amc/editAmcSave';
        return $http.post(url, frm);
    };
    factory.bindAmc = function (id) {
        return $http({
            method: 'POST',
            data: 'wrty_id=' + id,
            url: BASE_URL + '/amc/bindAmc',
            responseType: 'json'
        });
    };
    factory.deleteamcs = function (frm) {

        return $http({
            method: 'POST',
            data: 'id=' + frm,
            url: BASE_URL + '/amc/deleteamcs',
            responseType: 'json'
        });
    };
    factory.statussort = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/amc/statussort',
            responseType: 'json'
        });
    };
    factory.categorysort = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/amc/getamccatwise',
            responseType: 'json'
        });
    };
    factory.sortalldash = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/amc/sortalldash',
            responseType: 'json'
        });
    };
    return factory;
});
/**********  Services Factory*******************************/
WarrantyistApp.factory("Service", function ($http) {
    var factory = {};

    factory.getService = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/service/getService',
            responseType: 'json'
        });
    };
    factory.geteditService = function (id) {
        return $http({
            method: 'POST',
            data: 'service_id=' + id,
            url: BASE_URL + '/service/editService',
            responseType: 'json'
        });
    };
    factory.getserviceviewdetails = function (id) {
        return $http({
            method: 'POST',
            data: 'service_id=' + id,
            url: BASE_URL + '/service/getserviceviewdetails',
            responseType: 'json'
        });
    };
    factory.addService = function (frm) {
        var url = BASE_URL + '/service/addService';
        return $http.post(url, frm);
    };
    factory.editService = function (frm) {
        var url = BASE_URL + '/service/editServiceSave';
        return $http.post(url, frm);
    };
    factory.bindService = function (id) {
        return $http({
            method: 'POST',
            data: 'wrty_id=' + id,
            url: BASE_URL + '/service/bindService',
            responseType: 'json'
        });
    };
    factory.deleteservices = function (frm) {

        return $http({
            method: 'POST',
            data: 'id=' + frm,
            url: BASE_URL + '/service/deleteservices',
            responseType: 'json'
        });
    };
    factory.statussort = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/service/statussort',
            responseType: 'json'
        });
    };
    factory.categorysort = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/service/getservicecatwise',
            responseType: 'json'
        });
    };
    factory.sortalldash = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/service/sortalldash',
            responseType: 'json'
        });
    };
    return factory;
});
/**********  License Factory*******************************/
WarrantyistApp.factory("LicenseFactory", function ($http) {
    var factory = {};
    factory.getcat = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/licenses/get_category',
            responseType: 'json'
        });
    };
    factory.autosuggest = function () {
        return $http({
            method: 'POST',
           // data: 'word=' + char,
            url: BASE_URL + '/licenses/getsuggestiondata',
            responseType: 'json'
        });
    };
    factory.getLicenses = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/licenses/getlicensesdata',
            responseType: 'json'
        });
    };
    factory.getLicensesByCategory = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/licenses/getlicenses_by_category',
            responseType: 'json'
        });
    };
    factory.addLicense = function (frm) {
        var url = BASE_URL + '/licenses/addlicense';
        return $http.post(url, frm);
    };
    factory.editLicense = function (frm) {
        var url = BASE_URL + '/licenses/editlicense';
        return $http.post(url, frm);
    };
    factory.editRenewalLicense = function (frm) {
        var url = BASE_URL + '/licenses/editrenwallicense';
        return $http.post(url, frm);
    };
    factory.getproductedit = function (pid)
    {
        return $http({
            method: 'POST',
            data: 'id=' + pid,
            url: BASE_URL + '/licenses/editproductview',
            responseType: 'json'
        });
    };
    factory.deleteLicense = function (pid) {
        return $http({
            method: 'POST',
            data: 'id=' + pid,
            url: BASE_URL + '/licenses/delete_license',
            responseType: 'json'
        });
    };
    factory.deletemultiple = function (frm) {
        return $http({
            method: 'POST',
            data: 'ids=' + frm,
            url: BASE_URL + '/licenses/multi_delete_license',
            responseType: 'json'
        });
    };
    factory.sortalldash = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/licenses/sortalldash',
            responseType: 'json'
        });
    };
    return factory;
});
/*********** ProfileAccount Mehul's Code Starts from here*************/
WarrantyistApp.factory('ProfileAccount', function ($http) {

    var factory = {};
    factory.getUserprofile = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/profile/get_user_profile_data',
            responseType: 'json'
        });
    };
    factory.getUserForManage = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/profile/get_user_for_manage_view',
            responseType: 'json'
        });
    };
    factory.getUserDataForChangeRole = function (Editid)
    {
        return $http({
            method: 'POST',
            data: 'user_id=' + Editid,
            url: BASE_URL + '/profile/get_user_role_for_update',
            responseType: 'json'
        });
    };
    factory.getGroupUsersDataforView = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/profile/get_group_users_view',
            responseType: 'json'
        });
    };
    factory.getProfileAccountDetails = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/profile/get_account_details_view',
            responseType: 'json'
        });
    };
    factory.getUserDevicesForManage = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/profile/get_devicesformanage_view',
            responseType: 'json'
        });
    };

    return factory;
});
/*********************ends here***************************/


/***************Document Factory*******************************/
WarrantyistApp.factory("Documents", function ($http) {
    var factory = {};

    factory.getDocCat = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/documents/get_category',
            responseType: 'json'
        });
    };

    factory.getDocumentWarranty = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/documents/viewDocproducts',
            responseType: 'json'
        });
    };

    factory.geteditDoc = function (id) {
        return $http({
            method: 'POST',
            data: 'doc_id=' + id,
            url: BASE_URL + '/documents/editDoc',
            responseType: 'json'
        });
    };

    factory.getdocumentedit = function (did)
    {
        return $http({
            method: 'POST',
            data: 'id=' + did,
            url: BASE_URL + '/documents/editdocuments',
            responseType: 'json'
        });
    };

    factory.editDocument = function (frm) {
        var url = BASE_URL + '/documents/editDocument';
        return $http.post(url, frm);
    };

    factory.addDocument = function (frm) {
        var url = BASE_URL + '/documents/addDocument';
        return $http.post(url, frm);
    };

    factory.deleteDoc = function (pid) {
        return $http({
            method: 'POST',
            data: 'doc_id=' + pid,
            url: BASE_URL + '/documents/deleteDoc',
            responseType: 'json'
        });
    };
    factory.getDocumentsByCategory = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/documents/getDocumentsByCategory',
            responseType: 'json'
        });
    };
    factory.getDocumentsByProduct = function () {
        return $http({
            method: 'GET',
            url: BASE_URL + '/documents/getDocumentsByProduct',
            responseType: 'json'
        });
    };


    return factory;
});