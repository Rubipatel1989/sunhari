<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Fund Request
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $home_url ?>/my-account/wallet/request-fund"><i class="fa fa-plus"></i> Request Fund</a>
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="wallets" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Date</th>
                                  <th>Username</th>
                                  <th>Tran. Id</th>
                                  <th>Amount</th>
                                  <th>Self Account</th>
                                  <!-- <th>Comp. Account</th> -->
                                  <th>Status</th>
                                  <th>Remark</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($fundrequests)){
                                  $i=1;
                                  foreach($fundrequests as $fundrequest){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($fundrequest->created)); ?></td>
                                      <td><?php echo $fundrequest->Users['username']; ?></td>
                                      <td><?php echo $fundrequest->transaction_id; ?></td>
                                      <td><?php echo number_format($fundrequest->btc_value, 2); ?></td>
                                      <td><?php echo $fundrequest->self_btc_address; ?></td>
                                      <!-- <td><?php //echo $fundrequest->company_btc_address; ?></td> -->
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Pending';
                                        if($fundrequest->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Paid';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                      </td>
                                      <td><?php echo html_entity_decode($fundrequest->remark); ?></td>
                                    </tr>
                                  <?php
                                    $i++;
                                  }
                                }?>
                             </tbody>
                          </table>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>