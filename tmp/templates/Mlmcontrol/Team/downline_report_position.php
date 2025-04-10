<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Post Report
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
                                   <th>Position</th>
                                   <th>Gold</th>
                                   <th>Platinum</th>
                                   <th>Emerald</th>
                                  <th>Diamond</th>
                                  <th>King</th>
                                </tr>
                             </thead>
                             <tbody>
                                  <?php 
                                  if(count($downlines) > 0){
                                      $i=1;
                                      foreach($downlines as $downline){
                                          
                                      ?>
                                          <tr class="gradeX">
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $downline['position']; ?></td>
                                              <td><?php echo $downline['mobile_club_count']; ?></td>
                                              <td><?php echo $downline['laptop_club_count']; ?></td>
                                              <td><?php echo $downline['bike_club_count']; ?></td>
                                             <td><?php echo $downline['diamond_club_count']; ?></td>
                                             <td><?php echo $downline['king_club_count']; ?></td>
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