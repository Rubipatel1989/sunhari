<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
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
                      <form name="epin_list_form" id="epin_list_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                        <div class="row nopadding margin-bottom-20">
                          <div class="col-sm-2 height-37 nopadding">
                            <?php 
                            $options = ['' => '-Bulk Action-', '1' => 'Assign', '2' => 'Remove Assignment'];

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
                                      <th style="width: 30px;"><input type="checkbox" name="check_all" value="" class="chk-all"></th>
                                      <th>Sr. No.</th>
                                      <th>Created On</th>
                                      <th>Epin</th>
                                      <th>Assinged To</th>
                                      <th>Status</th>
                                      <th>Used On</th>
                                      <th>Remark</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  <?php
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
                                        <td style="white-space: nowrap;">
                                          <?php
                                          if(!empty($epin->Users['username'])) {
                                            echo $epin->Users['username'].' ('.$epin->Details['first_name'].' '.$epin->Details['last_name'].')';
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
                                          if(!empty($epin->remark))
                                            echo html_entity_decode($epin->remark); 
                                          else
                                            echo 'N/A';
                                          ?>
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
</main>