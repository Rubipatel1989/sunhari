<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Upgrade History
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/user/upgrade"><i class="fa fa-plus"></i> Upgrade User</a>
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="packages" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Upgrader On</th>
                                    <th>User Info.</th>
                                    <th>Package</th>
                                    <th>Upgraded Info.</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($upgrades)){
                                  $i=1;
                                  foreach($upgrades as $upgrade){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("d-m-Y", strtotime($upgrade->created)); ?></td>
                                      <td>
                                        <strong>Username : </strong> <?php echo $upgrade->Users['username']; ?>
                                        <br><strong>Name : </strong><?php echo $upgrade->UserDetails['first_name'].' '.$upgrade->UserDetails['last_name']; ?>
                                      </td>
                                      <td>
                                        <strong>Name : </strong> <?php echo $upgrade->Packages['name']; ?>
                                        <br><strong>Amount : </strong> Rs <?php echo number_format($upgrade->Packages['package_amount'], 2); ?>
                                      </td>
                                      <td>
                                        <strong>Username : </strong> <?php echo $upgrade->Upgrader['username']; ?>
                                        <br><strong>Name : </strong><?php echo $upgrade->UpgraderDetails['first_name'].' '.$upgrade->UpgraderDetails['last_name']; ?>
                                      </td>
                                    </tr>
                                  <?php
                                    $i++;
                                  }
                                }?>
                             </tbody>
                          </table>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>