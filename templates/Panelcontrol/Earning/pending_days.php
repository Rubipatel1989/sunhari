<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Pending Days</h3>
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
          Pending Days
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
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
               <thead>
                  <tr>
                    <th>Sr</th>
                    <th style="white-space: nowrap;">User Id</th>
                    <th style="white-space: nowrap;">User Name</th>
                    <th style="white-space: nowrap;">Total Payout</th>
                    <th style="white-space: nowrap;">Earned Payout</th>
                    <th style="white-space: nowrap;">Pending Payout</th>
                    <th style="white-space: nowrap;">Daily Payout</th>
                    <th style="white-space: nowrap;">No. of Days</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if($upgrades){
                    $i = 1;
                    foreach($upgrades as $upgrade) {
                      $totalPackageAmount = $upgrade->Users['total_self_business'];
                      if($upgrade->Users['total_direct_active'] > 0 || $totalPackageAmount >= 10000){
                        $multiplier  = 3;
                      } elseif($totalPackageAmount >= 1 && $totalPackageAmount < 1000){
                          $multiplier  = 2;
                      } elseif($totalPackageAmount >= 1000 && $totalPackageAmount < 10000){
                          $multiplier  = 2.5;
                      } else {
                          $multiplier  = 2;
                      }
                      $totalPayout = ($totalPackageAmount * $multiplier);
                      $totalEarnedPayout = $upgrade->totalDirectAmount + $upgrade->totalROI + $upgrade->totalRoyaltyAmount + $upgrade->totalLevelIncome;
                      $pendingPayout = $totalPayout - $totalEarnedPayout;
                      $dailyIncome = $upgrade->todayROI + $upgrade->todayLevelIncome;
                      $divider = 1;
                      if ($dailyIncome > 0) {
                        $divider = $dailyIncome;
                      }
                      $numberDays = (int) ($pendingPayout/$divider);
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $upgrade->Users['username']; ?></td>
                          <td style="white-space: nowrap;"><?php echo $upgrade->Users['name']; ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($totalPayout ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($totalEarnedPayout ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($pendingPayout ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($dailyIncome ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;"><?php echo $numberDays; ?></td>
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