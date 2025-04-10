<?php
echo $this->Html->css('frontend/css/my-account.css');


?>

<div class="container-fluid">
    <!-- -------------------------------------------------------------- -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- -------------------------------------------------------------- -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
          <h3 class="text-themecolor mb-0">Welcome <?php echo $user['name']; ?></h3>
        </div>
    </div>
    <?php 
    if ($setting->news) {?>
        <div class="row">
            <div class="col-sm-12 margin-bottom-20">
                <div class="col news-contaniner">
                    <marquee width="100%" direction="left"><?php echo $setting->news; ?></marquee>
                </div>
            </div>
        </div>
    <?php }?>
    <div class="row">
        <div class="col-sm-4 margin-bottom-20">
            <div class="col dash-profile-info text-center">
                <div class="row">
                    <?php
                    $profileImage = $home_url.'/dist/libs/images/profile.png';
                    $altText = '';
                    if($user->Attachments['file']) {
                        $profileImage = $home_url.'/attachments/'.$user->Attachments['file'];
                        $altText = $user->Attachments['caption'];
                    }
                    ?>
                    <div class="dashboar-profile-img">
                        <img src="<?php echo $profileImage; ?>" alt="<?php echo $altText; ?>">
                    </div>
                </div>
                <div class="row margin-top-10">
                    <h3><?php echo $user['username']; ?></h3>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $user['name']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 margin-top-5">
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Inactive';
                        if($user['status'] == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Active';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class="col-sm-12">
                        Member Since : <strong><?php echo date('d M Y', strtotime($user->created)); ?></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex no-block">
                        <div class="me-3 align-self-center">
                          <span class="lstick d-inline-block align-middle"></span><img src="<?php echo $home_url; ?>/dist/libs/images/income.png" alt="Income">
                        </div>
                        <div class="align-self-center">
                          <h6 class="text-muted mt-2 mb-3">Wallet Balance</h6>
                          <h2><?php echo number_format($statistics[0]['walletBalance'], 2) ?? 0; ?></h2>
                          <p>&nbsp;</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex no-block">
                        <div class="me-3 align-self-center">
                          <span class="lstick d-inline-block align-middle"></span><img src="<?php echo $home_url; ?>/dist/libs/images/income.png" alt="Income">
                        </div>
                        <div class="align-self-center">
                          <h6 class="text-muted mt-2 mb-3">Total Plan AB-18</h6>
                          <h2><?php echo number_format($statistics[0]['totalPlanAb']) ?? 0; ?></h2>
                          <p>&nbsp;</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex no-block">
                        <div class="me-3 align-self-center">
                          <span class="lstick d-inline-block align-middle"></span><img src="<?php echo $home_url; ?>/dist/libs/images/income.png" alt="Income">
                        </div>
                        <div class="align-self-center">
                          <h6 class="text-muted mt-2 mb-3">Total Active Plan AB-18</h6>
                          <h2><?php echo number_format($statistics[0]['totalActivePlanAB']); ?></h2>
                          <p>&nbsp;</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex no-block">
                        <div class="me-3 align-self-center">
                          <span class="lstick d-inline-block align-middle"></span><img src="<?php echo $home_url; ?>/dist/libs/images/income.png" alt="Income">
                        </div>
                        <div class="align-self-center">
                          <h6 class="text-muted mt-2 mb-3">Total Active Plan MB</h6>
                          <h2><?php echo number_format($user['totalActivePlanMB']); ?></h2>
                          <p>&nbsp;</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <ul class="dashboar-list">
                <li>
                    <div class="pull-left stat-container col-sm-12">
                        <div class="col-xs-12 nopadding">
                            <div class="w-25 pull-left stat-icon-container">
                                <i class="fa fa-calendar wallet-balance-icon"></i>
                            </div>
                            <div class="w-75 pull-left title-container">
                                <div class="col-xs-12 nopadding">
                                  <h4>Total Plan MB</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <div class="col-xs-12 nopadding">
                                        <?php echo number_format($user['totalPlanMB']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li>
                    <div class="pull-left stat-container col-sm-12">
                        <div class="col-xs-12 nopadding">
                            <div class="w-25 pull-left stat-icon-container">
                                <i class="fa fa-users wallet-balance-icon"></i>
                            </div>
                            <div class="w-75 pull-left title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Payble EMI</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php
                                    $payableEmi = $statistics[0]['totalPlanAb']*10;
                                    echo number_format($payableEmi); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="pull-left stat-container col-sm-12">
                        <div class="col-xs-12 nopadding">
                            <div class="w-25 pull-left stat-icon-container">
                                <i class="fa fa-user wallet-balance-icon"></i>
                            </div>
                            <div class="w-75 pull-left title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Paid EMI</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php
                                    $paidEmi = $statistics[0]['totalEmis'];
                                    echo number_format($paidEmi); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="pull-left stat-container col-sm-12">
                        <div class="col-xs-12 nopadding">
                            <div class="w-25 pull-left stat-icon-container">
                                <i class="fa fa-user wallet-balance-icon"></i>
                            </div>
                            <div class="w-75 pull-left title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Pending EMI</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php
                                    echo number_format($payableEmi - $paidEmi); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="pull-left stat-container col-sm-12">
                        <div class="col-xs-12 nopadding">
                            <div class="w-25 pull-left stat-icon-container">
                                <i class="fa fa-user wallet-balance-icon"></i>
                            </div>
                            <div class="w-75 pull-left title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Submitted Bills</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php echo number_format($user->totalBills); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="pull-left stat-container col-sm-12">
                        <div class="col-xs-12 nopadding">
                            <div class="w-25 pull-left stat-icon-container">
                                <i class="fa fa-user wallet-balance-icon"></i>
                            </div>
                            <div class="w-75 pull-left title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Sponsor</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                     <?php echo $user->Sponsers['username']; ?>
                                     <br> <?php echo $user->sponsor_name; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
