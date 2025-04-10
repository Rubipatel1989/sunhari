<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Direct Referral
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding">
              <div class="panel panel-default">
                   <div class="panel-body">
                      <div class="col-xs-12 nopadding">
                        <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                          <div class="col-xs-12 nopadding">
                            <div class="col-xs-2 nopadding" style="width: 150px; float: left;">
                              <?php 
                              $options = ['' => '-Select Username-'];
                              foreach($users as $user){
                                $options[$user->username] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                              }
                              $selected = isset($_GET['username']) ? $_GET['username'] : '';
                              echo $this->Form->input('username', array('type' => 'select', 'id' => 'select_username', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'data-live-search' => "true")); 
                               ?>
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
                                 <th>Date & Time</th>
                                 <th>Username</th>
                                 <th>Sponser</th>
                                 <th>Name</th>
                                 <th>Level</th>
                                 <th>Position</th>
                                 <th>Total Join</th>
                                 <th>Status</th>
                              </tr>
                           </thead>
                           <tbody>
                                <?php 
                                if(count($downlines) > 0){
                                    $i=1;
                                    foreach($downlines as $downline){
                                        if($downline->Users['status'] == 1){
                                            $status = 'Active';
                                        }else{
                                             $status = 'Registered';
                                        }
                                    ?>
                                        <tr class="gradeX">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo date('F j, Y, g:i a', strtotime($downline->created)); ?></td>
                                            <td><?php echo $downline->Users['username']; ?></td>
                                            <td><?php echo $downline->Sponsers['username']; ?></td>
                                            <td><?php echo $downline->Details['first_name'].' '.$downline->Details['last_name']; ?></td>
                                            <td><?php echo $downline->level; ?></td>
                                            <td><?php echo $downline->position; ?></td>
                                            <td><?php echo number_format($downline->total_join, 2); ?></td>
                                            <td><?php echo $status; ?></td>
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