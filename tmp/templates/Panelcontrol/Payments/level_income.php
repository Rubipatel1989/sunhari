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
  Level Income
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
                                      <th><input type="checkbox" name="check_all" class="chk-all chk-check-uncheck" value="1"></th>
                                      <th style="white-space: nowrap;">Sr. No.</th>
                                      <th style="white-space: nowrap;">Username</th>
                                      <th style="white-space: nowrap;">Name</th>
                                      <th style="white-space: nowrap;">Account No.</th>
                                      <th style="white-space: nowrap;">Level Income</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($lavelIncomes)){
                                      $i=1;
                                      foreach($lavelIncomes as $lavelIncome){
                                      ?>
                                        <tr class="gradeX">
                                          <td><input type="checkbox" name="ids[]" class="chk-all chk-ids" value="<?php echo $lavelIncome['id']; ?>"></td>
                                          <td><?php echo $i; ?></td>
                                          <td><?php echo $lavelIncome['username']; ?></td>
                                          <td><?php echo $lavelIncome['first_name'].' '.$lavelIncome['last_name']; ?></td>
                                          <td>
                                            <?php 
                                            if(!empty($lavelIncome['pan_number'])){
                                              echo $lavelIncome['pan_number']; 
                                            }else{
                                              echo 'N/A';
                                            }
                                            ?>
                                            <input type="hidden"  name="btc_address[<?php echo $lavelIncome['id']; ?>]" value="<?php echo $lavelIncome['pan_number']; ?>">
                                          </td>
                                          <td>
                                            <?php echo number_format($lavelIncome['level_income'], 2); ?>
                                            <input type="hidden"  name="level_income[<?php echo $lavelIncome['id']; ?>]" value="<?php echo $lavelIncome['level_income']; ?>">
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
                          <?php 
                          if($checkUnpaidLevelIncome == 0){?>
                            <div class="col-xs-12 nopadding margin-top-15">
                              <button type="submit" class="btn btn-primary" name="btn_payment_calculation">Submit</button>
                            </div>
                          <?php
                          }?>
                        <?php echo $this->Form->end();?>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>