<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">All Customer Details</h3>
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
          All Customer Details
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
      <div class="col-sm-12 margin-bottom-20">
        <form name="filter_form" id="filter_form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <div class="row nopadding">
            <div class="col nopadding">
              <?php 
              $username = isset($_GET['username']) ? $_GET['username'] : '';
              echo $this->Form->input('username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter User Id', 'value' => $username)); 
               ?>
            </div>
            <div class="col">
              <?php 
              $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
              echo $this->Form->input('from_date', array('type' => 'date', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter From Date', 'value' => $from_date)); 
               ?>
            </div>
            <div class="col nopadding">
              <?php 
              $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
              echo $this->Form->input('to_date', array('type' => 'date', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter To Date', 'value' => $to_date)); 
               ?>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
               <thead>
                  <tr>
                    <th>Sr</th>
                    <th>Userid</th>
                    <th style="white-space:nowrap;">Added By</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Package</th>
                    <th style="white-space:nowrap;">Total Plan AB-18</th>
                    <th style="white-space:nowrap;">Total Plan Ab-18 Amount</th>
                    <th style="white-space:nowrap;">Total Plan MB</th>
                    <th style="white-space:nowrap;">Total Plan MB Amount</th>
                    <th>Status</th>
                    <th style="white-space:nowrap;">Sponsor ID</th>
                    <th style="white-space:nowrap;">Sponsor Name</th>
                    <th style="white-space:nowrap;">Joining Date</th>
                    <th style="white-space:nowrap;">Activation Date</th>
                    <th>Edit</th>
                    <th>Block</th>
                    <th>Dashboard</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $arrOtherUser = [];
                  $i=1;
                  if(!empty($users)){
                    foreach($users as $user){
                      $totalUpgraded = $upgradesTable->find('all', array('conditions' => array('Upgrades.upgraded_id' => $user->id)))->count();
                      if($i <= 100) {
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $user->username; ?></td>
                          <td style="white-space:nowrap;"><?php echo $user->AddedBy['username'].' ('.$user->AddedBy['name'].')'; ?></td>
                          <td><?php echo $user->name; ?></td>
                          <td><?php echo $user->email; ?></td>
                          <td><?php echo $user->contact_number; ?></td>
                          <td><?php echo number_format(($user->total_package_amount ?? 0), 2); ?></td>
                          <td><?php echo number_format(($user->total_plan_ab ?? 0)); ?></td>
                          <td><?php echo number_format(($user->total_plan_ab_amount ?? 0), 2); ?></td>
                          <td><?php echo number_format(($user->total_plan_mb ?? 0)); ?></td>
                          <td><?php echo number_format(($user->total_plan_mb_amount ?? 0)); ?></td>
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
                          <td style="white-space:nowrap;"><?php echo date("d M Y", strtotime($user->created)); ?></td>
                          <td style="white-space:nowrap;"><?php echo date("d M Y", strtotime($user->activation_date)); ?></td>
                          <td style="white-space:nowrap;"><a href="<?php echo $backend_url; ?>/users/edit-profile/<?php echo base64_encode($user->id); ?>">Edit Profile</a></td>
                          <td>
                            <?php 
                            if (!$user->is_blocked) {?>
                              <a href="javascript:blockUser('<?php echo $user->id; ?>');">Block</a>
                            <?php 
                            } else {?>
                              <a href="<?php echo $backend_url; ?>/customer/unblock/<?php echo $user->id; ?>/<?php echo base64_encode("username=".$username."&from_date=".$from_date."&to_date=".$to_date)?>">Unblock</a>
                              <br> <?php echo $user->block_reason_remark; ?>
                            <?php 
                            }?>
                          </td>
                          
                          <td><a href="<?php echo $backend_url; ?>/user/view-user/<?php echo base64_encode($user->id); ?>" target="_blank">Dashboard</a></td>
                        </tr>
                    <?php
                      } else {
                        $status_cls = 'inactive-staus';
                            $status_txt = 'Inactive';
                        if($user->status == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Active';
                        }
                        $status = '<div class="whitetext-1 '.$status_cls.'">'.$status_txt.'</div>';
                        $joiningDate = date("d M Y", strtotime($user->created));
                        $activationDate = date("d M Y", strtotime($user->activation_date));
                        $editProfileLink = '<a href="'.$backend_url.'/users/edit-profile/'. base64_encode($user->id).'">Edit Profile</a>';
                        $editProfileLink = '<a href="'.$backend_url.'/users/edit-profile/'. base64_encode($user->id).'">Edit Profile</a>';
                        if (!$user->is_blocked) {
                          $blockLink = '<a href="javascript:blockUser('.$user->id.');">Block</a>';
                        
                        } else {
                          $blockLink = '<a href="'.$backend_url.'/customer/unblock/'.$user->id.'/'.base64_encode('username='.$username.'&from_date='.$from_date.'&to_date='.$to_date).'">Unblock</a>
                          <br>'.$user->block_reason_remark;
                        }

                        $dashboardLink = '<a href="'.$backend_url.'/user/view-user/'. base64_encode($user->id).'" target="_blank">Dashboard</a>';

                        $arrOtherUser[] =[
                          $i, 
                          $user->username, 
                          $user->AddedBy['username'].' ('.$user->AddedBy['name'].')', 
                          $user->name, 
                          $user->email,
                          $user->contact_number,
                          number_format(($user->total_package_amount ?? 0), 2),
                          number_format(($user->total_plan_ab ?? 0)),
                          number_format(($user->total_plan_ab_amount ?? 0), 2),
                          number_format(($user->total_plan_mb ?? 0)),
                          number_format(($user->total_plan_mb_amount ?? 0)),
                          $status,
                          $user->Sponsers['username'],
                          $user->sponsor_name,
                          $joiningDate,
                          $activationDate,
                          $editProfileLink,
                          $blockLink,
                          $dashboardLink
                        ];
                      }
                      $i++;
                    }
                  }?>
               </tbody>
            </table>
          </div> 
        <?php echo $this->Form->end();?>
        <?php
        if ($i > 100) {?>
          <div class="row margin-top-10">
            <div class="col-sm-12">
              <button id="loadMoreRow" type="button" class="btn btn-small btn-success rounded-pill px-4">Load full data</button>
            </div>
          </div>
        <?php 
        }?>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>

<button type="button" id="block_user_link" class="
    btn btn-light-success
    text-success
    font-weight-medium
    btn-lg
    px-4
    fs-4
    font-weight-medium
  " data-bs-toggle="modal" data-bs-target="#bock_user" style="display: none;">
  Success Alert
</button>
<div class="modal fade" id="bock_user" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 id="amount_title" class="modal-title" id="myLargeModalLabel">Block Details</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create(NULL, array('id' => 'block_user_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <?php
            echo $this->Form->input('User.id', array('type' => 'hidden', 'id' => 'user_id', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => ''));
          ?>
          <div class="row" style="height: 120px;">
            <div class="col-sm-3 text-right">
              Remark<span class="red">*</span>
            </div>
            <div class="col-sm-9 text-left">
              <?php
                echo $this->Form->input('User.block_reason_remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'style' => 'height:100px;'));
              ?>
            </div>
          </div>
          <div class="row margin-top-20">
            <div class="col-sm-3 text-right">
              
            </div>
            <div class="col-sm-9 text-left">
             <button type="submit" class="btn btn-success px-4">
                <div class="d-flex align-items-center">
                  Submit
                </div>
              </button>
              <button type="button" class=" btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        <?php echo $this->Form->end();?>
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $("#loadMoreRow").click(function(){
      $(this).hide();
      var table = $('#packages').DataTable();
      table.rows.add(<?php echo json_encode($arrOtherUser); ?>);
      table .draw();
    });
  });
</script>