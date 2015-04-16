<!-- BEGIN PAGE CONTENT-->
<div class="row"  >
    <div class="col-md-12">
        <!-- BEGIN TODO SIDEBAR -->
        <div class="todo-ui margin-top-10">

            <!-- BEGIN TODO CONTENT -->
            <div class="todo-content" >
                <div class="portlet light" style="min-height: 800px;">
                    <!-- PROJECT HEAD -->
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-helper"></span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase">Contact Information</span>
                        </div>
                    </div>
                    <!-- end PROJECT HEAD -->
                    <h3>Account Owner</h3>
                    Information about this account, such as list import & send notifications, will be send to the email address listed here.
                    <!--Account Detail Start-->
                    <div class="portlet-body" style="width: 50%; float: left; clear: both; padding:15px 15px;" >

                        <div class="alert alert-success message-animation" role="alert" ng-if="showContactInfoSuccessMsg">
                            Contact Information Updated Successfully.
                        </div> 
<!--                        {{formData}}-->
                        <form name="editcompanydetails" ng-submit="companydetailsupdate(editcompanydetails.$valid)" novalidate>
                            <div class="form-group" ng-class="{ 'has-error' : editcompanydetails.contactpersonname.$invalid && !editcompanydetails.contactpersonname.$pristine }">
                                <label for="contactpersonname">Contact Name</label>
                                <input id="contactpersonname" name="contactpersonname" class="form-control input-lg" type="text" ng-model="formData.contactpersonname" required="" />
                                <div class="custom-error" ng-show="editcompanydetails.contactpersonname.$dirty && editcompanydetails.contactpersonname.$invalid">
                                    <span ng-show="editcompanydetails.contactpersonname.$error.required">Contact Name is required.</span>
                                </div>
                            </div>
                            <div class="form-group" ng-class="{ 'has-error' : editcompanydetails.companyname.$invalid && !editcompanydetails.companyname.$pristine }">
                                <label for="companyname">Company/Organization</label>
                                <input id="companyname" name="companyname" class="form-control input-lg" type="text" ng-model="formData.companyname" required="" />
                                <div class="custom-error" ng-show="editcompanydetails.companyname.$dirty && editcompanydetails.companyname.$invalid">
                                    <span ng-show="editcompanydetails.companyname.$error.required">Company/Organization is required.</span>
                                </div>
                            </div>
                            <div class="form-group" ng-class="{ 'has-error' : editcompanydetails.companywebsite.$invalid && !editcompanydetails.companywebsite.$pristine }">
                                <label for="companywebsite">Company's Website</label>
                                <input id="companywebsite" name="companywebsite" class="form-control input-lg" type="text" ng-model="formData.companywebsite" required="" />
                                <div class="custom-error" ng-show="editcompanydetails.companywebsite.$dirty && editcompanydetails.companywebsite.$invalid">
                                    <span ng-show="editcompanydetails.companywebsite.$error.required">Company's Website is required.</span>
                                </div>
                            </div>
                            <div class="form-group" ng-class="{ 'has-error' : editcompanydetails.companyaddress.$invalid && !editcompanydetails.companyaddress.$pristine }">
                                <label for="companyaddress">Address</label>
                                <textarea ng-model="formData.companyaddress" class="form-control" name="companyaddress" required="" rows="3" ng-value="companyAddressscope"></textarea>
                                <div class="custom-error" ng-show="editcompanydetails.companyaddress.$dirty && editcompanydetails.companyaddress.$invalid">
                                    <span ng-show="editcompanydetails.companyaddress.$error.required">Address is required.</span>
                                </div>
                            </div>
                            <div class="form-group" ng-class="{ 'has-error' : editcompanydetails.companyemail.$invalid && !editcompanydetails.companyemail.$pristine }">
                                <label for="companyemail">Email ID</label>
                                <input id="companyemail" name="companyemail" class="form-control input-lg" type="text" ng-model="formData.companyemail" ng-pattern="/^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/" required="" />
                                <div class="custom-error" ng-show="editcompanydetails.companyemail.$dirty && editcompanydetails.companyemail.$invalid">
                                    <span ng-show="editcompanydetails.companyemail.$error.required" class="help-block">Email is Required.</span>
                                    <span ng-show="editcompanydetails.companyemail.$error.maxlength" class="help-block">Email is too long.</span>
                                    <span ng-show="editcompanydetails.companyemail.$error.pattern" class="help-block">Invalid Email! </span>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Save Contact Information</button>
                            <div class="loadingtillresponse" ng-if="loadingtillresponse" ></div>
                        </form>
                    </div>
                    <!--BASic Information end-->
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTENT-->
