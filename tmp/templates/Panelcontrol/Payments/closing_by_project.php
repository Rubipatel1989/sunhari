<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Closing
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
                        <?php echo $this->Form->create(NULL, array('id' => 'bulk-payment-calculation-form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <div class="col-xs-12 nopadding table-cotainer">
                          
                            <div class="col-xs-12 nopadding">
                              <table id="packages" class="table table-striped table-hover">
                                 <thead>
                                    <tr>
                                      <th style="white-space: nowrap;">Sr. No.</th>
                                      <th style="white-space: nowrap;">Username</th>
                                      <th style="white-space: nowrap;">Name</th>
                                      <th style="white-space: nowrap;">Left (in $)</th>
                                      <th style="white-space: nowrap;">Right (in $)</th>
                                      <th style="white-space: nowrap;">Current Pair (in $)</th>
                                      <th style="white-space: nowrap;">Previous Pair (in $)</th>
                                      <th style="white-space: nowrap;">Pending Pair (in $)</th>
                                      <th style="white-space: nowrap;">Direct Left (in $)</th>
                                      <th style="white-space: nowrap;">Direct Right (in $)</th>
                                      <th style="white-space: nowrap;">Super Bonus Status</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($users)){
                                      $i=1;
                                      foreach($users as $user){
                                        $current_pair = $user->total_active_right;
                                        if($user->total_active_left < $user->total_active_right){
                                          $current_pair = $user->total_active_left;
                                        }
                                        $pending_pair = $current_pair - $user->previous_pair;

                                        $royalty = 0;
                                        if($pending_pair > 0){
                                          $royalty = ($pending_pair*10)/100;
                                        }
                                      ?>
                                        <tr class="gradeX">
                                          <td>
                                            <?php 
                                            echo $i; 
                                            if($pending_pair > 0){?>
                                              <input type="hidden" name="user_ids[]" value="<?php echo $user->id; ?>">
                                            <?php
                                            }?>   
                                          </td>
                                          <td><?php echo $user->username; ?></td>
                                          <td><?php echo $user->Details['first_name'].' '. $user->Details['last_name']; ?></td>
                                          <td><?php echo number_format($user->total_active_left, 2); ?></td>
                                          <td><?php echo number_format($user->total_active_right, 2); ?></td>
                                          <td><?php echo number_format($current_pair, 2); ?></td>
                                          <td><?php echo number_format($user->previous_pair, 2); ?></td>
                                          <td>
                                            <?php 
                                            echo number_format($pending_pair, 2); 
                                            if($pending_pair > 0){?>
                                              <input type="hidden" name="pending_pair[<?php echo $user->id; ?>]" value="<?php echo $pending_pair; ?>">
                                            <?php
                                            }?>
                                          </td>
                                          <td><?php echo number_format($user->total_direct_acitve_left, 2); ?></td>
                                          <td><?php echo number_format($user->total_direct_acitve_right, 2); ?></td>
                                          <td>
                                            <?php 
                                            $royalty = 0;
                                            echo number_format($royalty, 2); 
                                            if($royalty > 0){
                                              ?>
                                              <input type="hidden" name="royalty[<?php echo $user->id; ?>]" value="<?php echo $royalty;?>">
                                            <?php
                                            }?>
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
                         <!-- <div class="col-xs-12 nopadding margin-top-15">
                            <button type="submit" class="btn btn-primary" name="btn_payment_calculation">Submit</button>
                          </div>-->
                        <?php echo $this->Form->end();?>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>