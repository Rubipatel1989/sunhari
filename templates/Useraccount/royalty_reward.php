<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Royalty</h3>
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
          Royalty
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
                    <th style="white-space: nowrap;">User Id</th>
                    <th style="white-space: nowrap;">Name</th>
                    <th style="white-space: nowrap;">Monthly Business</th>
                    <th style="white-space: nowrap;">Payout</th>
                    <th style="white-space: nowrap;">Payout Date</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if($payouts){
                    $i = 1;
                    foreach($payouts as $payout){
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $payout->Users['username']; ?></td>
                          <td style="white-space: nowrap;"><?php echo $payout->Users['name']; ?></td>
                          <td style="white-space: nowrap;"><?php echo ($payout->monthly_business ?? 0); ?></td>
                          <td style="white-space: nowrap;"><?php echo ($payout->royalty_amount ?? 0); ?></td>
                          <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($payout->created); ?></span><?php echo date("d/m/y g:i a", strtotime($payout->created)); ?></td>
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