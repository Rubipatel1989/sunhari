<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Wallet History</h3>
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
          Wallet History
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
    <?php
    if ($totalWalletInfo) {?>
      <div class="row">
        <div class="col-sm-12 text-right padding-right-30 margin-bottom-10">
          Total Balance: <strong><?php echo number_format($totalWalletInfo->total_wallets_amount, 2); ?></strong>
        </div>
      </div>
    <?php 
    }?>
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
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if($wallets){
                    $i = 1;
                    foreach($wallets as $wallet){
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($wallet->created); ?></span><?php echo date("d-M-Y", strtotime($wallet->created)); ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($wallet->amount, 2); ?></td>
                          <td><?php echo $wallet->transaction_id; ?></td>
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