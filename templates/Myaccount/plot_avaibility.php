<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Plots
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
              
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="wallets" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Property</th>
                                  <th>Site</th>
                                  <th>Block</th>
                                  <th>Property Type</th>
                                  <th>Plot Number</th>
                                  <th>Area</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($plots)){
                                  $i=1;
                                  foreach($plots as $plot){?>
                                    <tr class="gradeX">
                                      <td style="vertical-align: top;"><?php echo $i; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->Properties['title']; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->Sites['title']; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->Blocks['title']; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->name; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->plot_number; ?></td>
                                      <td style="vertical-align: top; white-space: nowrap;">
                                        Area In Sqft : <strong><?php echo $plot->area; ?></strong>
                                        <br> Area In Sqyd : <strong><?php echo number_format($plot->area/9, 2); ?></strong>
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
                  </div>
            </div>
        </div>
    </div>
</div>