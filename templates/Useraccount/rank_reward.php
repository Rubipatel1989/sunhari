<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Rank Reward</h3>
    </div>
    <div
      class="
        col-md-7 col-12
        align-self-center
        d-none d-md-flex
        justify-content-end
      "
    >
      <ol class="breadcrumb mb-0 p-0 bg-transparent">
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">Home</a>
        </li>
        <li class="breadcrumb-item active d-flex align-items-center">
          Rank Reward
        </li>
      </ol>
    </div>
  </div>
  <!-- -------------------------------------------------------------- -->
  <!-- Start Page Content -->
  <!-- -------------------------------------------------------------- -->
  <div class="row">
    <div class="col-sm-12">
      <?php echo $this->Flash->render(); ?>
    </div>
  </div>
  <div class="card card-body">
    <div class="row">
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
              <table id="table-with-download" class="table table-bordered table-hover table-striped w-100">
                 <thead>
                    <tr>
                      <th>Sr</th>
                      <th style="white-space: nowrap;">Rank</th>
                      <th style="white-space: nowrap;">Total</th>
                      <th style="white-space: nowrap;">Earned</th>
                      <th style="white-space: nowrap;">Pending</th>
                      <th style="white-space: nowrap;">Status</th>
                      <th style="white-space: nowrap;">View</th>
                    </tr>
                 </thead>
                 <tbody>
                    <tr class="gradeX">
                      <td>1</td>
                      <td style="white-space: nowrap;">Explorer</td>
                      <td style="white-space: nowrap;">
                        Team Size: <strong>20</strong>
                        <br>Total Team Business: <strong>10000</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Team Size: <strong><?php echo $user['total_active_downline']; ?></strong>
                        <br>Total Team Business: <strong><?php echo $user['total_downline_business']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php 
                        $pendingTeamSize = 20 - $user['total_active_downline'];
                        $pendingTeamBusiness = 10000 - $user['total_downline_business'];
                        ?>
                        Pending Total Team Size: <strong><?php if ($pendingTeamSize > 0) {echo $pendingTeamSize;}else{echo '0';} ?></strong>
                        <br>Pending Total Team Business: <strong><?php if ($pendingTeamBusiness > 0) {echo $pendingTeamBusiness;}else{echo '0';} ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_explorer_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Explorer', 'explorer_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>2</td>
                      <td style="white-space: nowrap;">Contributor</td>
                      <td style="white-space: nowrap;">
                        Team Size: <strong>70</strong>
                        <br>Total Team Business: <strong>35000</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Total Team Size: <strong><?php echo $user['total_active_downline']; ?></strong>
                        <br>Earned Total Team Business: <strong><?php echo $user['total_downline_business']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php 
                        $pendingTeamSize = 70 - $user['total_active_downline'];
                        $pendingTeamBusiness = 35000 - $user['total_downline_business'];
                        ?>
                        Pending Total Team Size: <strong><?php if ($pendingTeamSize > 0) {echo $pendingTeamSize;}else{echo '0';} ?></strong>
                        <br>Pending Total Team Business: <strong><?php if ($pendingTeamBusiness > 0) {echo $pendingTeamBusiness;}else{echo '0';} ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_contributor_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Contributor', 'contributor_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>3</td>
                      <td style="white-space: nowrap;">Expert Contributor</td>
                      <td style="white-space: nowrap;">
                        Team Size: <strong>190</strong>
                        <br>Total Team Business: <strong>85000</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Total Team Size: <strong><?php echo $user['total_active_downline']; ?></strong>
                        <br>Earned Total Team Business: <strong><?php echo $user['total_downline_business']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php 
                        $pendingTeamSize = 190 - $user['total_active_downline'];
                        $pendingTeamBusiness = 85000 - $user['total_downline_business'];
                        ?>
                        Pending Total Team Size: <strong><?php if ($pendingTeamSize > 0) {echo $pendingTeamSize;}else{echo '0';} ?></strong>
                        <br>Pending Total Team Business: <strong><?php if ($pendingTeamBusiness > 0) {echo $pendingTeamBusiness;}else{echo '0';} ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_expert_contributor_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Expert Contributor', 'expert_contributor_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>4</td>
                      <td style="white-space: nowrap;">Rising</td>
                      <td style="white-space: nowrap;">
                        Maintain Expert Contributor: <strong>3</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Expert Contributor: <strong><?php echo $userInfo['totalExpertContributor']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $pending = 3 - $userInfo['totalExpertContributor'];
                        ?>
                        Pending Expert Contributor: <strong><?php if ($pending > 0) { echo $pending;}else {echo '0';}?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_rising_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Rising', 'rising_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>5</td>
                      <td style="white-space: nowrap;">Rising Star</td>
                      <td style="white-space: nowrap;">
                        Maintain Rising: <strong>3</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Rising: <strong><?php echo $userInfo['totalRising']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $pending = 3 - $userInfo['totalRising'];
                        ?>
                        Pending Rising: <strong><?php if ($pending > 0) { echo $pending;}else {echo '0';}?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_rising_star_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Rising Star', 'rising_star_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>6</td>
                      <td style="white-space: nowrap;">Master Star</td>
                      <td style="white-space: nowrap;">
                        Maintain Rising Star: <strong>3</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Rising Star: <strong><?php echo $userInfo['totalRisingStar'];?> </strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $pending = 3 - $userInfo['totalRisingStar'];
                        ?>
                        Pending Rising Star: <strong><?php if ($pending > 0) { echo $pending;}else {echo '0';}?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_master_star_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Master Star', 'master_star_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>7</td>
                      <td style="white-space: nowrap;">Mentor</td>
                      <td style="white-space: nowrap;">
                        Maintain Master Star : <strong>3</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Master Star: <strong><?php echo $userInfo['totalMasterStar']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $pending = 3 - $userInfo['totalMasterStar'];
                        ?>
                        Pending Master Star: <strong><?php if ($pending > 0) { echo $pending;}else {echo '0';}?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_mentor_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Mentor', 'mentor_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>8</td>
                      <td style="white-space: nowrap;">Super Mentor</td>
                      <td style="white-space: nowrap;">
                        Maintain Mentor: <strong>3</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Mentor: <strong><?php echo $userInfo['totalMentor']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $pending = 3 - $userInfo['totalMentor'];
                        ?>
                        Pending Mentor: <strong><?php if ($pending > 0) { echo $pending;}else {echo '0';}?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_super_mentor_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Super Mentor', 'super_mentor_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>9</td>
                      <td style="white-space: nowrap;">Master</td>
                      <td style="white-space: nowrap;">
                        Maintain Super Mentor: <strong>3</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Super Mentor: <strong><?php echo $userInfo['totalSuperMentor']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $pending = 3 - $userInfo['totalSuperMentor'];
                        ?>
                        Pending Super Mentor: <strong><?php if ($pending > 0) { echo $pending;}else {echo '0';}?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_master_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Master', 'master_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                    <tr class="gradeX">
                      <td>10</td>
                      <td style="white-space: nowrap;">Master Mentor</td>
                      <td style="white-space: nowrap;">
                        Maintain Master: <strong>3</strong>
                      </td>
                      <td style="white-space: nowrap;">
                        Earned Master: <strong><?php echo $userInfo['totalMaster']; ?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $pending = 3 - $userInfo['totalMaster'];
                        ?>
                        Pending Master: <strong><?php if ($pending > 0) { echo $pending;}else {echo '0';}?></strong>
                      </td>
                      <td style="white-space: nowrap;">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Pending';
                        if($user['is_master_mentor_rank'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Achieved';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                      </td>
                      <td style="white-space: nowrap;"><a href="javascript:showrankDetails('Master Mentor', 'master_mentor_rank_amount', '<?php echo $user['id']; ?>');">View Details</a></td>
                    </tr>
                 </tbody>
              </table>
          </div> 
        <?php echo $this->Form->end();?>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>
<button type="button" id="rank_amount_link" class="
    btn btn-light-success
    text-success
    font-weight-medium
    btn-lg
    px-4
    fs-4
    font-weight-medium
  " data-bs-toggle="modal" data-bs-target="#rank_amount_container" style="display: none;">
  Success Alert
</button>
<div class="modal fade" id="rank_amount_container" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 id="rank_title" class="modal-title" id="myLargeModalLabel">Modal Title</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="tbl_rank_amount_container" class="modal-body">
          goes here
        </div>
        <div class="modal-footer">
          <button type="button" class="
              btn btn-light-danger
              text-danger
              font-weight-medium
              waves-effect
              text-start
            " data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>