<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Withdrawal Report</h3>
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
          <a href="javascript:void(0)">Dashboard</a>
        </li>
        <li class="breadcrumb-item active d-flex align-items-center">
          Withdrawal Report
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
            <table id="table-with-download" class="table table-striped table-hover">
                 <thead>
                    <tr>
                      <th style="white-space: nowrap;">Sr. No.</th>
                      <th style="white-space: nowrap;">Payout Amount</th>
                      <th style="white-space: nowrap;">Deduction</th>
                      <th style="white-space: nowrap;">Paid Amount</th>
                      <th style="white-space: nowrap;">Status</th>
                      <th style="white-space: nowrap;">Approve/Rejected Date</th>
                      <th style="white-space: nowrap;">Requested Date</th>
                      <th style="white-space: nowrap;">Remark</th>
                      <th style="white-space: nowrap;">Tran. Id</th>
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
                          <td style="white-space: nowrap;"><?php echo number_format($amount, 2); ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($deduction, 2); ?> (10%)</td>
                          <td style="white-space: nowrap;"><?php echo number_format($payoutAmount, 2); ?></td>
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
                          </td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($fundrequest->admin_action_date); ?></span><?php echo date("d/m/y g:i a", strtotime($fundrequest->admin_action_date)); ?></td>
                          <td style="white-space: nowrap;"><?php echo strtotime($fundrequest->created); ?></span><?php echo date("d/m/y g:i a", strtotime($fundrequest->created)); ?></td>
                          <td style="white-space: nowrap;"><?php echo html_entity_decode($fundrequest->remark); ?></td>
                          <td style="white-space: nowrap;"><?php echo $fundrequest->transaction_id; ?></td>
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