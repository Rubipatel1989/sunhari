<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Royal List</h3>
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
          Royal List
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
         <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <div class="row nopadding">
            <div class="col nopadding">
              <?php 
              $royalty_number = isset($_GET['royalty_number']) ? $_GET['royalty_number'] : '';
              $options = [
                '' => '-Select-',
                '1' => 'Royalty One',
                '2' => 'Royalty Two',
                '3' => 'Royalty Three',
                '4' => 'Royalty Four',
                '5' => 'Royalty Five',
                '6' => 'Royalty Six',
                '7' => 'Royalty Seven',
                '8' => 'Royalty Eight',
                '9' => 'Royalty Nine',
                '10' => 'Royalty Ten',
                '11' => 'Royalty Eleven',
                '12' => 'Royalty Twelve',
                '13' => 'Royalty Thirteen'
              ];
              echo $this->Form->input('royalty_number', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter User Id', 'default' => $royalty_number)); 
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
                    <th>User Id</th>
                    <th>Name</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $arrOtherUser = [];
                  if(!empty($users)){
                    $i=1;
                    foreach($users as $user){
                      if($i <= 100000) {
                    ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td style="white-space: nowrap;"><?php echo $user->username; ?></td>
                          <td><?php echo $user->name; ?></td>
                        </tr>
                    <?php
                      } else {
                        $arrOtherUser[] =[
                          $srNumber++, 
                          $user->username, 
                          $user->name
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