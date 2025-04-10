<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Payment History</h3>
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
          Payment History
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
                    <th style="white-space: nowrap;">Date</th>
                    <th style="white-space: nowrap;">Amount</th>
                    <th style="white-space: nowrap;">Transaction Id</th>
                    <th style="white-space: nowrap;">Status</th>
                    <th style="white-space: nowrap;">Remark</th>
                    <th style="white-space: nowrap;">Rejection Remark</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if($pendingUpgrades){
                    $i = 1;
                    foreach($pendingUpgrades as $pendingUpgrade){
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($pendingUpgrade->created); ?></span><?php echo date("d/m/y g:i a", strtotime($pendingUpgrade->created)); ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($pendingUpgrade->amount, 2); ?></td>
                          <td><?php echo $pendingUpgrade->transaction_id; ?></td>
                          <td style="white-space: nowrap;">
                            <?php
                            $status_cls = 'inactive-staus';
                            $status_txt = 'Pending';
                            if($pendingUpgrade->status == 1){
                              $status_cls = 'active-staus';
                              $status_txt = 'Approved';
                            }elseif($pendingUpgrade->status == 2){
                              $status_cls = 'inactive-staus';
                              $status_txt = 'Rejected';
                            }?>
                            <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                          </td>
                          <td><?php echo $pendingUpgrade->remark; ?></td>
                          <td><?php echo $pendingUpgrade->rejection_remark; ?></td> 
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