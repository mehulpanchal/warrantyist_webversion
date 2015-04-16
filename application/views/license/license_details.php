<!--Code for View License data
    Code by mehul as on 19315
-->
<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="row">
    <div class="col-md-12">
        <div class="sub_row">
            <a class="pull-left back_left back_none">
                <img src="<?php echo base_url('assets/admin/layout/img/Back-icon.png'); ?>" />
            </a>

            <a class="pull-right close_right" ng-click="$modalCancel()">
                <img src="<?php echo base_url('assets/admin/layout/img/Close-Button-icon.png'); ?>" />
            </a>
        </div>
        <div class="sub_row">
            <a class="btn red pull-right" href="#" ng-click="editLicenseView(binddata.id)">
                <span class="hidden-480">
                    Edit  </span>
            </a>
        </div>
        <div class="list_block">

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="10%" class="list_icon_cont">
                        <img src="assets/admin/layout/img/Electronics-icon.png">
                    </td>
                    <td>
                        <h4 class="list_item_one">{{ binddata.softwear_name}}</h4>
                        <h4 class="list_item_two">{{ binddata.cat_name}}</h4>
                        <p class="list_item_three">Licenses - {{ binddata.no_lincense}}</p>
                        <p class="list_item_four">Renewal in {{ binddata.start_date}}</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="left_container">
            <div class="left_pop_block">
                <ul>
                    <li>
                        <span>Version :</span> {{ binddata.softwear_version}}
                    </li>
                    <li>
                        <span>Email :</span> {{ binddata.registeremail}}
                    </li>
                    <li>
                        <span>License Valid Upto : </span> {{ binddata.start_date}}
                    </li>

                </ul>
            </div>
            <h3 class="block_mail_head"> <img src="assets/admin/layout/img/License-Purchase-icon.png"> License Purchase Details</h3>
            <div class="left_pop_block">
                <ul>
                    <li>
                        <span>Invoice Number :</span> {{ binddata.invoice_number}}
                    </li>
                    <li>
                        <span>Invoice Date :</span> {{ binddata.invoice_date}}
                    </li>
                    <li>
                        <span>Purchased From :</span> {{ binddata.vendor_name}}
                    </li>
                    <li>
                        <span>Purchased Amount :</span>{{ binddata.purchase_amt}}
                    </li>

                </ul>
            </div>
            <h3 class="block_mail_head"> <img src="assets/admin/layout/img/Purchase-Receipt-icon.png">  Purchase Receipt</h3>
            <div class="left_pop_block">
                <img src="{{ binddata.image_url}}" class="image_width_block" /> 
            </div>
            <div>		

            </div>
        </div>
        <div class="right_container">
            <h3 class="block_mail_head"> <img src="assets/admin/layout/img/Notes-icon.png"> Note</h3>
            <div class="left_pop_block">
                <p class="note_para">
                    {{ binddata.notedesc}}
                </p>
            </div>
            <div class="btn_container">
                <a class="btn grey-cascade bt_extra" href="#" ng-click="editRenewalView(binddata.id)">

                    Add License Renewal  
                </a>
                <a class="btn red bt_extra2" href="#" ng-click="proccesdelete(binddata.id)">

                    Delete License
                </a>

            </div>
        </div>



        <!-- END SAMPLE FORM PORTLET-->