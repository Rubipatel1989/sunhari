<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Total Earning</h3>
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
          Total Earning
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
                    <th style="white-space: nowrap;">Total Direct Income</th>
                    <th style="white-space: nowrap;">Total ROI</th>
                    <th style="white-space: nowrap;">Total Royalty Income</th>
                    <th style="white-space: nowrap;">Total Level Income</th>
                    <th style="white-space: nowrap;">Total Rank Income</th>
                    <th style="white-space: nowrap;">Net Income</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if($upgrades){
                    $i = 1;
                    foreach($upgrades as $upgrade){
                      $netIncome = 0;
                      $netIncome = $upgrade->totalDirectAmount + $upgrade->totalROI + $upgrade->totalRoyaltyAmount + $upgrade->totalLevelIncome + $upgrade->totalRankIncome;
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $upgrade->Users['username']; ?></td>
                          <td style="white-space: nowrap;"><?php echo $upgrade->Users['name']; ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($upgrade->totalDirectAmount ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($upgrade->totalROI ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($upgrade->totalRoyaltyAmount ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($upgrade->totalLevelIncome ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($upgrade->totalRankIncome ?? 0), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($netIncome ?? 0), 2); ?></td>
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