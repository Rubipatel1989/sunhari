<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Tax & Commission</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                       Add Tax & Commission
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <?php echo $this->Form->create(NULL, array('id' => 'tax_commission_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <fieldset>
                            <div class="row margin-top-20">
                               <label class="col-sm-3 text-right">Tax (in %)<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Commission.tax', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Tax')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-20">
                               <label class="col-sm-3 text-right">Admin Commission (in %)<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Commission.amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Admin Commission')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-20">
                               <label class="col-sm-3 text-right">Remark<span class="red">*</span></label>
                               <div class="col-sm-8" style="height: 100px;">
                                  <?php echo $this->Form->input('Commission.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark..', 'style' => 'height:100px;')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-20">
                              <label class="col-sm-3 text-right"></label>
                              <div class="col-sm-8">
                                  <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                  &nbsp; <a href="<?php echo $backend_url ?>/setting/tax-and-commission" class="btn btn-square btn-danger">Cancel</a>
                              </div>
                            </div>
                          </fieldset>
                      <?php echo $this->Form->end();?>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>