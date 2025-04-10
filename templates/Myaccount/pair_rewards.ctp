<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">Pair Rewards</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Pair Rewards
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
                                <th style="white-space: nowrap;">Sr. No.</th>
                                <th style="white-space: nowrap;">Pair Plot Sale</th>
                                <th style="white-space: nowrap;">Within Days</th>
                                <th style="white-space: nowrap;">Lifetime Pair Plot Sale</th>
                                <th style="white-space: nowrap;">Reward</th>
                                <th style="white-space: nowrap;">Is Achieved</th>
                                <th style="white-space: nowrap;">Status</th>
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
                              </tr>
                           </tbody>
                          </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>