<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Package</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Package Details
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       
                        <?php echo $this->Form->create(NULL, array('id' => 'add_package_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Name<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package Name')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Description</label>
                               <div class="col-sm-8">
                                  <?php echo $this->Form->input('Package.description', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package Description', 'style' => '100px;')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Package B.V.<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.package_bv', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package B.V.')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Package Amount<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.package_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package Amount')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Direct Amount<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.direct_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Direct Amount')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">ROI Amount<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.roi_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'ROI Amount')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Business Point<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.business_point', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Business Point')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Booster Time<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.booster_time', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Booster Time')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Booster Amount<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.booster_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Booster Amount')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Allowed Links<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php echo $this->Form->input('Package.allowed_links', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Allowed Links')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Image</label>
                               <div class="col-sm-8">
                                <div class="col-xs-12 nopadding margin-top-7">
                                  <div class="row nopadding ajax-upload">
                                    <div class="w-50 btn_browse">
                                      Choose file
                                    </div>
                                    <div class="w-50 nopadding">
                                      <button type="button" class="btn-browse">Browse</button>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xs-12 ajax-upload-container margin-top-10">
                                </div>
                               </div>
                            </div>
                          </fieldset>

                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Position<span class="red">*</span></label>
                               <div class="col-sm-2 height-37">
                                  <?php echo $this->Form->input('Package.position', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Position')); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Status<span class="red">*</span></label>
                               <div class="col-sm-2 height-37">
                                   <?php 
                                   $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
                                   echo $this->Form->input('Package.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                   ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                              <label class="col-sm-2 text-right"></label>
                              <div class="col-sm-10">
                                  <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                  &nbsp; <a href="<?php echo $backend_url ?>/packages" class="btn btn-square btn-danger">Cancel</a>
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
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>