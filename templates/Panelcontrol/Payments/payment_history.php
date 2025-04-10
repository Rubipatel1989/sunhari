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
      <div class="col-sm-12 margin-bottom-20">
        <form name="filter_form" id="filter_form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <div class="row nopadding">
            <div class="col padding-left-0">
              <?php 
              $payment_for = isset($_GET['payment_for']) ? $_GET['payment_for'] : '';
              $options = ['' => 'Payment For', 1 => 'Credit to Wallet', 2 => 'EMI Payment'];
              echo $this->Form->input('payment_for', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter User Id', 'default' => $payment_for)); 
               ?>
            </div>
            <div class="col nopadding">
              <?php 
              $username = isset($_GET['username']) ? $_GET['username'] : '';
              echo $this->Form->input('username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter User Id', 'value' => $username)); 
               ?>
            </div>
            <div class="col">
              <?php 
              $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
              echo $this->Form->input('from_date', array('type' => 'date', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter From Date', 'value' => $from_date)); 
               ?>
            </div>
            <div class="col nopadding">
              <?php 
              $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
              echo $this->Form->input('to_date', array('type' => 'date', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter To Date', 'value' => $to_date)); 
               ?>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
               <thead>
                  <tr>
                    <th>Sr</th>
                    <th style="white-space: nowrap;">Date</th>
                    <th style="white-space: nowrap;">User Id</th>
                    <th style="white-space: nowrap;">Name</th>
                    <th style="white-space: nowrap;">Amount</th>
                    <th style="white-space: nowrap;">Transaction Id</th>
                    <th style="white-space: nowrap;">Used For</th>
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
                        $paymentFor = 'Credit To Wallet';
                        if ($pendingUpgrade->payment_for == 2) {
                          $paymentFor = 'EMI Payment';
                        }
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo date("d/m/y g:i a", strtotime($pendingUpgrade->created)); ?></td>
                          <td style="white-space: nowrap;"><?php echo $pendingUpgrade->Users['username']; ?></td>
                          <td style="white-space: nowrap;"><?php echo $pendingUpgrade->Users['name']; ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($pendingUpgrade->amount, 2); ?></td>
                          <td style="white-space: nowrap;"><?php echo $pendingUpgrade->transaction_id; ?></td>
                          <td style="white-space: nowrap;"><?php  echo $paymentFor; ?></td>
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
<button type="button" id="approve_link" class="
    btn btn-light-success
    text-success
    font-weight-medium
    btn-lg
    px-4
    fs-4
    font-weight-medium
  " data-bs-toggle="modal" data-bs-target="#approve_popup" style="display: none;">
  Approve
</button>

<div class="modal fade" id="approve_popup" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 id="amount_title" class="modal-title" id="myLargeModalLabel">Approve Payment</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create(NULL, array('id' => 'payment_approve_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <?php
          echo $this->Form->input('PendingUpgrade.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox payment_box_id')); 
          ?>
          <div class="row height-64">
            <div class="col-sm-3 text-right">
              Payment Use for<span class="red">*</span>
            </div>
            <div class="col-sm-9 text-left">
              <?php 
              $options = ['' => '-Select-', 'activation' => 'Activation', 'upgradation' => 'Upgradation'];
              echo $this->Form->input('PendingUpgrade.used_for', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
              ?>
            </div>
          </div>
          <div class="row margin-top-20">
            <div class="col-sm-3 text-right">
              
            </div>
            <div class="col-sm-9 text-left">
             <button type="submit" name="btn_approve" class="btn btn-success px-4">
                <div class="d-flex align-items-center">
                  Submit
                </div>
              </button>
              <button type="button" class=" btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        <?php echo $this->Form->end();?>
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<button type="button" id="reject_link" class="
    btn btn-light-success
    text-success
    font-weight-medium
    btn-lg
    px-4
    fs-4
    font-weight-medium
  " data-bs-toggle="modal" data-bs-target="#reject_popup" style="display: none;">
  Reject
</button>
<div class="modal fade" id="reject_popup" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 id="amount_title" class="modal-title" id="myLargeModalLabel">Reject Payment</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create(NULL, array('id' => 'payment_reject_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <?php
          echo $this->Form->input('PendingUpgrade.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox payment_box_id')); 
          ?>
          <div class="row" style="height: 120px;">
            <div class="col-sm-3 text-right">
              Remark<span class="red">*</span>
            </div>
            <div class="col-sm-9 text-left">
              <?php echo $this->Form->input('PendingUpgrade.rejection_remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter remark', 'style' => 'height: 100px;')); ?>
            </div>
          </div>
          <div class="row margin-top-20">
            <div class="col-sm-3 text-right">
              
            </div>
            <div class="col-sm-9 text-left">
             <button type="submit" name="btn_reject" class="btn btn-success px-4">
                <div class="d-flex align-items-center">
                  Submit
                </div>
              </button>
              <button type="button" class=" btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        <?php echo $this->Form->end();?>
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>