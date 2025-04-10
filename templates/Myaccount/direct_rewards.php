<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<h3>
   <div class="pull-right text-center">
     
   </div>
  Direct Rewards
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
                          <div class="col-xs-12 nopadding table-cotainer">
                            <div class="col-xs-12 nopadding">
                              <table id="packages" class="table table-striped table-hover">
                                 <thead>
                                    <tr>
                                      <th style="white-space: nowrap;">Sr. No.</th>
                                      <th style="white-space: nowrap;">Plot Sale</th>
                                      <th style="white-space: nowrap;">Within Days</th>
                                      <th style="white-space: nowrap;">Lifetime Plot Sale</th>
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
                                    </tr>
                                 </tbody>
                              </table>
                            </div>
                          </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>