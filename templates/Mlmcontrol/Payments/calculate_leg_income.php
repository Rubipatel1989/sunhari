<?php
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
  Calculate Leg Income
</h3>
<div class="row">
  <div class="col-xs-12 padding-left-5 padding-right-5">
    <div class="col-xs-12 padding-left-10 padding-right-10">
      <div class="col-xs-12 nopadding ">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="col-xs-12 nopadding">
            <?php echo $this->Flash->render(); ?>
            </div>
            <?php echo $this->Form->create(NULL, array('id' => 'calculate_leg_income_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
              <div class="col-xs-12 nopadding table-cotainer">
                <div class="col-xs-12 nopadding margin-top-20">
                  <table id="packages" class="table table-striped table-hover">
                     <thead>
                        <tr>
                          <th style="white-space: nowrap;">Sr. No.</th>
                          <th style="white-space: nowrap;">User</th>
                          <th style="white-space: nowrap;">Total Matching Amount (In Rs)</th>
                          <th style="white-space: nowrap;">Per Member Matching Amount (In Rs)</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        if ($autoPools) {
                          $i=1;
                          foreach($autoPools as $autoPool){
                          ?>
                            <tr class="gradeX">
                              <td><?php echo $i; ?></td>
                              
                              <td style="white-space: nowrap;"><?php echo $autoPool->Users['username'].' ('.$autoPool->Details['first_name'].')'; ?></td>
                              <td>
                                <?php echo number_format($autoPool->total_matching_amount, 2); ?>
                              </td>
                               <td>
                                <?php echo number_format(($autoPool->total_matching_amount/40), 2); ?>
                              </td>
                            </tr>
                          <?php
                            $i++;
                          }
                        }?>
                     </tbody>
                  </table>
                </div>
              </div>
              <div class="col-xs-12 nopadding margin-top-15">
                <div class="col-xs-3 padding-left-10 padding-right-0">
                  <button type="submit" class="btn btn-primary" name="btn_payment_calculation">Submit</button>
                </div>
              </div>
            <?php echo $this->Form->end();?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>