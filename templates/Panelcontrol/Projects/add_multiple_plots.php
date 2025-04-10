<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Plot</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                       Plot Details
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <?php echo $this->Form->create(NULL, array('id' => 'add_multiple_plot_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>

                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Property<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Property-'];
                                      foreach($properties as $property){
                                        $options[$property->id] = $property->title;
                                      }
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('Plot.property_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'onchange' => 'FilterSiteByProperty(this.value, "site_container", "Plot.site_id", "form-control loginbox");')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Site<span class="red">*</span></label>
                                   <div id="site_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Site-'];
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('Plot.site_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'onchange' => 'FilterBlockBySite(this.value, "block_container", "Plot.block_id", "form-control loginbox");')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Block<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Block-'];
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('Plot.block_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected)); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">File<span class="red">*</span></label>
                                   <div class="col-sm-8 margin-top-6">
                                      <?php echo $this->Form->input('plot_file', array('type' => 'file', 'class' => 'plot-file', 'label' => false, 'div' => false)); ?>
                                      <a class="download-plot-file" href="<?php echo $home_url;?>/plots_demo.xlsx" download>Download Sample File</a>
                                   </div>
                                </div>
                              </fieldset>
                              
                              
                              
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/projects/plots" class="btn btn-square btn-danger">Cancel</a>
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