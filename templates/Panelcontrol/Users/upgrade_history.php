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
                      <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <div class="row nopadding table-cotainer">
                          <table id="packages" class="table table-bordered table-hover table-striped w-100">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Upgrader On</th>
                                    <th>User Info.</th>
                                    <th>Number of Unit</th>
                                    <th>Upgraded Info.</th>
                                    <th>Rank</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($upgrades)){
                                  $i=1;
                                  foreach($upgrades as $upgrade){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><span style="display:none;"><?php echo strtotime($upgrade->created); ?></span><?php echo date("d/m/y g:i a", strtotime($upgrade->created)); ?></td>
                                      <td>
                                        <strong>Username : </strong> <?php echo $upgrade->Users['username']; ?>
                                        <br><strong>Name : </strong><?php echo $upgrade->UserDetails['first_name'].' '.$upgrade->UserDetails['last_name']; ?>
                                      </td>
                                      <td><?php if(!empty($upgrade->PlotPayments['number_of_unit'])){echo number_format($upgrade->PlotPayments['number_of_unit']);}else{echo 'N/A';} ?></td>
                                      <td>
                                        <strong>Username : </strong> <?php echo $upgrade->Upgrader['username']; ?>
                                        <br><strong>Name : </strong><?php echo $upgrade->UpgraderDetails['first_name'].' '.$upgrade->UpgraderDetails['last_name']; ?>
                                      </td>
                                      <td>
                                        <?php echo $upgrade->Users['rank']; ?>
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