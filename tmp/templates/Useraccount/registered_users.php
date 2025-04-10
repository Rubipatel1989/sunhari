<?php
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Users
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <div class="row nopadding table-cotainer">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Registered On</th>
                                    <th>Username</th>
                                    <th>Epin</th>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <!-- <th style="text-align: center;">Total Upgrade</th> -->
                                    <th>Left Business</th>
                                    <th>Right Business</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($downlines)){
                                  $i=1;
                                  foreach($downlines as $downline){
                                    $totalUpgraded = $upgradesTable->find('all', array('conditions' => array('Upgrades.upgraded_id' => $downline->Users['id'])))->count();
                                  ?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($downline->created)); ?></td>
                                      <td><?php echo $downline->Users['username']; ?></td>
                                      <td><?php echo $downline->Epins['epin']; ?></td>
                                      <td><?php echo $downline->Users['rank']; ?></td>
                                      <td><?php echo $downline->Details['first_name'].' '.$downline->Details['last_name']; ?></td>
                                      <td><?php echo $downline->Users['total_active_left']; ?></td>
                                      <td><?php echo $downline->Users['total_active_right']; ?></td>
                                      <!-- <td style="text-align: center;">
                                        <?php //echo $totalUpgraded; ?>
                                      </td> -->
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($downline->Users['status'] == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <!-- <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                             <li>
                                              <a href="<?php echo $home_url; ?>/my-account/manage-users/upgrade-user/<?php echo $downline->Users['id']; ?>">Upgrade</a> 
                                             </li>
                                          </ul>
                                       </div>
                                      </td> -->
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
        </div>
    </div>
</main>