<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Closing</h3>
    </div>
    <div
      class="
        col-md-7 col-12
        align-self-center
        d-none d-md-flex
        justify-content-end
      "
    >
      <ol class="breadcrumb mb-0 p-0 bg-transparent">
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">Home</a>
        </li>
        <li class="breadcrumb-item active d-flex align-items-center">
          Closing
        </li>
      </ol>
    </div>
  </div>
  <!-- -------------------------------------------------------------- -->
  <!-- Start Page Content -->
  <!-- -------------------------------------------------------------- -->
  <div class="row">
    <div class="col-sm-12">
      <?php echo $this->Flash->render(); ?>
    </div>
  </div>
  <div class="card card-body">
    <div class="row">
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
               <thead>
                <tr>
                  <th><input type="checkbox" class="chk-all chk-check-uncheck"></th>
                  <th style="white-space: nowrap;">Sr. No.</th>
                  <th style="white-space: nowrap;">UserId</th>
                  <th style="white-space: nowrap;">Name</th>
                  <th style="white-space: nowrap;">PAN Number</th>
                  <th style="white-space: nowrap;">Account Number</th>
                  <th style="white-space: nowrap;">IFSC</th>
                  <th style="white-space: nowrap;">Daily Incentive Income</th>
                  <th style="white-space: nowrap;">Direct Income</th>
                  <th style="white-space: nowrap;">Level Income</th>
                  <th style="white-space: nowrap;">Repurchase Income</th>
                  <th style="white-space: nowrap;">Repurchase MB Income</th>
                  <th style="white-space: nowrap;">Royalty Income</th>
                  <th style="white-space: nowrap;">Total Income</th>
                  <th style="white-space: nowrap;">Tax</th>
                  <th style="white-space: nowrap;">Foundation Charge</th>
                  <th style="white-space: nowrap;">Admin Commission</th>
                  <th style="white-space: nowrap;">Net Amount</th>
                  <th style="white-space: nowrap;">Closing</th>
                </tr>
             </thead>
             <tbody>
                <?php
                if(!empty($closings)){
                  $i=1;
                  foreach($closings as $closing){

                    $total = $closing['direct_income'] + $closing['level_income'] + $closing['daily_incentive'] + $closing['repurchase_ab_income'] + $closing['repurchase_mb_income'] + $closing['royalty_income'];
                    $tax = ($total * 5)/100;
                    $foundation_charge = ($total * 5)/100;
                    $admin_commission = ($total * 2.5)/100;
                    $net_amount = $total - ($tax + $foundation_charge + $admin_commission);
                    $closingCount = $closing['last_closing_count'] + 1;


                  ?>
                    <tr class="gradeX">
                      <td><input type="checkbox" name="ids[]" class="chk-all chk-ids" value="<?php echo $closing['id']; ?>"></td>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $closing['username']; ?></td>
                      <td><?php echo $closing['name']; ?></td>
                      <td>
                        <?php 
                        $pan_number = isset($closing['pan_number']) ? $closing['pan_number'] : ''; 
                        if(!empty($pan_number)){
                          echo $pan_number; 
                        }else{
                          echo 'N/A';
                        }
                        ?>
                        <input type="hidden"  name="pan_number[<?php echo $closing['id']; ?>]" value="<?php echo $pan_number; ?>">
                      </td>
                      <td>
                        <?php 
                        $account_number = isset($closing['account_number']) ? $closing['account_number'] : ''; 
                        if(!empty($account_number)){
                          echo $account_number; 
                        }else{
                          echo 'N/A';
                        }
                        ?>
                        <input type="hidden"  name="account_number[<?php echo $closing['id']; ?>]" value="<?php echo $account_number; ?>">
                      </td>
                      <td>
                        <?php 
                        $ifsc_code = isset($closing['ifsc_code']) ? $closing['ifsc_code'] : ''; 
                        if(!empty($ifsc_code)){
                          echo $ifsc_code; 
                        }else{
                          echo 'N/A';
                        }
                        ?>
                        <input type="hidden"  name="ifsc_code[<?php echo $closing['id']; ?>]" value="<?php echo $ifsc_code; ?>">
                      </td>
                      <td>
                        <?php 
                        echo number_format($closing['daily_incentive'], 2); 
                        ?>
                        <input type="hidden"  name="daily_incentive[<?php echo $closing['id']; ?>]" value="<?php echo $closing['daily_incentive']; ?>">   
                      </td>
                      <td>
                        <?php echo number_format($closing['direct_income'], 2); ?>
                        <input type="hidden"  name="direct_income[<?php echo $closing['id']; ?>]" value="<?php echo $closing['direct_income']; ?>">
                      </td>
                      <td>
                        <?php 
                        echo number_format($closing['level_income'], 2); 
                        ?>
                        <input type="hidden"  name="level_income[<?php echo $closing['id']; ?>]" value="<?php echo $closing['level_income']; ?>">  
                      </td>
                      <td>
                        <?php echo number_format($closing['repurchase_ab_income'], 2); ?>
                        <input type="hidden"  name="repurchase_ab_income[<?php echo $closing['id']; ?>]" value="<?php echo $closing['repurchase_ab_income']; ?>">
                      </td>
                      <td>
                        <?php echo number_format($closing['repurchase_mb_income'], 2); ?>
                        <input type="hidden"  name="repurchase_mb_income[<?php echo $closing['id']; ?>]" value="<?php echo $closing['repurchase_mb_income']; ?>">
                      </td>
                      <td>
                        <?php echo number_format($closing['royalty_income'], 2); ?>
                        <input type="hidden"  name="royalty_income[<?php echo $closing['id']; ?>]" value="<?php echo $closing['royalty_income']; ?>">
                      </td>
                      <td>
                        <?php echo number_format($total, 2); ?>
                        <input type="hidden"  name="total[<?php echo $closing['id']; ?>]" value="<?php echo $total; ?>">
                      </td>
                      <td>
                        <?php echo number_format($tax, 2); ?>
                        <input type="hidden"  name="tax[<?php echo $closing['id']; ?>]" value="<?php echo $tax; ?>"> 
                      </td>
                      <td>
                        <?php echo number_format($foundation_charge, 2); ?>
                        <input type="hidden"  name="foundation_charge[<?php echo $closing['id']; ?>]" value="<?php echo $foundation_charge; ?>"> 
                      </td>
                      <td>
                        <?php echo number_format($admin_commission, 2); ?>
                        <input type="hidden"  name="admin_commission[<?php echo $closing['id']; ?>]" value="<?php echo $admin_commission; ?>"> 
                      </td>
                      <td>
                        <?php echo number_format($net_amount, 2); ?>
                        <input type="hidden"  name="net_amount[<?php echo $closing['id']; ?>]" value="<?php echo $net_amount; ?>">
                      </td>
                      <td><input type="text" name="closing_count[<?php echo $closing['id']; ?>]" class="form-control" value="<?php echo $closingCount; ?>" style="width: 50px;" readonly></td>
                    </tr>
                  <?php
                    $i++;
                  }
                }?>
             </tbody>
            </table>
          </div>
          <div class="row margin-top-10">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-small btn-success rounded-pill px-4">Submit</button>
            </div>
          </div> 
        <?php echo $this->Form->end();?>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>