<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Post Incomes</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Post Incomes
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
                                      <th style="white-space: nowrap;">Total Upgrades</th>
                                      <th style="white-space: nowrap;">Gold</th>
                                      <th style="white-space: nowrap;">Platinum</th>
                                      <th style="white-space: nowrap;">Ambrand</th>
                                      <th style="white-space: nowrap;">Diamond</th>
                                      <th style="white-space: nowrap;">King</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($totalUpgrades)){
                                      ?>
                                      <tr class="gradeX">
                                        <td><?php echo $totalUpgrades; ?></td>
                                        <td><?php echo number_format($gold, 2); ?></td>
                                        <td><?php echo number_format($platinum, 2); ?></td>
                                        <td><?php echo number_format($ambrand, 2); ?></td>
                                        <td><?php echo number_format($diamond, 2); ?></td>
                                        <td><?php echo number_format($king, 2); ?></td>
                                      </tr>
                                      <?php
                                    }?>
                                 </tbody>
                          </table>
                        </div> 
                        <div class="col-xs-12 nopadding margin-top-15">
                            <button type="submit" class="btn btn-primary" name="btn_save_post_income">Save</button>
                        </div>
                      <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>