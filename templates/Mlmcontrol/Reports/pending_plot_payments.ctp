<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($userInfos);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
  Pending Plot Payments
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
            <div class="col-xs-12 nopadding">
              <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <div class="col-sm-12 ">
                  <div class="col-sm-3 padding-left-0 padding-right-7">
                    <div class="dob input-group date">
                      <?php 
$from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
echo $this->Form->input('from_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $from_date));
                      ?>
                      <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-3 padding-left-7 padding-right-0">
                    <div class="dob input-group date">
                      <?php 
$to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';
echo $this->Form->input('to_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $to_date));
                      ?>
                      <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                      </span>
                    </div>
                  </div>


                  <div class="col-xs-8 padding-left-10 padding-right-0" style="width: 100px; float: left;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </form>
            </div>
              <div class="col-xs-12 nopadding margin-top-20">
                <table id="packages" class="table table-striped table-hover">
                   <thead>
                      <tr>
                        <th style="white-space: nowrap;">Sr. No.</th>
                        <th style="white-space: nowrap;">Username</th>
                        <th style="white-space: nowrap;">Name</th>
                        <th style="white-space: nowrap;">Contact Number</th>
                        <th style="white-space: nowrap;">Plot</th>
                        <th style="white-space: nowrap;">Total Amount</th>
                        <th style="white-space: nowrap;">Last EMI</th>
                        <th style="white-space: nowrap;">Last EMI</th>
                      </tr>
                   </thead>
                   <tbody>
                      <?php
                      if(!empty($users)){
                        $i=1;
                        foreach($users as $userInfo){
                          
                        ?>
                          <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td style="white-space: nowrap;">
                              <?php echo $userInfo->username; ?>
                            </td>
                            <td><?php echo $userInfo->Details['first_name'].' '.$userInfo->Details['last_name']; ?></td>
                            <td><?php echo $userInfo->Details['contact_no']; ?></td>
                            <td><?php if(!empty($userInfo->Plots['name'])){echo $userInfo->Plots['name'].' - '.$userInfo->Plots['plot_number']; }else{echo 'Not Assigned';}?></td>
                            <td><?php if(!empty($userInfo->AssignPlots['grand_total'])){echo number_format($userInfo->AssignPlots['grand_total'], 2);}else{echo 'N/A';} ?></td>
                            <td><?php if(!empty($userInfo->last_emi)){echo number_format($userInfo->last_emi, 2);}else{echo 'N/A';} ?></td>
                            <td><?php if(!empty($userInfo->last_emi_date)){echo date("d-m-Y", strtotime($userInfo->last_emi_date));}else{echo 'N/A';} ?></td>
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