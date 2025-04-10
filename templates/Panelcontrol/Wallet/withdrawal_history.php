<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Withdrawal History</h3>
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
          Withdrawal History  
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
            <?php echo $this->Form->create(NULL, array('id' => 'fund_request_bulk_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?> 
              <div class="col-xs-12 nopadding">
                <table id="packages" class="table table-striped table-hover">
                   <thead>
                      <tr>
                        <th style="white-space: nowrap;">Sr. No.</th>
                        <th style="white-space: nowrap;">User Id</th>
                        <th style="white-space: nowrap;">User Name</th>
                        <th style="white-space: nowrap;">Payout Amount</th>
                        <th style="white-space: nowrap;">Deduction</th>
                        <th style="white-space: nowrap;">Paid Amount</th>
                        <th style="white-space: nowrap;">Wallet Address</th>
                        <th style="white-space: nowrap;">Transaction Id</th>
                        <th style="white-space: nowrap;">Status</th>
                        <th style="white-space: nowrap;">Requested Date</th>
                        <th style="white-space: nowrap;">Approve/Reject Date</th>
                        <th style="white-space: nowrap;">Remark</th>
                      </tr>
                   </thead>
                   <tbody>
                    <?php
                    if(!empty($fundrequests)){
                      $i=1;
                      foreach($fundrequests as $fundrequest){
                        $amount = $fundrequest->btc_value;
                        $deduction = ($amount*10)/100;
                        $payoutAmount = $amount - $deduction;
                      ?>
                        <tr class="gradeX">
                          <td style="white-space: nowrap;"><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $fundrequest->Users['username']; ?></td>
                          <td style="white-space: nowrap;"><?php echo $fundrequest->Users['name']; ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($amount, 8); ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($deduction, 8); ?> (10%)</td>
                          <td style="white-space: nowrap;"><?php echo number_format($payoutAmount, 8); ?></td>
                          <td style="white-space: nowrap;"><?php echo $fundrequest->self_btc_address; ?></td>
                          <td style="white-space: nowrap;"><?php echo $fundrequest->transaction_id; ?></td>
                          <td style="white-space: nowrap;">
                            <?php
                            $status_cls = 'inactive-staus';
                            $status_txt = 'Pending';
                            if($fundrequest->status == 1){
                              $status_cls = 'active-staus';
                              $status_txt = 'Approved';
                            }elseif($fundrequest->status == 2){
                              $status_cls = 'inactive-staus';
                              $status_txt = 'Rejected';
                            }?>
                            <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                            <?php 
                            if($fundrequest->status == 2) {?>
                              <br><?php echo $fundrequest->reject_reason; ?>
                            <?php 
                            }?>
                          </td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($fundrequest->created); ?></span><?php echo date("d/m/y g:i a", strtotime($fundrequest->created)); ?></td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($fundrequest->admin_action_date); ?></span><?php echo date("d/m/y g:i a", strtotime($fundrequest->admin_action_date)); ?></td>
                          <td style="white-space: nowrap;"><?php echo html_entity_decode($fundrequest->remark); ?></td>
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
        <?php echo $this->Form->end();?>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>

<div class="modal fade" id="fund-req-approve-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scroll-long-outer-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="myLargeModalLabel">
          Withdrawal Approve
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php echo $this->Form->create(NULL, array('id' => 'withdraw_approve_reject_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
        <?php 
        echo $this->Form->input('Fundrequest.id', array('type' => 'hidden', 'id' => 'fund_request_id', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
        ?>
        <div class="modal-body">
          <div class="mb-3 height-64">
            <label>Transaction Id<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Fundrequest.transaction_id', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter transaction id')); 
            ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill px-4">
            <div class="d-flex align-items-center">
              Submit
            </div>
          </button>
          <button type="button" class="
              btn btn-light-danger
              text-danger
              font-weight-medium
              waves-effect
              text-start
              rounded-pill
            " data-bs-dismiss="modal">
            Close
          </button>
        </div>
      <?php echo $this->Form->end();?>
    </div>
  </div>
</div>
