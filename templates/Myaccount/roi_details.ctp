<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<h3>
   <div class="pull-right text-center">
     
   </div>
  PPI Details
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
                          <div class="col-xs-12 nopadding table-cotainer">
                            <div class="col-xs-12 nopadding">
                              <table id="packages" class="table table-striped table-hover">
                                 <thead>
                                    <tr>
                                      <th style="white-space: nowrap;">Sr. No.</th>
                                      <th style="white-space: nowrap;">Date</th>
                                      <th style="white-space: nowrap;">Amount</th>
                                      <th style="white-space: nowrap;">Status</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($rois)){
                                      $i=1;
                                      foreach($rois as $roi){?>
                                        <tr class="gradeX">
                                          <td><?php echo $i; ?></td>
                                          <td>
                                            <?php echo date("F j, Y, g:i a", strtotime($roi->created)); ?>
                                          </td>
                                          <td>
                                            <?php echo number_format($roi->roi, 2); ?>
                                          </td>
                                          <td>
                                            <?php
                                            $status_cls = 'inactive-staus';
                                            $status_txt = 'Pending';
                                            if($roi->status == 1){
                                              $status_cls = 'active-staus';
                                              $status_txt = 'Paid';
                                            }?>
                                            <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
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
</div>