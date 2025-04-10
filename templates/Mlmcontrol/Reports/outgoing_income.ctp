<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
  Outgoing Payments
</h3>
<div class="row">
  <div class="col-xs-12 padding-left-5 padding-right-5">
    <div class="col-xs-12 padding-left-10 padding-right-10">
      <div class="col-xs-12 nopadding text-right action-container">
         Total Outgoing Amount : <strong><?php echo number_format($totalOutgoingPayment, 2); ?></strong>
      </div>
      <div class="col-xs-12 nopadding ">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="col-xs-12 nopadding">
              <?php echo $this->Flash->render(); ?>
            </div>
            <div class="col-xs-12 nopadding table-cotainer">
              <div class="col-xs-12 nopadding">
                <form name="search_closing_detais_form" id="search_closing_detais_form" method="get">
                  <div class="col-sm-3 padding-left-0 padding-right-7">
                    <div class="dob input-group date">
                      <?php 
                      $from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
                      echo $this->Form->input('from_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $from_date));
                      ?>
                      <span class="input-group-addon">
                         <span class="fa fa-calendar"></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-3 padding-left-7 padding-right-3">
                    <div class="dob input-group date">
                      <?php 
                      $to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';
                      echo $this->Form->input('to_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $to_date));
                      ?>
                      <span class="input-group-addon">
                         <span class="fa fa-calendar"></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-2 padding-left-4 padding-right-4">
                    <?php 
                    $lower_amount = isset($_GET['lower_amount']) ? trim($_GET['lower_amount']) : '';
                    echo $this->Form->input('lower_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => "Lower Amount", 'value' => $lower_amount));
                    ?>
                  </div>
                  <div class="col-sm-2 padding-left-4 padding-right-4">
                    <?php 
                    $higher_amount = isset($_GET['higher_amount']) ? trim($_GET['higher_amount']) : '';
                    echo $this->Form->input('higher_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => "Higher Amount", 'value' => $higher_amount));
                    ?>
                  </div>
                  <div class="col-sm-2 padding-left-10 padding-right-0">
                    <button type="submit" class="btn btn-square btn-primary">Search</button>
                  </div>
                </form>
              </div>
              <div class="col-xs-12 nopadding margin-top-20">
                <table id="packages" class="table table-striped table-hover">
                   <thead>
                      <tr>
                        <th style="white-space: nowrap;">Sr. No.</th>
                        <th style="white-space: nowrap;">Date</th>
                        <th style="white-space: nowrap;">Username</th>
                        <th style="white-space: nowrap;">Name</th>
                        <th style="white-space: nowrap;">Contact Number</th>
                        <th style="white-space: nowrap;">Amount</th>
                      </tr>
                   </thead>
                   <tbody>
                      <?php
                     /* echo '<pre>';
                      print_r($payments);*/
                      if(!empty($payments)){
                        $i=1;
                        foreach($payments as $payment){
                          
                        ?>
                          <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td style="white-space: nowrap;">
                              <?php echo date('d-m-Y', strtotime($payment->created)); ?>
                            </td>
                            <td style="white-space: nowrap;">
                              <?php echo $payment->Users['username']; ?>
                            </td>
                            <td><?php echo $payment->Details['first_name'].' '.$payment->Details['last_name']; ?></td>
                            <td><?php echo $payment->Details['contact_no']; ?></td>
                            <td><?php echo number_format($payment->total, 2); ?></td>
                          </tr>
                        <?php
                          $i++;
                        }
                      }?>
                   </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>