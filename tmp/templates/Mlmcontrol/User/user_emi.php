<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
     
   </div>
   User EMI
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding ">
              <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-12 nopadding">
                      <?php echo $this->Flash->render(); ?>
                    </div>
                    <div class="col-xs-12 nopadding" style="min-height: 300px;">
                        <?php
                        if(empty($intUserId)){
                        ?>
                          <form name="user_dashboard_form"  id="user_dashboard_form" method="post" action="<?php echo $backend_url; ?>/user/user-emi" class="form-horizontal" enctype="multipart/form-data">
                              <legend>User EMI</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">User<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $options = ['' => '-Select-'];
                                      foreach($users as $userInfo){
                                        $options[$userInfo->id] = $userInfo->username.'('.$userInfo->Details['first_name'].' '.$userInfo->Details['last_name'].')';
                                      }
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('User.id', array('type' => 'select', 'id' => 'select_username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'options' => $options, 'default' => $selected, 'data-live-search' => "true",'onchange' => 'return showEmiDetails(this);'));
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                          </form>
                        <?php
                        }else{
                            ?>
                            <legend>EMI Details</legend>
                            <fieldset>
                            <div class="form-group margin-top-15">
                               <label class="col-sm-2 control-label text-right">User</label>
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
                                        <div class="form-group margin-top-15">
                                           <label class="col-sm-2 control-label">EMI<?php echo $i; ?></label>
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
</div>
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>