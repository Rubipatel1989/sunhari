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
      <div class="col-sm-12 margin-bottom-20">
         <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <div class="row nopadding">
            <div class="col nopadding">
              <?php 
              $rank = isset($_GET['rank']) ? $_GET['rank'] : '';
              $options = [
                '' => '-Select Rank-',
                'explorer_rank' => 'Explorer Rank',
                'contributor_rank' => 'Contributor Rank',
                'expert_contributor' => 'Expert Contributor',
                'rising_rank' => 'Rising Rank',
                'rising_star_rank' => 'Rising Star Rank',
                'master_star_rank' => 'Master Star Rank',
                'mentor_rank' => 'Mentor Rank',
                'super_mentor_rank' => 'Super Mentor Rank',
                'master_rank' => 'Master Rank',
                'master_mentor_rank' => 'Master Mentor Rank',
              ];
              echo $this->Form->input('rank', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $rank)); 
               ?>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
              <table id="packages" class="table table-bordered table-hover table-striped w-100">
                 <thead>
                    <tr>
                      <th>Sr</th>
                      <th style="white-space: nowrap;">User Id</th>
                      <th style="white-space: nowrap;">Name</th>
                      <th style="white-space: nowrap;">Rank</th>
                      <th style="white-space: nowrap;">Payout Amount</th>
                      <th style="white-space: nowrap;">No. of Week</th>
                      <th style="white-space: nowrap;">Total Week</th>
                      <th style="white-space: nowrap;">Date</th>
                      <th style="white-space: nowrap;">View</th>
                    </tr>
                 </thead>
                 <tbody>
                    <?php
                    if($payouts){
                      $i = 1;
                      foreach($payouts as $payout){
                      ?>
                          <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td style="white-space: nowrap;"><?php echo $payout->Users['username']; ?></td>
                            <td style="white-space: nowrap;"><?php echo $payout->Users['name']; ?></td>
                            <?php
                            if(isset($_GET['rank']) && $_GET['rank'] == 'explorer_rank'){?>
                              <td style="white-space: nowrap;">Explorer</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->explorer_rank_amount ?? 0), 2); ?></td>
                            <?php
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'contributor_rank'){?>
                              <td style="white-space: nowrap;">Contributor</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->contributor_rank_amount ?? 0), 2); ?></td>
                            <?php
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'expert_contributor'){?>
                              <td style="white-space: nowrap;">Expert Contributor</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->expert_contributor_amount ?? 0), 2); ?></td>
                            <?php
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'rising_rank'){?>
                              <td style="white-space: nowrap;">Rising</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->rising_rank_amount ?? 0), 2); ?></td>
                            <?php
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'rising_star_rank'){?>
                              <td style="white-space: nowrap;">Rising Star</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->rising_star_rank_amount ?? 0), 2); ?></td>
                            <?php  
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'master_star_rank'){?>
                              <td style="white-space: nowrap;">Master Star</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->master_star_rank_amount ?? 0), 2); ?></td>
                            <?php
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'mentor_rank'){?>
                              <td style="white-space: nowrap;">Mentor</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->mentor_rank_amount ?? 0), 2); ?></td>
                            <?php
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'super_mentor_rank'){?>
                              <td style="white-space: nowrap;">Super Mentor</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->super_mentor_rank_amount ?? 0), 2); ?></td>
                            <?php
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'master_rank'){?>
                              <td style="white-space: nowrap;">Master</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->master_rank_amount ?? 0), 2); ?></td>
                            <?php
                            } elseif(isset($_GET['rank']) && $_GET['rank'] == 'master_mentor_rank'){?>
                              <td style="white-space: nowrap;">Master Mentor</td>
                              <td style="white-space: nowrap;"><?php echo number_format(($payout->master_mentor_rank_amount ?? 0), 2); ?></td>
                            <?php
                            }?>
                            <td style="white-space: nowrap;"><?php echo $payout->weeksCount; ?> Weeks</td>
                            <td style="white-space: nowrap;">80 Weeks</td>
                            <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($payout->created); ?></span><?php echo date("d/m/y g:i a", strtotime($payout->created)); ?></td>
                            <td style="white-space: nowrap;"><a href="">View Details</a></td>
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