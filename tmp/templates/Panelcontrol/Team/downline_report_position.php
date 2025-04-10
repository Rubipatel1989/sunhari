<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
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
                              echo $this->Form->input('username', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox select2', 'default' => $selected)); 
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
                                <th>Position</th>
                                <th>Gold</th>
                                <th>Platinum</th>
                                <th>Emerald</th>
                                <th>Diamond</th>
                                <th>King</th>
                              </tr>
                            </thead>
                             <tbody>
                                <?php 
                                if($downlines){
                                    $i=1;
                                    foreach($downlines as $downline){?>
                                      <tr class="gradeX">
                                          <td><?php echo $i; ?></td>
                                          <td><?php echo $downline['position']; ?></td>
                                          <td><?php echo $downline['mobile_club_count']; ?></td>
                                          <td><?php echo $downline['laptop_club_count']; ?></td>
                                          <td><?php echo $downline['bike_club_count']; ?></td>
                                         <td><?php echo $downline['diamond_club_count']; ?></td>
                                         <td><?php echo $downline['king_club_count']; ?></td>
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