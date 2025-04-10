<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Assigned Plot Details
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
                        <div class="col-xs-12 nopadding">
                          <form name="assign_plot_form"  id="assign_plot_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Assignment Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">User :</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->Users['username'].' ('.$assignedPlotInfo->Details['first_name'].' '.$assignedPlotInfo->Details['last_name'].')' ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Property :</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->Properties['title']; ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Site</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->Sites['title']; ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Block<span class="red">*</span></label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->Blocks['title']; ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Plot Number<span class="red">*</span></label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->plot_number; ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Plot Type</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->Plots['name']; ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Area (In Sqyd)</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->area; ?>
                                   </div>
                                </div>
                              </fieldset>
                              <!-- <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Area (In Sqyd)</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo number_format($assignedPlotInfo->area/9, 2); ?>
                                   </div>
                                </div>
                              </fieldset> -->
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">PLC (In %)</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->plc; ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Plan<span class="red">*</span></label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php
                                      $currentPlan = $currentRatesTable->getCurrentPlanById($assignedPlotInfo->plan); 
                                      echo $currentPlan; 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Current Rate</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $assignedPlotInfo->current_rate; ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Total Amount</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo number_format($assignedPlotInfo->total_amount, 2); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">PLC Amount</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo number_format($assignedPlotInfo->plc_amount, 2); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Grand Total</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo number_format($assignedPlotInfo->grand_total, 2); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Discount (Fixed)</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo number_format($assignedPlotInfo->discount, 2); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Remark</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo html_entity_decode($assignedPlotInfo->remark); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      &nbsp; <a href="<?php echo $backend_url ?>/user/assigned-plots" class="btn btn-square btn-danger">Back</a>
                                  </div>
                                </div>
                              </fieldset>
                          </form>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>