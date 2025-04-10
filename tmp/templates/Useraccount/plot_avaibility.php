<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">Plot Availability</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Plot Availability
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row nopadding table-cotainer margin-top-20">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
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
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>