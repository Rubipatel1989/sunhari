<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Aojora Reward</h3>
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
          Aojora Reward
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
                    <th style="white-space: nowrap;">Package Amount</th>
                    <th style="white-space: nowrap;">Payout Amount</th>
                    <th style="white-space: nowrap;">Number of Day</th>
                    <th style="white-space: nowrap;">Total Amount</th>
                    <th style="white-space: nowrap;">Total Earning</th>
                    <th style="white-space: nowrap;">Date</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $arrOtherPayouts = [];
                  if($payouts){
                    $i = 1;
                    foreach($payouts as $payout){
                      if($i <= 100) {
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $payout->Users['username']; ?></td>
                          <td style="white-space: nowrap;"><?php echo $payout->Users['name']; ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format($payout->package_amount, 2); ?></td>
                          <td>$<?php echo number_format($payout->roi, 2); ?></td>
                          <td style="white-space: nowrap;"><?php echo $payout->total_roi_count; ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($payout->package_amount*2), 2); ?></td>
                          <td style="white-space: nowrap;">$<?php echo number_format(($payout->total_roi), 2); ?></td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($payout->Upgrades['created']); ?></span><?php echo date("d/m/y g:i a", strtotime($payout->Upgrades['created'])); ?></td>
                        </tr>
                    <?php
                      } else {
                        $upgadedDate = '<span style="display:none;">'.strtotime($payout->Upgrades['created']).'</span> '.date("d/m/y g:i a", strtotime($payout->Upgrades['created']));
                        $arrOtherPayouts[] = [
                          $i,
                          $payout->Users['username'],
                          $payout->Users['name'],
                          number_format($payout->package_amount, 2),
                          number_format($payout->roi, 2),
                          $payout->total_roi_count,
                          number_format(($payout->package_amount*2), 2),
                          number_format(($payout->total_roi), 2),
                          $upgadedDate
                        ];
                      }
                      $i++;
                    }
                  }?>
               </tbody>
            </table>
          </div>
          <div class="row margin-top-10">
              <button id="loadMoreRow" type="button" class="btn btn-primary" style="width: 132px;">Load full data</button>
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
<script type="text/javascript">
    $(document).ready(function(){
      $("#loadMoreRow").click(function(){
        $(this).hide();
        var table = $('#packages').DataTable();
        table.rows.add(<?php echo json_encode($arrOtherPayouts); ?>);
        table .draw();
      });
    });
</script>