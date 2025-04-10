<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');
?>
<!-- Page Breadcrumb -->
  <div class="page-breadcrumbs">
      <ul class="breadcrumb">
          <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a>
          </li>
          <li class="active">Working Rewards</li>
      </ul>
  </div>
<!-- /Page Breadcrumb -->
<!-- Page Header -->
<div class="page-header position-relative">
    <div class="header-title">
        <h1>
          Working  Rewards
        </h1>
    </div>

    <!-- Page Body -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-xs-12">
                                    <div class="widget">
                                        <div class="widget-header bordered-bottom bordered-blue">
                                            <span class="widget-caption">Working Rewards</span>
                                        </div>
                                        <div class="widget-body">
                                            <div>
                                              

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
                                                              <th style="white-space: nowrap;">Reward Title</th>
                                                              <th style="white-space: nowrap;">Reward</th>
                                                              <th style="white-space: nowrap;">Status</th>
                                                              <th style="white-space: nowrap;">Action</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr class="gradeX">
                                                              <td>1</td>
                                                              <td>
                                                                Crystal
                                                              </td>
                                                              <td>
                                                                0.2 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_star) && $userInfo->is_star == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_star) && $userInfo->is_star == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/crystal/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>2</td>
                                                              <td>
                                                                Bronze
                                                              </td>
                                                              <td>
                                                                0.6 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_royal_star) && $userInfo->is_royal_star == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_royal_star) && $userInfo->is_royal_star == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/bronze/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>3</td>
                                                              <td>
                                                                Silver
                                                              </td>
                                                              <td>
                                                                1.0 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_platinum) && $userInfo->is_platinum == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_platinum) && $userInfo->is_platinum == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/silver/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>4</td>
                                                              <td>
                                                                Pearl
                                                              </td>
                                                              <td>
                                                                3.0 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_sapphire) && $userInfo->is_sapphire == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_sapphire) && $userInfo->is_sapphire == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/pearl/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>5</td>
                                                              <td>
                                                                Gold
                                                              </td>
                                                              <td>
                                                                6.0 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_diamond) && $userInfo->is_diamond == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_diamond) && $userInfo->is_diamond == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/gold/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>6</td>
                                                              <td>
                                                                Ruby
                                                              </td>
                                                              <td>
                                                                60 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_imperial) && $userInfo->is_imperial == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_imperial) && $userInfo->is_imperial == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/ruby/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>7</td>
                                                              <td>
                                                                Crown
                                                              </td>
                                                              <td>
                                                                200 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_crown) && $userInfo->is_crown == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_crown) && $userInfo->is_crown == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/crown/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>8</td>
                                                              <td>
                                                                King
                                                              </td>
                                                              <td>
                                                                500 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_king) && $userInfo->is_king == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_king) && $userInfo->is_king == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/king/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>9</td>
                                                              <td>
                                                                Emperor
                                                              </td>
                                                              <td>
                                                                800 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_emperor) && $userInfo->is_emperor == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_emperor) && $userInfo->is_emperor == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/emperor/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
                                                              </td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                              <td>9</td>
                                                              <td>
                                                                Imprial
                                                              </td>
                                                              <td>
                                                                1200 Yard
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <?php
                                                                $status_cls = 'notachived-staus';
                                                                $status_txt = 'Not Achieved';
                                                                if(isset($userInfo->is_emprial) && $userInfo->is_emprial == 1){
                                                                  $status_cls = 'achived-staus';
                                                                  $status_txt = 'Achieved';
                                                                }?>
                                                                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                                              </td>
                                                              <td style="white-space: nowrap;">
                                                                <div class="btn-group">
                                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                                  </button>
                                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                                      <?php
                                                                      if(isset($userInfo->is_emprial) && $userInfo->is_emprial == 1){
                                                                      ?>
                                                                        <li>
                                                                          <a href="<?php echo $home_url; ?>/my-account/download_certificate/imprial/<?php echo $userInfo->id; ?>" target="_blank">View Certificate</a> 
                                                                        </li>
                                                                      <?php
                                                                      }?>
                                                                  </ul>
                                                               </div>
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
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Body -->
</div>
<!-- /Page Header -->

<?php //echo $this->element('direct_network');?>