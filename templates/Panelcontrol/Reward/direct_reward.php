<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">  Direct Rewards</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Direct Rewards
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12">
                         <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                          <div class="row nopadding">
                            <div class="col nopadding">
                              <?php 
                              $options = ['' => '-Select Username-'];
                              foreach($users as $user){
                                $options[$user->Users['id']] = $user->Users['username'].' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                              }
                              $selected = isset($_GET['user_id']) ? $_GET['user_id'] : '';
                              echo $this->Form->input('user_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox select2', 'default' => $selected)); 
                               ?>
                            </div>
                            <div class="col padding-left-10 padding-right-0">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <?php
                      if(isset($_GET['user_id']) && !empty($_GET['user_id'])){?>
                        <div class="row nopadding table-cotainer margin-top-20">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                              <tr>
                                <th style="white-space: nowrap;">Sr. No.</th>
                                <th style="white-space: nowrap;">Plot Sale</th>
                                <th style="white-space: nowrap;">Within Days</th>
                                <th style="white-space: nowrap;">Lifetime Plot Sale</th>
                                <th style="white-space: nowrap;">Reward</th>
                                <th style="white-space: nowrap;">Is Achieved</th>
                                <th style="white-space: nowrap;">Status</th>
                                <th style="white-space: nowrap;">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr class="gradeX">
                                <td>
                                  1
                                </td>
                                <td>
                                  8 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  130
                                </td>
                                <td>
                                  12 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Home Furniture
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_direct_home_furniture) && $achievedRewardInfo->is_direct_home_furniture == 1){
                                    echo 'Yes';
                                  }else{
                                    echo 'No';
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  $status_cls = 'inactive-staus';
                                  $status_txt = 'Pending';
                                  if(isset($achievedRewardInfo->is_direct_home_furniture_status) && $achievedRewardInfo->is_direct_home_furniture_status == 1){
                                    $status_cls = 'active-staus';
                                    $status_txt = 'Paid';
                                  }
                                  ?>
                                  <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                </td>
                                <td>
                                  <div class="btn-group">
                                    <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                    </button>
                                    <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_direct_home_furniture_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_direct_home_furniture_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr class="gradeX">
                                <td>
                                  2
                                </td>
                                <td>
                                  16 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  130
                                </td>
                                <td>
                                  24 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Passion Pro
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_direct_bike) && $achievedRewardInfo->is_direct_bike == 1){
                                    echo 'Yes';
                                  }else{
                                    echo 'No';
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  $status_cls = 'inactive-staus';
                                  $status_txt = 'Pending';
                                  if(isset($achievedRewardInfo->is_direct_bike_status) && $achievedRewardInfo->is_direct_bike_status == 1){
                                    $status_cls = 'active-staus';
                                    $status_txt = 'Paid';
                                  }
                                  ?>
                                  <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                </td>
                                <td>
                                  <div class="btn-group">
                                    <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                    </button>
                                    <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_direct_bike_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_direct_bike_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>

                              <tr class="gradeX">
                                <td>
                                  3
                                </td>
                                <td>
                                  24 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  130
                                </td>
                                <td>
                                  36 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  kwid
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_direct_kwid) && $achievedRewardInfo->is_direct_kwid == 1){
                                    echo 'Yes';
                                  }else{
                                    echo 'No';
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  $status_cls = 'inactive-staus';
                                  $status_txt = 'Pending';
                                  if(isset($achievedRewardInfo->is_direct_kwid_status) && $achievedRewardInfo->is_direct_kwid_status == 1){
                                    $status_cls = 'active-staus';
                                    $status_txt = 'Paid';
                                  }
                                  ?>
                                  <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                </td>
                                <td>
                                  <div class="btn-group">
                                    <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                    </button>
                                    <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_direct_kwid_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_direct_kwid_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr class="gradeX">
                                <td>
                                  4
                                </td>
                                <td>
                                  45 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  270
                                </td>
                                <td>
                                  65 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Swift
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_direct_swift) && $achievedRewardInfo->is_direct_swift == 1){
                                    echo 'Yes';
                                  }else{
                                    echo 'No';
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  $status_cls = 'inactive-staus';
                                  $status_txt = 'Pending';
                                  if(isset($achievedRewardInfo->is_direct_swift_status) && $achievedRewardInfo->is_direct_swift_status == 1){
                                    $status_cls = 'active-staus';
                                    $status_txt = 'Paid';
                                  }
                                  ?>
                                  <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                </td>
                                <td>
                                  <div class="btn-group">
                                    <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                    </button>
                                    <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_direct_swift_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_direct_swift_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr class="gradeX">
                                <td>
                                  5
                                </td>
                                <td>
                                  71 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  390
                                </td>
                                <td>
                                  95 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Artica
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_direct_artica) && $achievedRewardInfo->is_direct_artica == 1){
                                    echo 'Yes';
                                  }else{
                                    echo 'No';
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  $status_cls = 'inactive-staus';
                                  $status_txt = 'Pending';
                                  if(isset($achievedRewardInfo->is_direct_artica_status) && $achievedRewardInfo->is_direct_artica_status == 1){
                                    $status_cls = 'active-staus';
                                    $status_txt = 'Paid';
                                  }
                                  ?>
                                  <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                </td>
                                <td>
                                  <div class="btn-group">
                                    <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                    </button>
                                    <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_direct_artica_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_direct_artica_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr class="gradeX">
                                <td>
                                  6
                                </td>
                                <td>
                                  95 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  490
                                </td>
                                <td>
                                  135 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Scorpio
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_direct_scorpio) && $achievedRewardInfo->is_direct_scorpio == 1){
                                    echo 'Yes';
                                  }else{
                                    echo 'No';
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  $status_cls = 'inactive-staus';
                                  $status_txt = 'Pending';
                                  if(isset($achievedRewardInfo->is_direct_scorpio_status) && $achievedRewardInfo->is_direct_scorpio_status == 1){
                                    $status_cls = 'active-staus';
                                    $status_txt = 'Paid';
                                  }
                                  ?>
                                  <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                </td>
                                <td>
                                  <div class="btn-group">
                                    <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                    </button>
                                    <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_direct_scorpio');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_direct_scorpio');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr class="gradeX">
                                <td>
                                  7
                                </td>
                                <td>
                                  142 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  590
                                </td>
                                <td>
                                  195 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  BMW or 2BHK Flat
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_direct_bmw) && $achievedRewardInfo->is_direct_bmw == 1){
                                    echo 'Yes';
                                  }else{
                                    echo 'No';
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  $status_cls = 'inactive-staus';
                                  $status_txt = 'Pending';
                                  if(isset($achievedRewardInfo->is_direct_bmw_status) && $achievedRewardInfo->is_direct_bmw_status == 1){
                                    $status_cls = 'active-staus';
                                    $status_txt = 'Paid';
                                  }
                                  ?>
                                  <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                </td>
                                <td>
                                  <div class="btn-group">
                                    <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                    </button>
                                    <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_direct_bmw_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_direct_bmw_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr class="gradeX">
                                <td>
                                  8
                                </td>
                                <td>
                                  195 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  810
                                </td>
                                <td>
                                  195 Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Audi Q7 or 4BHK Flat
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_direct_audi) && $achievedRewardInfo->is_direct_audi == 1){
                                    echo 'Yes';
                                  }else{
                                    echo 'No';
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  $status_cls = 'inactive-staus';
                                  $status_txt = 'Pending';
                                  if(isset($achievedRewardInfo->is_direct_audi_status) && $achievedRewardInfo->is_direct_audi_status == 1){
                                    $status_cls = 'active-staus';
                                    $status_txt = 'Paid';
                                  }
                                  ?>
                                  <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                </td>
                                <td>
                                  <div class="btn-group">
                                    <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                    </button>
                                    <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_direct_audi_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_direct_audi_status');?>/<?php echo base64_encode($backend_url.'/reward/direct-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                           </tbody>
                          </table>
                        </div> 
                      <?php
                      }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>