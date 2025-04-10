<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">User Earning Details</h3>
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
          User Earning Details
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
    
    <?php echo $this->Form->create(NULL, array('id' => 'activate_user_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'method' => 'get'));?>
       <div class="row margin-bottom-20">
          <div class="col-sm-3 nopadding">
              <?php 
              $username = $_GET['username'] ?? '';
              echo $this->Form->input('username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => 'Enter user id', 'value' => $username)); 
              ?>
          </div>
          <div class="col-sm-3">
              <button type="submit" class="btn btn-success rounded-pill px-4">
                <div class="d-flex align-items-center">
                  Submit
                </div>
              </button>
          </div>
      </div>
    <?php echo $this->Form->end();?>
    
    <div class="row">
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
               <thead>
                  <tr>
                    <th>Sr</th>
                    <th style="white-space: nowrap;">User Id</th>
                    <th style="white-space: nowrap;">Daily Incentive Income</th>
                    <th style="white-space: nowrap;">Direct Income</th>
                    <th style="white-space: nowrap;">Level Income</th>
                    <th style="white-space: nowrap;">Repurchase Income</th>
                    <th style="white-space: nowrap;">Repurchase MB Income</th>
                    <th style="white-space: nowrap;">Royalty Income</th>
                    <th>Remark</th>
                    <th>Date</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $arrOtherUser = [];
                  if($payouts){
                    $i = 1;
                    foreach($payouts as $payout){
                      $directAmount = 0;
                      $levelAmount = $payout->level_income;
                      if ($payout->remark == 'Direct Income') {
                          $directAmount = $payout->level_income;
                          $levelAmount = 0;
                      }
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $payout->Users['username']; ?></td>
                          <td><?php echo number_format($payout->daily_incentive ?? 0, 2); ?></td>
                          <td><?php echo number_format($directAmount ?? 0, 2); ?></td>
                          <td><?php echo number_format($levelAmount ?? 0, 2); ?></td>
                          <td><?php echo number_format($payout->repurchase_ab_income ?? 0, 2); ?></td>
                          <td><?php echo number_format($payout->repurchase_mb_income ?? 0, 2); ?></td>
                          <td><?php echo number_format($payout->royalty_income ?? 0, 2); ?></td>
                          <td><?php echo $payout->remark; ?></td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($payout->created); ?></span><?php echo date("d M Y", strtotime($payout->created)); ?></td>
                        </tr>
                    <?php
                        $i++;
                      }
                  }?>
               </tbody>
            </table>
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