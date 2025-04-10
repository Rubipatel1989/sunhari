<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">Rewards</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Rewards
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
                                  <th style="white-space: nowrap;">Reward Title</th>
                                  <th style="white-space: nowrap;">Reward</th>
                                  <th style="white-space: nowrap;">Amount</th>
                                  <th style="white-space: nowrap;">Status</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($rewards)){
                                  $i=1;
                                  foreach($rewards as $reward){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td>
                                        <?php echo $reward->title; ?>
                                      </td>
                                      <td>
                                        <?php echo $reward->reward; ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo number_format($reward->amount, 2); ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php
                                        $status_cls = 'notachived-staus';
                                        $status_txt = 'Not Achieved';
                                        if(!empty($reward->AchievedRewards['id'])){
                                          $status_cls = 'achived-staus';
                                          $status_txt = 'Achieved';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
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