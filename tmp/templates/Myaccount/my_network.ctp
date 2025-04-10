<?php
echo $this->Html->css('frontend/css/my-account.css');
echo $this->Html->css('frontend/css/tree.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">My Network</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      My Network
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="row">
                        <div class="col-sm-3 nopadding">
                          <?php
                          $selected = '';
                          $options = ['' => $user->username];
                          foreach($downlines as $downline){
                            $rand = rand(123456789, 999999999);
                            $options[base64_encode(strtolower($downline->Users['username']).'___'.$rand)] = $downline->Users['username'].'('.$downline->Details['first_name'].' '.$downline->Details['last_name'].')';
                            if(strtolower($downline->Users['username']) == strtolower($slectedUsername)){
                              $selected = isset($slectedUsername) && !empty($slectedUsername) ? base64_encode(strtolower($slectedUsername).'___'.$rand) : '';
                            }
                          }
                          echo $this->Form->input('Upgrade.upgraded_id', array('type' => 'select', 'id' => 'select_username', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => 'Title', 'options' => $options, 'default' => $selected,));
                          ?>
                        </div>
                      </div>
                      <div class="row nopadding tree-outer-cotainer">
                        <div class="col-sm-12 tree-cotainer nopadding margin-top-25 margin-bottom-30">
                          <ul class="tree">
                            <li>
                              <div class="tree-user-info" style="width: 100%;">
                                <div class="col-xs-12 nopadding">
                                  <?php
                                  /*echo '<pre>';
                                  print_r($topUserInfo);*/
                                  if($topUserInfo->total_upgrades > 0 && $topUserInfo->total_upgrades < 21000){
                                                $active_cls = 'orange-user';
                                  }
                                  elseif($topUserInfo->total_upgrades >= 21000 && $topUserInfo->total_upgrades < 51000){
                                    $active_cls = 'green-user';
                                  }
                                  elseif($topUserInfo->total_upgrades >= 51000){
                                    $active_cls = 'blue-user';
                                  }
                                  else{
                                    $active_cls = 'inactive-user';
                                  }?>
                                  <i class="fa fa-user network-user-icon <?php echo $active_cls; ?>" title="<?php echo $topUserInfo->Details['first_name'].' '.$topUserInfo->Details['first_name']; ?>"></i>
                                  <div class="col-xs-12 network-user-details user-details" style="display: none;">
                                    <ul>
                                      <li>Name : </li>
                                      <li><?php echo $topUserInfo->Details['first_name'].' '.$topUserInfo->Details['first_name']; ?></li>
                                      <li>Username : </li>
                                      <li><?php echo $topUserInfo->username;?></li>
                                      <li>Sponser Name : </li>
                                      <li><?php echo $topUserInfo->sponsor_name; ?></li>
                                      <li> Sponser Username : </li>
                                      <li><?php echo $topUserInfo->Sponsers['username'];?></li>
                                      <li> Total left : </li>
                                      <li><?php echo number_format($topUserInfo->total_left);?></li>
                                      <li> Total Right : </li>
                                      <li><?php echo number_format($topUserInfo->total_right);?></li>
                                      <li> Left Business : </li>
                                      <li><?php echo number_format($topUserInfo->total_active_left, 2);?></li>
                                      <li> Right Business : </li>
                                      <li><?php echo number_format($topUserInfo->total_active_right, 2);?></li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="col-xs-12 nopadding">
                                  <?php echo $topUserInfo->username;?>
                                </div>
                                <div class="tree-lines">&nbsp;</div>
                              </div>
                            </li>
                            <?php
                              $parent[] = $topUserInfo->id;
                              $i=1;
                              $k=2;
                              $endLevel = 3;
                              $q=0;
                              for($p=1; $p <= $endLevel; $p++){
                                $width = 100/$k;
                              ?>
                                  <li>
                                    <?php
                                    for($j=0; $j<(pow(2, $i))/2; $j++){
                                        for($r=0; $r<2; $r++){
                                          if($r%2 == 0){
                                            $position = 'left';
                                          }else{
                                            $position = 'right';
                                          }
                                          $username =  'empty';
                                          $name = '';
                                          $active_cls = 'inactive-user';
                                          if(isset($trees[$p][$parent[$q]][$position]['username']) && !empty($trees[$p][$parent[$q]][$position]['username'])){
                                            $username =  $trees[$p][$parent[$q]][$position]['username'];
                                            $parent[] = $trees[$p][$parent[$q]][$position]['user_id'];
                                            $name = $trees[$p][$parent[$q]][$position]['name'];
                                            $sponsor_name = $trees[$p][$parent[$q]][$position]['sponsor_name'];
                                            $sponsor_usernmae = $trees[$p][$parent[$q]][$position]['sponsor_usernmae'];
                                            $total_left = $trees[$p][$parent[$q]][$position]['total_left'];
                                            $total_right = $trees[$p][$parent[$q]][$position]['total_right'];
                                            $total_active_left = $trees[$p][$parent[$q]][$position]['total_active_left'];
                                            $total_active_right = $trees[$p][$parent[$q]][$position]['total_active_right'];
                                            $plot_number = !empty($trees[$p][$parent[$q]][$position]['plot_number']) ? $trees[$p][$parent[$q]][$position]['plot_number'] : 'N/A';
                                            $total_paid_payment = !empty($trees[$p][$parent[$q]][$position]['total_paid_payment']) ? $trees[$p][$parent[$q]][$position]['total_paid_payment'] : 0;
                                            $grand_total = !empty($trees[$p][$parent[$q]][$position]['grand_total']) ? $trees[$p][$parent[$q]][$position]['grand_total'] : 0;
                                            $due_amount = $grand_total - $total_paid_payment;

                                            if($trees[$p][$parent[$q]][$position]['total_upgrades'] > 0 && $trees[$p][$parent[$q]][$position]['total_upgrades'] < 21000){
                                              $active_cls = 'orange-user';
                                            }
                                            elseif($trees[$p][$parent[$q]][$position]['total_upgrades'] >= 21000 && $trees[$p][$parent[$q]][$position]['total_upgrades'] < 51000){
                                              $active_cls = 'green-user';
                                            }
                                            elseif($trees[$p][$parent[$q]][$position]['total_upgrades'] >= 51000){
                                              $active_cls = 'blue-user';
                                            }
                                          }else{
                                            $parent[] = '';
                                          }?>
                                          <div class="tree-user-info" style="width: <?php echo $width; ?>%;">
                                            <div class="col-xs-12 nopadding">
                                              <?php
                                              if($username != 'empty'){ ?>
                                                <a class="network-user-icon" href="<?php echo $home_url; ?>/my-account/team/my-network/<?php echo base64_encode(strtolower($username).'___'.rand(123456789, 999999999));?>">
                                                  <i class="fa fa-user <?php echo $active_cls; ?>" title="<?php echo $name; ?>"></i>
                                                </a>
                                                <div class="col-xs-12 network-user-details user-details" style="display: none;">
                                                  <ul>
                                                    <li>Name : </li>
                                                    <li><?php echo $name; ?></li>
                                                    <li>Username : </li>
                                                    <li><?php echo $username;?></li>
                                                    <li>Sponser Name : </li>
                                                    <li><?php echo $sponsor_name; ?></li>
                                                    <li> Sponser Username : </li>
                                                    <li><?php echo $sponsor_usernmae;?></li>
                                                    <li> Total left : </li>
                                                    <li><?php echo number_format($total_left);?></li>
                                                    <li> Total Right : </li>
                                                    <li><?php echo number_format($total_right);?></li>
                                                    <li> Left Business : </li>
                                                    <li><?php echo number_format($total_active_left, 2);?></li>
                                                    <li> Right Business : </li>
                                                    <li><?php echo number_format($total_active_right, 2);?></li>
                                                    <li> Plot Number : </li>
                                                    <li><?php echo $plot_number;?></li>
                                                    <li> Deposit Amount : </li>
                                                    <li><?php echo number_format($total_paid_payment, 2);?></li>
                                                    <li> Due Amount : </li>
                                                    <li><?php echo number_format($due_amount, 2);?></li>
                                                  </ul>
                                                </div>
                                              <?php
                                              }else{?>
                                               <i class="fa fa-user"></i>
                                              <?php
                                              }?>
                                            </div>
                                            <div class="col-xs-12 nopadding">
                                              <?php echo $username;?>
                                            </div>
                                            <?php
                                            if($p < $endLevel){?>
                                              <div class="tree-lines">&nbsp;</div>
                                            <?php
                                            }?>
                                          </div>
                                    <?php 
                                        }
                                        $q++;
                                    }?>
                                  </li>
                            <?php
                                $i++;
                                $k = $k*2;
                              }?>
                          </ul>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo $this->element('my_network');?>