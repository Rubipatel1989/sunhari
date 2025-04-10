<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Lesar List</h3>
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
          Lesar List
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

        <div class="row nopadding table-cotainer">
          <table id="packages" class="table table-bordered table-hover table-striped w-100">
             <thead>
                <tr>
                  <th>Sr</th>
                  <th style="white-space:nowrap;">Date</th>
                  <th style="white-space:nowrap;">Userid</th>
                  <th style="white-space:nowrap;">Name</th>
                  <th style="white-space:nowrap;">Payment Type</th>
                  <th style="white-space:nowrap;">Amount</th>
                  <th style="white-space:nowrap;">Transacton Info</th>
                  <th style="white-space:nowrap;">Remark</th>
                </tr>
             </thead>
             <tbody>
                <?php
                $arrOtherLesars = [];
                $i=1;
                if(!empty($lesars)) {
                  foreach($lesars as $lesar) {
                    $paymentType = 'Credit';
                    if ($lesar->payment_type == 'debit') {
                      $paymentType = 'Debit';
                    }
                    $transactionInfo = '';
                    if ($lesar->payment_mode == 'net_banking') {
                      $transactionInfo .= 'Bank Name : <strong>'.$lesar->bank_name.'</strong>';
                      $transactionInfo .= '<br> Account Number : <strong>'.$lesar->account_number.'</strong>';
                      $transactionInfo .= '<br> IFSC Code : <strong>'.$lesar->ifsc_code.'</strong>';
                      $transactionInfo .= '<br> Transaction Id : <strong>'.$lesar->transaction_id.'</strong>';
                    } else {
                      $transactionInfo .= 'Voucher Code : <strong>'.$lesar->voucher_code.'</strong>';
                    }
                    if($i <= 100) {?>
                      <tr class="gradeX">
                        <td style="white-space: nowrap;"><?php echo $i; ?></td>
                        <td style="white-space: nowrap;"><?php echo date('d M Y', strtotime($lesar->created)); ?></td>
                        <td style="white-space: nowrap;"><?php echo $lesar->Users['username']; ?></td>
                        <td style="white-space:nowrap;"><?php echo $lesar->Users['name']; ?></td>
                        <td style="white-space: nowrap;"><?php echo $paymentType; ?></td>
                        <td style="white-space: nowrap;"><?php echo number_format($lesar->amount, 2); ?></td>
                        <td style="white-space: nowrap;">
                          <?php echo $transactionInfo; ?>
                        </td>
                        <td style="white-space: nowrap;"><?php echo $lesar->remark; ?></td>
                      </tr>
                  <?php
                    } else {
                      $arrOtherUser[] =[
                        $i, 
                        $lesar->Users['username'], 
                        $lesar->Users['name'], 
                        $paymentType, 
                        number_format($lesar->amount, 2), 
                        $transactionInfo,
                        $lesar->remark
                      ];
                    }
                    $i++;
                  }
                }?>
             </tbody>
          </table>
        </div> 
        
        <?php
        if ($i > 100) {?>
          <div class="row margin-top-10">
            <div class="col-sm-12">
              <button id="loadMoreRow" type="button" class="btn btn-small btn-success rounded-pill px-4">Load full data</button>
            </div>
          </div>
        <?php 
        }?>
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
        table.rows.add(<?php echo json_encode($arrOtherUser); ?>);
        table .draw();
      });
    });
</script>