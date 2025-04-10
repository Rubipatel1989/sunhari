<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
  Total Payout Report
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
            <div class="col-xs-12 nopadding table-cotainer">
              <div class="col-xs-12 nopadding margin-top-20">
                <table id="packages" class="table table-striped table-hover">
                   <thead>
                      <tr>
                        <th style="white-space: nowrap;">Sr. No.</th>
                        <th style="white-space: nowrap;">Username</th>
                        <th style="white-space: nowrap;">Name</th>
                        <th style="white-space: nowrap;">Direct Amount</th>
                        <th style="white-space: nowrap;">Matching Amount</th>
                        <th style="white-space: nowrap;">Gold Amount</th>
                        <th style="white-space: nowrap;">Platinum Amount</th>
                        <th style="white-space: nowrap;">Ambrand Amount</th>
                        <th style="white-space: nowrap;">Diamond Amount</th>
                        <th style="white-space: nowrap;">King Amount</th>
                        <th style="white-space: nowrap;">Total</th>
                        <th style="white-space: nowrap;">Tax</th>
                        <th style="white-space: nowrap;">Admin Commission</th>
                        <th style="white-space: nowrap;">Net Amount</th>
                      </tr>
                   </thead>
                   <tbody>
                      <?php
                      if(!empty($users)){
                        $i=1;
                        foreach($users as $user){
                        ?>
                          <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->Details['first_name']; ?></td>
                            <td>
                              <?php echo number_format($user->direct_amount, 2); ?>
                            </td>
                            <td>
                              <?php echo number_format($user->matching_amount, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($user->gold_amount, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($user->platinum_amount, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($user->ambrand_amount, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($user->diamond_club_amount, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($user->king_club_amount, 2); ?> 
                            </td>
                            
                            <td>
                              <?php echo number_format($user->total, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($user->admin_commission, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($user->tax, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($user->net_amount, 2); ?>
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
</div>