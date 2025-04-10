<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">All Agent Details</h3>
    </div>
    <div
      class="
        col-md-7 col-12
        align-self-center
        d-none d-md-flex
        justify-content-end
      "
    >
      <ol class="breadcrumb mb-0 p-0 bg-transparent">
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">Home</a>
        </li>
        <li class="breadcrumb-item active d-flex align-items-center">
          All Agent Details
        </li>
      </ol>
    </div>
  </div>
  <!-- -------------------------------------------------------------- -->
  <!-- Start Page Content -->
  <!-- -------------------------------------------------------------- -->
  <div class="row">
    <div class="col-sm-12">
      <?php echo $this->Flash->render(); ?>
    </div>
  </div>
  <div class="card card-body">
    <div class="row">
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
               <thead>
                  <tr>
                    <th>Sr</th>
                    <th>Userid</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th style="white-space:nowrap;">Sponsor ID</th>
                    <th style="white-space:nowrap;">Sponsor Name</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $arrOtherUser = [];
                  if(!empty($users)){
                    $i=1;
                    foreach($users as $user){
                      $totalUpgraded = $upgradesTable->find('all', array('conditions' => array('Upgrades.upgraded_id' => $user->id)))->count();
                      if($i <= 100000) {
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $user->username; ?></td>
                          <td><?php echo $user->name; ?></td>
                          <td><?php echo $user->email; ?></td>
                          <td><?php echo $user->contact_number; ?></td>
                          <td style="white-space:nowrap;">
                            <?php
                            $status_cls = 'inactive-staus';
                            $status_txt = 'Inactive';
                            if($user->status == 1){
                              $status_cls = 'active-staus';
                              $status_txt = 'Active';
                            }?>
                            <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                          </td>
                          <td><?php echo $user->Sponsers['username']; ?></td>
                          <td><?php echo $user->sponsor_name; ?></td>
                        </tr>
                    <?php
                      } else {
                        $numberOfUnit = 'N/A';
                        if(!empty($user->PlotPayments['number_of_unit'])){
                          $numberOfUnit = number_format($user->PlotPayments['number_of_unit']);
                        }
                        $gender = 'Female';
                        if($user->Details['gender'] == 'male'){
                          $gender = 'Male'; 
                        }
                        $panNumber = 'N/A';
                        if(!empty($user->Details['pan_number'])){
                           $panNumber = $user->Details['pan_number']; 
                        }
                        $accountNumber = 'N/A';
                        if(!empty($user->Details['account_number'])){
                          $accountNumber = $user->Details['account_number']; 
                        }
                        $totalUpgraded = $upgradesTable->find('all', array('conditions' => array('Upgrades.upgraded_id' => $user->id)))->count();
                        $block_txt = 'No';
                        $block_cls = 'active-staus';
                        if($user->is_blocked == 1){
                          $block_txt = 'Yes';
                          $block_cls = 'inactive-staus';
                        }

                        $status_cls = 'inactive-staus';
                        $status_txt = 'Inactive';
                        if($user->status == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Active';
                        }

                        $actionDopDown = ' <div class="btn-group">
                            <button class="btn btn-outline-secondary dropdown-toggle waves-effect waves-themed" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                -Select-
                            </button>
                            <div class="dropdown-menu" style="">
                              <a class="dropdown-item" href="'.$backend_url.'/user/view-user/'.base64_encode($user->id).'" target="_blank">View</a> 
                              <a class="dropdown-item" href="'.$backend_url.'/user/upgrade/'.$user->id.'">Upgrade</a> 
                              <a class="dropdown-item" href="'.$backend_url.'/user/edit-account/'.$user->id.'">Change Password</a> 
                              <a class="dropdown-item" href="'.$backend_url.'/user/edit-profile/'.$user->id.'">Edit Profile</a> 
                              <a class="dropdown-item" href="'.$backend_url.'/user/kyc/'.$user->id.'">KYC</a> 
                              <a class="dropdown-item" href="'.$backend_url.'/users/block/'.$user->id.'">Block</a> 
                              <a class="dropdown-item" href="'.$backend_url.'/users/unblock/'.$user->id.'">Unblock</a>
                            </div>
                         </div>';
                        $arrOtherUser[] =[
                          $srNumber++, 
                          $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')', 
                          $user->Epins['epin'], 
                          $user->rank, 
                          $numberOfUnit,
                          $user->Details['first_name'].' '.$user->Details['last_name'], 
                          $user->Details['father_name'],
                          $user->Details['dob'],
                          $gender,
                          $panNumber, 
                          $user->Details['contact_no'], 
                          $user->Details['city_name'],
                          $user->States['name'], 
                          $user->Details['address'], 
                          $accountNumber, 
                          $user->Details['ifsc_code'], 
                          $user->Details['nominee_name'], 
                          $user->Details['relationship'], 
                          $totalUpgraded,
                          '<div class="whitetext-1 '.$block_cls.'">'.$block_txt.'</div>',
                          '<div class="whitetext-1 '.$status_cls.'">'.$status_txt.'</div>',
                          $actionDopDown
                        ];
                      }
                      $i++;
                    }
                  }?>
               </tbody>
            </table>
          </div> 
        <?php echo $this->Form->end();?>
        <div class="row margin-top-10">
          <div class="col-sm-12">
            <!-- <button id="loadMoreRow" type="button" class="btn btn-small btn-success rounded-pill px-4">Load full data</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>

<button type="button" id="wallet_deduction_link" class="
    btn btn-light-success
    text-success
    font-weight-medium
    btn-lg
    px-4
    fs-4
    font-weight-medium
  " data-bs-toggle="modal" data-bs-target="#wallet_deduction" style="display: none;">
  Success Alert
</button>
<div class="modal fade" id="wallet_deduction" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 id="amount_title" class="modal-title" id="myLargeModalLabel"></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="tbl_aojora_amount_container" class="modal-body">
          Wallet Deduction
        </div>
        <div class="modal-footer">
          <button type="button" class="
              btn btn-light-danger
              text-danger
              font-weight-medium
              waves-effect
              text-start
            " data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>