<?php
echo $this->Html->css('frontend/css/my-account.css');
echo $this->Html->css('frontend/css/tree.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Pair Rewards
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding">
              <div class="panel panel-default" style="min-height: 400px;">
                <div class="panel-body">
                  <div class="col-xs-12 nopadding">
                    <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                      <div class="col-xs-12 nopadding">
                        <div class="col-xs-2 nopadding" style="width: 150px; float: left;">
                          <?php 
                          $options = ['' => '-Select Username-'];
                          foreach($users as $user){
                            $options[$user->Users['id']] = $user->Users['username'].' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                          }
                          $selected = isset($_GET['user_id']) ? $_GET['user_id'] : '';
                          echo $this->Form->input('user_id', array('type' => 'select', 'id' => 'select_username', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'data-live-search' => "true")); 
                           ?>
                        </div>
                        <div class="col-xs-6 padding-left-10 padding-right-0" style="width: 100px; float: left;">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <?php
                  if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
                    /*echo $encurl = base64_encode($backend_url.'/reward/pair-reward');
                    echo '<br>';
                    echo base64_decode($encurl);*/
                  ?>
                    <div class="col-xs-12 nopadding table-cotainer margin-top-20">
                      <div class="col-xs-12 nopadding">
                        <table id="packages" class="table table-striped table-hover">
                           <thead>
                              <tr>
                                <th style="white-space: nowrap;">Sr. No.</th>
                                <th style="white-space: nowrap;">Pair Plot Sale</th>
                                <th style="white-space: nowrap;">Within Days</th>
                                <th style="white-space: nowrap;">Lifetime Pair Plot Sale</th>
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
                                  22 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  130
                                </td>
                                <td>
                                  72 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Home Furniture
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_pair_home_furniture) && $achievedRewardInfo->is_pair_home_furniture == 1){
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
                                  if(isset($achievedRewardInfo->is_pair_home_furniture_status) && $achievedRewardInfo->is_pair_home_furniture_status == 1){
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
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_pair_home_furniture_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_pair_home_furniture_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Pending</a> 
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
                                  72 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  130
                                </td>
                                <td>
                                  111 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  kwid
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_pair_kwid) && $achievedRewardInfo->is_pair_kwid == 1){
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
                                  if(isset($achievedRewardInfo->is_pair_kwid_status) && $achievedRewardInfo->is_pair_kwid_status == 1){
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
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_pair_kwid_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_pair_kwid_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Pending</a> 
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
                                  141 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  270
                                </td>
                                <td>
                                  225 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Swift
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_pair_swift) && $achievedRewardInfo->is_pair_swift == 1){
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
                                  if(isset($achievedRewardInfo->is_pair_swift_status) && $achievedRewardInfo->is_pair_swift_status == 1){
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
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_pair_swift_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_pair_swift_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Pending</a> 
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
                                  215 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  390
                                </td>
                                <td>
                                  345 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Artica
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_pair_artica) && $achievedRewardInfo->is_pair_artica == 1){
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
                                  if(isset($achievedRewardInfo->is_pair_artica_status) && $achievedRewardInfo->is_pair_artica_status == 1){
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
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_pair_artica_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_pair_artica_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Pending</a> 
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
                                  295 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  490
                                </td>
                                <td>
                                  475 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Scorpio
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_pair_scorpio) && $achievedRewardInfo->is_pair_scorpio == 1){
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
                                  if(isset($achievedRewardInfo->is_pair_scorpio_status) && $achievedRewardInfo->is_pair_scorpio_status == 1){
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
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_pair_scorpio_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_pair_scorpio_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Pending</a> 
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
                                  425 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  590
                                </td>
                                <td>
                                  775 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  BMW or 2BHK Flat
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_pair_bmw) && $achievedRewardInfo->is_pair_bmw == 1){
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
                                  if(isset($achievedRewardInfo->is_pair_bmw_status) && $achievedRewardInfo->is_pair_bmw_status == 1){
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
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_pair_bmw_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_pair_bmw_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Pending</a> 
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
                                  575 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  810
                                </td>
                                <td>
                                  1051 Pair Plots
                                </td>
                                <td style="white-space: nowrap;">
                                  Audi Q7 or 4BHK Flat
                                </td>
                                <td style="white-space: nowrap;">
                                  <?php 
                                  if(isset($achievedRewardInfo->is_pair_audi) && $achievedRewardInfo->is_pair_audi == 1){
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
                                  if(isset($achievedRewardInfo->is_pair_audi_status) && $achievedRewardInfo->is_pair_audi_status == 1){
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
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/1/<?php echo base64_encode('is_pair_audi_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Paid</a> 
                                      </li>
                                      <li>
                                        <a href="<?php echo $backend_url; ?>/reward/change-reward-status/<?php echo base64_encode($achievedRewardInfo->user_id); ?>/0/<?php echo base64_encode('is_pair_audi_status');?>/<?php echo base64_encode($backend_url.'/reward/pair-reward'); ?>">Pending</a> 
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                           </tbody>
                        </table>
                      </div>
                    </div>
                  <?php
                  }?>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>