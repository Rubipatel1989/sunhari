<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Transferred Epins
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer margin-top-20">
                          <table id="wallets" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Transferred On</th>
                                    <th>Epin</th>
                                    <th>Transferred To</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($epinHistories)){
                                  $i=1;
                                  foreach($epinHistories as $epinHistory){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($epinHistory->created)); ?></td>
                                      <td><?php echo $epinHistory->Epins['epin']; ?></td>
                                      <td><?php echo $epinHistory->TransferredTo['username'].' ( '.$epinHistory->DetialsTo['first_name'].' '.$epinHistory->DetialsTo['last_name'].' )'; ?></td>
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