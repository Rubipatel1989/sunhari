<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Fund Transfer
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/wallet/transfer_fund"><i class="fa fa-plus"></i> Transfer Fund</a>
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="packages" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Transaction Id</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Transfered by</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($wallets)){
                                  $i=1;
                                  foreach($wallets as $wallet){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $wallet->transaction_id; ?></td>
                                      <td><?php echo $wallet->Users['username']; ?></td>
                                      <td><?php echo $wallet->Details['first_name'].' '.$wallet->Details['last_name']; ?></td>
                                      <td><?php echo number_format($wallet->amount, 2); ?></td>
                                      <td><?php echo $wallet->Payer['username']; ?></td>
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Pending';
                                        if($wallet->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Approved';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                             <li><a href="<?php echo $backend_url; ?>/wallet/edit/<?php echo $wallet->transaction_id; ?>">Edit</a> 
                                             </li>
                                             <li><a href="<?php echo $backend_url; ?>/wallet/update-status/<?php echo $wallet->id; ?>/1">Approve</a>
                                             </li>
                                             <li><a href="<?php echo $backend_url; ?>/wallet/update-status/<?php echo $wallet->id; ?>/0">Pending</a>
                                             </li>
                                             <li><a onclick="return confirm('Delete operation will the data permanently from database. Are you sure?');" href="<?php echo $backend_url; ?>/wallet/delete/<?php echo $wallet->id; ?>">Delete</a>
                                             </li>
                                          </ul>
                                       </div>
                                      </td>
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