<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($closings);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Post Incomes
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
                        <form name="bulk-payment-closing-form" id="bulk-payment-closing-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                          <div class="col-xs-12 nopadding table-cotainer">
                          
                            <div class="col-xs-12 nopadding">
                              <table id="payments_closing" class="table table-striped table-hover">
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
                          </div>
                          <div class="col-xs-12 nopadding margin-top-15">
                            <button type="submit" class="btn btn-primary" name="btn_save_post_income">Save</button>
                          </div>
                        </form>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>