<?php
echo $this->Html->css('frontend/css/my-account.css');
echo $this->Html->css('frontend/css/tree.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Direct Network
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="col-xs-12 nopadding">
                    <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                      <div class="col-xs-12 nopadding">
                        <div class="col-xs-2 nopadding" style="width: 150px; float: left;">
                          <?php 
                          $options = ['' => '-Select Username-'];
                          foreach($users as $user){
                            $options[$user->username] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                          }
                          $selected = isset($_GET["username"]) ? $_GET["username"] : '';
                          echo $this->Form->input('username', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'ddl-select form-control loginbox', 'default' => $selected, 'data-live-search' => "true")); 
                           ?>
                        </div>
                        <div class="col-xs-8 padding-left-10 padding-right-0" style="width: 100px; float: left;">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-xs-12 nopadding direct-tree-outer-cotainer">
                    <div class="col-xs-12 direct-tree-cotainer">
                      <div class="col-xs-12 nopadding margin-top-25 margin-bottom-30">
                        <?php
                        if(isset($_GET["username"])){?>
                          <ul class="tree">
                            <li>
                              <div class="tree-user-info" style="width: 100%;">
                                <div class="col-xs-12 nopadding">
                                  <?php
                                  if($topUserInfo->status==1){
                                    $active_cls = 'active-user';
                                  }else{
                                    $active_cls = 'inactive-user';
                                  }
                                  ?>
                                  <i class="fa fa-user <?php echo $active_cls; ?>" title="<?php echo $topUserInfo->Details['first_name'].' '.$topUserInfo->Details['first_name']; ?>"></i>
                                </div>
                                <div class="col-xs-12 nopadding">
                                  <?php echo $topUserInfo->username;?>
                                </div>
                                <div class="direct-lines">&nbsp;</div>
                              </div>
                            </li>
                            <?php
                            if(!empty($dirctUsers)){?>
                              <li>
                                <div class="tree-user-info" style="width: 50%; float: left;">
                                  <?php
                                  if(isset($dirctUsers['left']) && !empty($dirctUsers['left'])){
                                    foreach($dirctUsers['left'] as $userInfo){
                                      if($userInfo['status'] ==1){
                                        $active_cls = 'active-user';
                                      }else{
                                        $active_cls = 'inactive-user';
                                      }
                                    ?>
                                      <div class="left-user">
                                        <div class="left-verticle-border">&nbsp;</div>
                                        <div class="col-xs-12 nopadding margin-top-25">

                                          <a href="<?php echo $backend_url; ?>/team/direct-network/?username=<?php echo $userInfo['username']; ?>" >
                                            <i class="fa fa-user <?php echo $active_cls; ?>" title="<?php echo $userInfo['name']; ?>"></i>
                                          </a>
                                        </div>
                                        <div class="col-xs-12 nopadding">
                                          <?php echo $userInfo['username']; ?>
                                        </div>
                                      </div>
                                    <?php
                                    }
                                  }?>
                                </div>
                                <div class="tree-user-info" style="width: 50%; float: right;">
                                  <?php
                                  if(isset($dirctUsers['right']) && !empty($dirctUsers['right'])){
                                    foreach($dirctUsers['right'] as $userInfo){
                                      if($userInfo['status'] ==1){
                                        $active_cls = 'active-user';
                                      }else{
                                        $active_cls = 'inactive-user';
                                      }
                                    ?>
                                      <div class="right-user">
                                        <div class="right-verticle-border">&nbsp;</div>
                                        <div class="col-xs-12 nopadding margin-top-25">
                                          <a href="<?php echo $backend_url; ?>/team/direct-network/?username=<?php echo $userInfo['username']; ?>" >
                                            <i class="fa fa-user <?php echo $active_cls; ?>" title="<?php echo $userInfo['name']; ?>"></i>
                                          </a>
                                        </div>
                                        <div class="col-xs-12 nopadding">
                                          <?php echo $userInfo['username']; ?>
                                        </div>
                                      </div>
                                    <?php
                                    }
                                  }?>
                                </div>
                              </li>
                            <?php
                            }?>
                          </ul>
                        <?php
                        }?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>