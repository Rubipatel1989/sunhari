<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Airdrop List</h3>
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
          Airdrop List
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
                    <th>Name</th>
                    <th>Wallet Address</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Remark</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $i = 1;
                  foreach($airdrops as $airdrop){
                  ?>
                      <tr class="gradeX">
                        <td><?php echo $i; ?></td>
                        <td style="white-space: nowrap;"><?php echo $airdrop->name; ?></td>
                        <td style="white-space: nowrap;"><?php echo $airdrop->wallet_address; ?></td>
                        <td>$<?php echo number_format($airdrop->amount, 2); ?></td>
                        <td><span style="display:none;"><?php echo strtotime($airdrop->created); ?></span><?php echo date('d/m/y g:i a', strtotime($airdrop->created)); ?></td>
                        <td><?php echo $airdrop->remark; ?></td>
                      </tr>
                  <?php
                      $i++;
                    }
                  ?>
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