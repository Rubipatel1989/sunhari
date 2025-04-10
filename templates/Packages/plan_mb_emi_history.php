<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Plan MB Bill History</h3>
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
          Plan MB Bill History
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
      <div class="col-sm-12 text-center">
        Pakage Amount : Rs <strong><?php echo number_format($package->amount, 2); ?></strong>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
            <table id="table-with-download" class="table table-bordered table-hover table-striped w-100">
               <thead>
                  <tr>
                    <th>Sr</th>
                    <th style="white-space: nowrap;">Title</th>
                    <th style="white-space: nowrap;">Status</th>
                    <th style="white-space: nowrap;">Date</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                    $i = 1;
                  $ends = array('th','st','nd','rd','th','th','th','th','th','th');
                  foreach($bills as $bill) {
                    if (($i %100) >= 11 && ($i%100) <= 13) {
                       $abbreviation = $i. 'th';
                    } else {
                       $abbreviation =$i. $ends[$i % 10];
                    }
                    ?>
                      <tr class="gradeX">
                        <td><?php echo $i; ?></td>
                        <td style="white-space: nowrap;"><?php echo $abbreviation; ?> Bill</td>
                        <td style="white-space: nowrap;">
                          <?php
                            $status_cls = 'inactive-staus';
                            $status_txt = 'Pending';
                            if($bill->status >= 1){
                              $status_cls = 'active-staus';
                              $status_txt = 'Paid';
                            }?>
                            <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                        </td>
                        <td style="white-space: nowrap;">
                          <?php echo date("d M Y", strtotime($bill->created)) ?>
                        </td>
                      </tr>
                  <?php
                    $i++;
                  }
                  for($j=$i; $j < 17;  $j++) {
                    if (($i %100) >= 11 && ($i%100) <= 13) {
                       $abbreviation = $i. 'th';
                    } else {
                       $abbreviation =$i. $ends[$i % 10];
                    }
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td style="white-space: nowrap;"><?php echo $abbreviation; ?> Bill</td>
                      <td style="white-space: nowrap;">
                        <div class="whitetext-1 inactive-staus">Pending</div>
                      </td>
                      <td style="white-space: nowrap;">
                        NA
                      </td>
                    </tr>
                  <?php
                    $i++;
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