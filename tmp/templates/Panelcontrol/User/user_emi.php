<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">  User EMI</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                       User EMI
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       
                       <div class="col-xs-12 nopadding" style="min-height: 300px;">
                        <?php
                        if(empty($intUserId)){
                        ?>
                          <form name="user_dashboard_form"  id="user_dashboard_form" method="post" action="<?php echo $backend_url; ?>/user/user-emi" class="form-horizontal" enctype="multipart/form-data">
                              <legend>User EMI</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">User<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $options = ['' => '-Select-'];
                                      foreach($users as $userInfo){
                                        $options[$userInfo->id] = $userInfo->username.'('.$userInfo->Details['first_name'].' '.$userInfo->Details['last_name'].')';
                                      }
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('User.id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control loginbox select2', 'placeholder' => 'Title', 'options' => $options, 'default' => $selected, 'onchange' => 'return showEmiDetails(this);'));
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                          </form>
                        <?php
                        }else{
                            ?>
                            <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">User</label>
                               <div class="col-sm-3">
                                  <?php echo $userInfo->username.' ('.$userInfo->Details['first_name'].' '.$userInfo->Details['last_name'].')';?>
                               </div>
                            </div>
                        </fieldset>
                            <?php
                            $i=1;
                            foreach($emis as $emi){
                        ?>
                                <form name="emi_form" method="post" action="<?php echo $backend_url; ?>/user/user-emi/<?php echo $intUserId;?>" class="form-horizontal" enctype="multipart/form-data">
                                    <?php 
                                    echo $this->Form->input('UserPropertyMapping.id', array('type' => 'hidden',  'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'EMI Amount', 'value' => $emi->id));
                                    ?>
                                    <?php
                                    $directIncome = 50; 
                                    if($i > 1){
                                        $directIncome = 10; 
                                    }
                                    echo $this->Form->input('UserPropertyMapping.direct_income_percentage', array('type' => 'hidden',  'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Direct', 'value' => $directIncome));
                                    ?>
                                    <fieldset>
                                        <div class="row margin-top-25 ">
                                           <label class="col-sm-2 text-right">EMI<?php echo $i; ?></label>
                                           <div class="col-sm-3">
                                              <?php 
                                              echo $this->Form->input('UserPropertyMapping.amount', array('type' => 'text',  'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'EMI Amount', 'value' => round($emi->amount, 2), 'readonly' => 'readonly'));
                                              ?>
                                           </div>
                                           <div class="col-sm-3">
                                              <?php 
                                              if($emi->status == 2){
                                              ?>
                                                <span class="paid">Paid</span>
                                              <?php
                                              }else{?>
                                                <div class="col-xs-12 margin-top-1">
                                                    <button type="submit" name="btn_submit_emi" class="btn btn-square btn-primary">Pay</button>
                                                </div>
                                              <?php
                                              }?>
                                           </div>
                                        </div>
                                    </fieldset>
                                </form>
                        <?php
                                $i++;
                            }
                        }?>
                    </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>