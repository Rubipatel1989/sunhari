<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Revenue Reward</h3>
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
          Revenue Reward
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
            <table id="table-with-download" class="table table-bordered table-hover table-striped w-100">
               <thead>
                  <tr>
                    <th>Sr</th>
                    <th style="white-space: nowrap;">Package</th>
                    <th style="white-space: nowrap;">Payout</th>
                    <th style="white-space: nowrap;">No. of Day</th>
                    <th style="white-space: nowrap;">Earning Upto</th>
                    <th style="white-space: nowrap;">Total Earning</th>
                    <th style="white-space: nowrap;">Activation Date</th>
                    <th style="white-space: nowrap;">View</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if($upgrades){
                    $i = 1;
                    foreach($upgrades as $upgrade){
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($upgrade->package_amount, 2); ?></td>
                          <td><?php echo number_format($upgrade->roi_amount, 2); ?></td>
                          <td style="white-space: nowrap;"><?php echo $upgrade->total_roi_count; ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format(($upgrade->package_amount*2), 2); ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format(($upgrade->total_roi), 2); ?></td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($upgrade->created); ?></span><?php echo date("d/m/y g:i a", strtotime($upgrade->created)); ?></td>
                          <td style="white-space: nowrap;"><a href="javascript:showAmountDetails('Aojora Reward', 'roi', '<?php echo $user['id']; ?>', '<?php echo $upgrade->package_amount; ?>');">Details</a></td>
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

<button type="button" id="amount_link" class="
    btn btn-light-success
    text-success
    font-weight-medium
    btn-lg
    px-4
    fs-4
    font-weight-medium
  " data-bs-toggle="modal" data-bs-target="#amount_container" style="display: none;">
  Success Alert
</button>
<div class="modal fade" id="amount_container" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 id="amount_title" class="modal-title" id="myLargeModalLabel"></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="tbl_aojora_amount_container" class="modal-body">
          goes here
        </div>
        <div class="modal-footer">
          <button type="button" class="
              btn btn-light-danger
              text-danger
              font-weight-medium
              waves-effect
              text-start
            " data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>