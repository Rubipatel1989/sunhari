<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($closings);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Calculate Matching Income
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
                        <?php echo $this->Form->create(NULL, array('id' => 'bulk-payment-closing-form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <div class="col-xs-12 nopadding table-cotainer">
                          
                            <div class="col-xs-12 nopadding">
                              <table id="payments_closing" class="table table-striped table-hover">
                                 <thead>
                                    <tr>
                                      <th style="white-space: nowrap;">Sr. No.</th>
                                      <th style="white-space: nowrap;">Username</th>
                                      <th style="white-space: nowrap;">Left EMI</th>
                                      <th style="white-space: nowrap;">Right EMI</th>
                                      <th style="white-space: nowrap;">Pair</th>
                                      <th style="white-space: nowrap;">EMI Rate</th>
                                      <th style="white-space: nowrap;">Matching Income</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($users)){
                                      $i=1;
                                      foreach($users as $userInfo){
                                        
                                        $leftEmi =0;
                                        if(!empty($userInfo->left_emi)){
                                          $leftEmi = $userInfo->left_emi;
                                        }
                                        $rightEmi =0;
                                        if(!empty($userInfo->right_emi)){
                                          $rightEmi = $userInfo->right_emi;
                                        }

                                        $pair = $leftEmi;
                                        if($leftEmi > $rightEmi){
                                          $pair = $rightEmi;
                                        }
                                        $matchingIncome = $pair * $pairRate->emi_rate;
                                      ?>
                                        <tr class="gradeX">
                                          <td><?php echo $i; ?></td>
                                          <td><?php echo $userInfo->username; ?></td>
                                          <td><?php echo $leftEmi; ?></td>
                                          <td><?php echo $rightEmi; ?></td>
                                          <td><?php echo $pair; ?></td>
                                          <td><?php echo $pairRate->emi_rate; ?></td>
                                          <td><?php echo $matchingIncome; ?></td>
                                        </tr>
                                      <?php
                                        $i++;
                                      }
                                    }?>
                                 </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="col-xs-12 nopadding margin-top-15">
                            <button type="submit" class="btn btn-primary" name="btn_payment_calculation">Submit</button>
                          </div>
                        <?php echo $this->Form->end();?>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>