<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Plan MB List</h3>
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
          Plan MB List
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
      </div>
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
                    <th style="white-space: nowrap;">Added By</th>
                    <th style="white-space: nowrap;">Amount</th>
                    <th style="white-space: nowrap;">Return Amount</th>
                    <th style="white-space: nowrap;">Number of Months</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $i = 1;
                  if($packages){
                    $arrOtherData = [];
                    foreach($packages as $package){
                      if($i <= 100) {?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo date("d M Y", strtotime($package->created)); ?></td>
                          <td style="white-space: nowrap;"><?php echo $package->Users['username']; ?></td>
                          <td style="white-space: nowrap;"><?php echo $package->Users['name']; ?></td>
                          <td style="white-space: nowrap;"><?php echo $package->Users['username'].' ('.$package->AddedBy['name'].')'; ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($package->amount, 2); ?></td>
                          <td style="white-space: nowrap;"><?php echo number_format($package->return_amount, 2); ?></td>
                          <td style="white-space: nowrap;"><?php echo $package->number_of_month; ?></td>
                        </tr>
                    <?php
                      } else {
                        $arrOtherData[] = [
                          $i,
                          date("d/m/y g:i a", strtotime($package->created)),
                          $package->Users['username'],
                          $package->Users['name'],
                          $package->Users['username'].' ('.$package->AddedBy['name'].')',
                          number_format($package->amount, 2),
                          number_format($package->return_amount, 2),
                          $package->number_of_month
                        ];
                      }
                      $i++;
                    }
                  }?>*
               </tbody>
            </table>
          </div>
          <?php
          if ($i > 100) {?>
            <div class="row margin-top-10">
              <button id="loadMoreRow" type="button" class="btn btn-primary" style="width: 132px;">Load full data</button>
            </div>
          <?php
          }?>
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
        table.rows.add(<?php echo json_encode($arrOtherData); ?>);
        table .draw();
      });
    });
</script>