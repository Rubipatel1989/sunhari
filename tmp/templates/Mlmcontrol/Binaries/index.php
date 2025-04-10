<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Binaries
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/binaries/add"><i class="fa fa-plus"></i> Add Binary</a>
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
                                    <th>Created On</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Percentage(In %)</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($binaries)){
                                  $i=1;
                                  foreach($binaries as $binary){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($binary->created)); ?></td>
                                      <td><?php echo $binary->title; ?></td>
                                      <td>
                                        <?php
                                        if(!empty($binary->amount)) {
                                          echo number_format($binary->amount, 2);
                                        }else{
                                          echo 'N/A';
                                        }
                                        ?>
                                      </td>
                                      <td>
                                        <?php
                                        if(!empty($binary->percentage)) {
                                          echo number_format($binary->percentage, 2); 
                                        }else{
                                          echo 'N/A';
                                        }
                                        ?>
                                      </td>
                                      <td>
                                        <?php
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($binary->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                      </td>
                                      <td><?php echo html_entity_decode($binary->remark); ?></td>
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