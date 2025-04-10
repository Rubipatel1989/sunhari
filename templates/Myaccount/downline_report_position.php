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
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="downlineReport" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                   <th>Sr. No.</th>
                                   <th>Position</th>
                                   <th>Gold</th>
                                   <th>Platinum</th>
                                   <th>Emerald</th>
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