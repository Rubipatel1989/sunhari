<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active"> Post Report</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                       Post Report
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="col-xs-12 nopadding">
                          <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <div class="row ">
                              <div class="col-sm-3 padding-left-0 padding-right-7">
                                <div class="input-group">
                                  <?php  
                                  $from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
                                  echo $this->Form->input('from_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $from_date)); 
                                  ?>
                                  <div class="input-group-append">
                                     <span class="input-group-text fs-xl">
                                         <i class="fal fa-calendar"></i>
                                     </span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-3 padding-left-7 padding-right-0">
                                <div class="input-group">
                                  <?php  
                                  $to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';
                                  echo $this->Form->input('to_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "To Date", 'value' => $to_date));
                                  ?>
                                  <div class="input-group-append">
                                     <span class="input-group-text fs-xl">
                                         <i class="fal fa-calendar"></i>
                                     </span>
                                  </div>
                                </div>
                              </div>
                              
                              
                              <div class="col-xs-8 padding-left-10 padding-right-0" style="width: 100px; float: left;">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="row nopadding table-cotainer margin-top-20">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                   <th>Sr. No.</th>
                                   <th>Position</th>
                                   <th>Total Amount</th>
                                </tr>
                             </thead>
                             <tbody>
                                  <?php 
                                  if(isset($totalbusiness) && count($totalbusiness) > 0){
                                      $i=1;
                                      foreach($totalbusiness as $totalbusi){
                                          
                                      ?>
                                          <tr class="gradeX">
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $totalbusi['position']; ?></td>
                                              <td><?php echo $totalbusi['total_amount']; ?></td>
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