<div class="row">
    <div class="col-md-12 portlet-title">                
               <p class="text-right"><button type="button" ng-click="editDocumentView(doc[0].doc_id)"  class="btn red">Edit</button></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light form-fit">    
            <div class="portlet-body form">
                <!-- BEGIN VIEW-->                                                                                  
                <div ng-repeat="d in doc">                                                        
                   <!--  <div>{{ r.product_name}}</div> -->

                    <div>Document Id : {{  d.doc_id}}</div>
                    <div>Document Name : {{  d.doc_name}}</div>
                    <div>Category Name : {{  d.cat_name}}</div>
                    <div>Document Number : {{  d.doc_number}}</div>
                    <div>Start Date : {{  d.start_date}}</div> 

                    <!-- <div ng-if="r.warranty_card">Warranty Card <div ng-if="r.warranty_card"><img src="{{ r.warranty_card }}" width="150" height="120" /></div></div>                 
                    <div ng-if="r.purchase_invoice">Purchase Invoice  
                        <div ng-if="r.purchase_invoice"><img src="{{ r.purchase_invoice }}" height="120" width="150" /></div>
                    </div> -->
                    <div>Note: {{ d.notes }}</div>
                </div>
                <!-- END VIEW-->
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
   
</div>      
<div class="row">
    <div class="col-md-12 portlet-title">                
               <p class="text-left"><button type="button" ng-click="docdelete(doc[0].doc_id)"  class="btn red">Delete Document</button></p>
    </div>
</div>




                                                 
                   
                
