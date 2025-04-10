<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($userInfos);
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active"> Downline Report</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Downline Report
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
                                $options[$user->username] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                              }
                              $selected = isset($_GET['username']) ? $_GET['username'] : '';
                              echo $this->Form->input('username', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'default' => $selected)); 
                               ?>
                            </div>
                            <div class="col">
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
                                 <th style="white-space: nowrap;">Date & Time</th>
                                 <th style="white-space: nowrap;">Username</th>
                                 <th style="white-space: nowrap;">Sponser</th>
                                 <th style="white-space: nowrap;">Name</th>
                                 <th style="white-space: nowrap;">Number of Unit</th>
                                 <th style="white-space: nowrap;">Contact Number</th>
                                 <th style="white-space: nowrap;">Level</th>
                                 <th style="white-space: nowrap;">Position</th>
                                 <th style="white-space: nowrap;">Total Join</th>
                                 <th>Status</th>
                              </tr>
                           </thead>
                           <tbody>
                                <?php 
                                if(count($downlines) > 0){
                                    $i=1;
                                    foreach($downlines as $downline){
                                        if($downline->Users['status'] == 1){
                                            $status = 'Active';
                                        }else{
                                             $status = 'Registered';
                                        }
                                    ?>
                                        <tr class="gradeX">
                                            <td style="white-space: nowrap;"><?php echo $i; ?></td>
                                            <td style="white-space: nowrap;"><?php echo date('F j, Y, g:i a', strtotime($downline->modified)); ?></td>
                                            <td style="white-space: nowrap;"><?php echo $downline->Users['username']; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $downline->Sponsers['username']; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $downline->Details['first_name'].' '.$downline->Details['last_name']; ?></td>
                                            <td style="white-space: nowrap;"><?php if(!empty($downline->PlotPayments['number_of_unit'])){echo number_format($downline->PlotPayments['number_of_unit']);}else{echo 'N/A';} ?></td>
                                            <td style="white-space: nowrap;"><?php echo $downline->Details['contact_no']; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $downline->level; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $downline->position; ?></td>
                                            <td style="white-space: nowrap;"><?php echo number_format($downline->total_join, 2); ?></td>
                                            <td><?php echo $status; ?></td>
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