<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Used Epin</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Used Epin
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <div class="row nopadding table-cotainer">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                             
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Created On</th>
                                    <th>Used On</th>
                                    <th>Epin</th>
                                    <th>Assinged To</th>
                                    <th>Remark</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($epins)){
                                  $i=1;
                                  foreach($epins as $epin){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($epin->created)); ?></td>
                                      <td>
                                        <?php
                                        $usedOn = 'N/A';
                                        if($epin->modfied != ''){
                                          $usedOn =  date("F j, Y, g:i a", strtotime($epin->modfied)); 
                                        }
                                        echo $usedOn;
                                        ?>
                                      </td>
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
                      <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>