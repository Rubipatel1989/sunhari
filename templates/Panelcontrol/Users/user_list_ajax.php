<?php
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
$arr = [];
foreach($users as $user){
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
    $arr[] =[
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
echo json_encode($arr);