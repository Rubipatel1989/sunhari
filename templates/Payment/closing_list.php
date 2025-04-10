<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0"> Closing List</h3>
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
          Closing List
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
      <div class="col-sm-12 margin-bottom-20">
         <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <div class="row nopadding">
            <div class="col nopadding">
              <?php

              $options = ['' => '-Select-'];
              if($lastClosingInfo) {
                for($i=1; $i<=$lastClosingInfo->closing_count; $i++) {
                  $options[$i] = $i;
                }
              }
              $closingCount = isset($_GET['closing_count']) ? $_GET['closing_count'] : '';
              echo $this->Form->input('closing_count', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $closingCount)); 
               ?>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-12">
          <div class="row nopadding table-cotainer">
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
                <thead>
                  <tr>
                    <th style="white-space: nowrap;">Sr. No.</th>
                    <th style="white-space: nowrap;">Date</th>
                    <th style="white-space: nowrap;">PAN Number</th>
                    <th style="white-space: nowrap;">Bank Details</th>
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
                  </tr>
               </thead>
               <tbody>
                  <?php 
                    $i=1;
                    foreach($closings as $closing) {?>
                      <tr class="gradeX">
                        <td style="white-space: nowrap;"><?php echo $i; ?></td>
                        <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($closing->created); ?></span> <?php echo date('d M Y', strtotime($closing->created)); ?></td>
                        <td style="white-space: nowrap;"><?php echo $closing->pan_number; ?></td>
                        <td style="white-space: nowrap;">
                          Bank <?php echo $closing->bank_name; ?>
                          <br>Account Number <?php echo $closing->account_number; ?>
                          <br>IFSC <?php echo $closing->ifsc_code; ?>
                        </td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->daily_incentive, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->direct_income, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->level_income, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->repurchase_ab_income, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->repurchase_mb_income, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->royalty_income, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->total_income, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->tax, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->foundation_charge, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->admin_commission, 2); ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($closing->net_amount, 2); ?></td>
                      </tr>
                  <?php
                      $i++;
                  }?>
                 </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>