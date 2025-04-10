<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Wallet List</h3>
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
          Wallet List
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
            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
               <thead>
                <tr>
                    <th  class="nowrap">Sr. No.</th>
                    <th>Account Details</th>
                    <th>UPI Details</th>
                    <th>Status</th>
                    <th>Remark</th>
                    <th>Action</th>
                </tr>
             </thead>
             <tbody>
                <?php
                if(!empty($payments)){
                  $i=1;
                  foreach($payments as $payment){?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td>
                        Account Number : <strong><?php echo $payment->account_number; ?></strong>
                        <br> Bank Name : <strong><?php echo $payment->bank_name; ?></strong>
                        <br> IFSC Code : <strong><?php echo $payment->ifsc_code; ?></strong>
                      </td>
                      <td>
                        UPI Id : <strong><?php echo $payment->upi_id; ?></strong>
                        <?php if ($payment->Attachments['file']) {?>
                          <br> <img src="<?php echo $home_url;?>/attachments/<?php echo $payment->Attachments['file']; ?>" alt="<?php echo $payment->Attachments['caption']; ?>" width="200" />
                        <?php }?>
                      </td>
                      <td>
                        <?php
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Inactive';
                        if($payment->status == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Active';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                      </td>
                      <td><?php echo $payment->remark; ?></td>
                      <td>
                        <div class="btn-group btn-group-sm" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-light-secondary text-secondary font-weight-medium dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                           -Select-
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" data-popper-placement="bottom-start">
                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/payments/edit/<?php echo $payment->id; ?>">Edit</a>
                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/payments/update_status/<?php echo $payment->id; ?>/1">Active</a>
                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/payments/update_status/<?php echo $payment->id; ?>/0">Inactive</a>
                            <a class="dropdown-item" onclick="return confirm('Delete operation will the data permanently from database. Are you sure?');" href="<?php echo $backend_url; ?>/payments/delete/<?php echo $payment->id; ?>">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php
                    $i++;
                  }
                }?>
             </tbody>
            </table>
          </div> 
        <?php echo $this->Form->end();?>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>