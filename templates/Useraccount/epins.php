<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">Epin List</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Epin List
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <div class="row nopadding margin-bottom-20">
                          <div class="col-sm-2 height-37 nopadding">
                            <?php 
                            $options = ['' => '-Bulk Action-', '1' => 'Transfer', '2' => 'Remove Assignment'];

                            echo $this->Form->input('Epin.bulk_action', array('type' => 'select', 'id' => 'epin_bulk_action', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Amount')); 
                            ?>
                          </div>
                          <div id="users_container" class="col-sm-3 padding-left-10 padding-right-0 height-37" style="display: none;">
                            <?php 
                            $options = ['' => '-Select-'];
                            foreach($users as $user){
                              $options[$user->id] = $user->username;
                            }
                            echo $this->Form->input('Epin.assigned_to', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox select2', 'placeholder' => 'Amount')); 
                            ?>
                          </div>
                          <div class="col-sm-3 padding-left-10 padding-right-0">
                            <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                          </div>
                        </div>
                        <div class="row nopadding table-cotainer">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
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
                                                <a class="dropdown-item" href="<?php echo $home_url; ?>/my-account/manage-users/add-user/<?php echo base64_encode($epin->id); ?>">Add User</a> 
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
                      <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>