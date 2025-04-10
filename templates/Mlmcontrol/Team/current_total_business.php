<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Current Business Report
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <div class="col-sm-12 ">
                              <div class="col-xs-2 padding-left-0 padding-right-7" style="width: 150px; float: left;">
                                <?php 
                                $options = ['' => '-Select Username-'];
                                foreach($users as $user){
                                  $options[$user->username] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                }
                                $selected = isset($_GET['username']) ? $_GET['username'] : '';
                                echo $this->Form->input('username', array('type' => 'select', 'id' => 'select_username', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'data-live-search' => "true")); 
                                 ?>
                              </div>
                              
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
                        <div class="col-xs-12 nopadding table-cotainer margin-top-15">
                          <table id="packages" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                   <th>Sr. No.</th>
                                   <th>Position</th>
                                   <th>Total Amount</th>
                                </tr>
                             </thead>
                             <tbody>
                                  <?php 
                                  if(count($totalbusiness) > 0){
                                      $i=1;
                                      foreach($totalbusiness as $totalbusi){
                                          
                                      ?>
                                          <tr class="gradeX">
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $totalbusi['position']; ?></td>
                                              <td><?php echo $totalbusi['total_amount']; ?></td>
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