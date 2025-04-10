<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active"> Total Payout Report</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Total Payout Report
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row nopadding table-cotainer margin-top-20">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
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
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>