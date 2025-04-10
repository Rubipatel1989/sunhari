<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Rank Eligible</h3>
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
          Rank Eligible
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
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
               <thead>
                  <tr>
                    <th>Sr</th>
                    <th style="white-space: nowrap;">User Id</th>
                    <th style="white-space: nowrap;">Name</th>
                    <th style="white-space: nowrap;">Explorer Rank</th>
                    <th style="white-space: nowrap;">Contributor Rank</th>
                    <th style="white-space: nowrap;">Expert Contributor Rank</th>
                    <th style="white-space: nowrap;">Rising Rank</th>
                    <th style="white-space: nowrap;">Rising Star Rank</th>
                    <th style="white-space: nowrap;">Master Star Rank</th>
                    <th style="white-space: nowrap;">Mentor Rank</th>
                    <th style="white-space: nowrap;">Super Mentor Rank</th>
                    <th style="white-space: nowrap;">Master Rank</th>
                    <th style="white-space: nowrap;">Master Mentor Rank</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if($users){
                    $i = 1;
                    foreach($users as $userInfo){
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $userInfo->username; ?></td>
                          <td style="white-space: nowrap;"><?php echo $userInfo->name; ?></td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_explorer_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->explorer_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_contributor_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->contributor_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_expert_contributor_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->expert_contributor_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_rising_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->rising_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_rising_star_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->rising_star_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_master_star_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->master_star_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_mentor_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->mentor_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_super_mentor_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->super_mentor_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_master_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->master_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                          <td style="white-space: nowrap;">
                            <?php if ($userInfo->is_master_mentor_rank) {?>
                              Yes
                              <br> Date : <strong><?php echo date('d-m-Y', strtotime($userInfo->master_mentor_rank_date)); ?></strong>
                            <?php }?>
                          </td>
                        </tr>
                    <?php
                        $i++;
                      }
                  }?>
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