<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($userInfos);
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active"> Pending Plot Payments</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Pending Plot Payments
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12">
                         <form name="search_closing_detais_form" id="search_closing_detais_form" method="get">
                          <div class="row">
                            <div class="col-sm-2 padding-left-0 padding-right-7">
                              <div class="dob input-group date">
                                <?php 
                                $from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
                                echo $this->Form->input('from_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $from_date));
                                ?>
                                <span class="input-group-addon" style="display: none;">
                                   <span class="fa fa-calendar"></span>
                                </span>
                              </div>
                            </div>
                            <div class="col-sm-2 padding-left-7 padding-right-0">
                              <div class="dob input-group date">
                                <?php 
                                $to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';
                                echo $this->Form->input('to_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $to_date));
                                ?>
                                <span class="input-group-addon"  style="display: none;">
                                   <span class="fa fa-calendar"></span>
                                </span>
                              </div>
                            </div>
                            <div class="col-sm-3 padding-left-10 padding-right-0">
                              <button type="submit" class="btn btn-square btn-primary">Search</button>
                            </div>
                          </div>
                        </form>
                      </div>
                        <div class="row nopadding table-cotainer margin-top-20">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
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
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>