<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">Direct Referral</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Direct Referral
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
                                 <th>Sr. No.</th>
                                 <th>Date & Time</th>
                                 <th>Username</th>
                                 <th>Sponser</th>
                                 <th>Name</th>
                                 <!-- <th>Level</th> -->
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
                                            <!-- <td><?php //echo $downline->level; ?></td> -->
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
</main>