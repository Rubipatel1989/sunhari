<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   E-Pin List 
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
                        <form name="epin_list_form" id="epin_list_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                          <div class="col-xs-12 nopadding">
                            <div class="col-xs-2 height-37 nopadding">
                              <?php 
                              $options = ['' => '-Bulk Action-', '1' => 'Transfer', '2' => 'Remove Assignment'];

                              echo $this->Form->input('Epin.bulk_action', array('type' => 'select', 'id' => 'epin_bulk_action', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Amount')); 
                              ?>
                            </div>
                            <div id="users_container" class="col-xs-3 padding-left-10 padding-right-0 height-37" style="display: none;">
                              <?php 
                              $options = ['' => '-Select-'];
                              foreach($users as $user){
                                $options[$user->id] = $user->username;
                              }
                              echo $this->Form->input('Epin.assigned_to', array('type' => 'select', 'id' => 'select_username', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Amount', 'data-live-search' => "true")); 
                              ?>
                            </div>
                            <div class="col-xs-3 padding-left-10 padding-right-0">
                              <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                            </div>
                          </div>
                          <div class="col-xs-12 nopadding table-cotainer margin-top-20">
                            <table id="wallets" class="table table-striped table-hover">
                               <thead>
                                  <tr>
                                    <th style="width: 30px; padding-left: 17px; "><input type="checkbox" name="check_all" value="" class="chk-all"></th>
                                    <th>Sr. No.</th>
                                    <th>Created On</th>
                                    <th>Epin</th>
                                    <th>Assinged To</th>
                                    <th>Status</th>
                                    <th>Used On</th>
                                    <th>Used For</th>
                                    <th>Remark</th>
                                    <th style="text-align: center;">Action</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  <?php
                                  /*echo '<pre>';
                                  print_r($epins);*/
                                  if(!empty($epins)){
                                    $i=1;
                                    foreach($epins as $epin){
                                      $disabled = '';
                                      if($epin->status == 2){
                                         $disabled = 'disabled';
                                      }
                                    ?>
                                      <tr class="gradeX">
                                        <td style="padding-left: 17px;"><input type="checkbox" name="epinIds[]" value="<?php echo $epin->id;?>" class="chk-id" <?php echo $disabled; ?>></td>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date("F j, Y, g:i a", strtotime($epin->created)); ?></td>
                                        <td><?php echo $epin->epin; ?></td>
                                        <td>
                                          <?php
                                          if(!empty($epin->Users['username'])) {
                                            echo $epin->Users['username'].' ('.$epin->AssignedToDetails['first_name'].' '.$epin->AssignedToDetails['last_name'].')';;
                                          }else{
                                            echo 'N/A';
                                          }
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                          $status_cls = 'inactive-staus';
                                          $status_txt = 'Unused';
                                          if($epin->status == 2){
                                            $status_cls = 'active-staus';
                                            $status_txt = 'Used';
                                          }?>
                                          <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                        </td>
                                        <td>
                                          <?php
                                          $usedOn = 'N/A';
                                          if($epin->modfied != ''){
                                            $usedOn =  date("F j, Y, g:i a", strtotime($epin->modfied)); 
                                          }
                                          echo $usedOn;
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                          if(!empty($epin->UsedFor['username'])) {
                                            echo $epin->UsedFor['username'].' ('.$epin->UsedForDetails['first_name'].' '.$epin->UsedForDetails['last_name'].')';;
                                          }else{
                                            echo 'N/A';
                                          }
                                          ?>
                                        </td>
                                        <td>
                                          <?php 
                                          if(!empty($epin->remark))
                                            echo html_entity_decode($epin->remark); 
                                          else
                                            echo 'N/A';
                                          ?>
                                        </td>
                                        <td style="text-align: center;">
                                          <div class="btn-group">
                                            <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                            </button>
                                            <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                              <?php
                                              if($epin->status != 2){?> 
                                                 <li>
                                                  <a href="<?php echo $home_url; ?>/my-account/manage-users/add-user/<?php echo base64_encode($epin->id); ?>">Add User</a> 
                                                 </li>
                                              <?php
                                              }?>
                                            </ul>
                                         </div>
                                        </td>
                                      </tr>
                                    <?php
                                      $i++;
                                    }
                                  }?>
                               </tbody>
                            </table>
                          </div>
                        </form>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>