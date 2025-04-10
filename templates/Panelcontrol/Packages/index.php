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
                    <th>Wallet Address</th>
                    <th>Remark</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
             </thead>
             <tbody>
                <?php
                if(!empty($packages)){
                  $i=1;
                  foreach($packages as $package){?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $package->name; ?></td>

                      <td><?php echo $package->description; ?></td>
                      <td>
                        <?php
                        
                        $status_cls = 'inactive-staus';
                        $status_txt = 'Inactive';
                        if($package->status == 1){
                          $status_cls = 'active-staus';
                          $status_txt = 'Active';
                        }?>
                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                      </td>
                      <td>
                        <div class="btn-group btn-group-sm" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-light-secondary text-secondary font-weight-medium dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                           -Select-
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" data-popper-placement="bottom-start">
                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/packages/edit/<?php echo $package->id; ?>">Edit</a>
                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/packages/update_status/<?php echo $package->id; ?>/1">Active</a>
                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/packages/update_status/<?php echo $package->id; ?>/0">Inactive</a>
                            <a class="dropdown-item" onclick="return confirm('Delete operation will the data permanently from database. Are you sure?');" href="<?php echo $backend_url; ?>/packages/delete/<?php echo $package->id; ?>">Delete</a>
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