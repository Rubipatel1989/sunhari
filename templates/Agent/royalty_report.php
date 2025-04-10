<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Royalty Report</h3>
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
          Royalty Report
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
                    <th>Title</th>
                    <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  <tr class="gradeX">
                    <td>1</td>
                    <td>Royalty One</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_one == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>2</td>
                    <td>Royalty Two</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_two == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>3</td>
                    <td>Royalty Three</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_three == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>4</td>
                    <td>Royalty Four</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_four == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>5</td>
                    <td>Royalty Five</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_five == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>6</td>
                    <td>Royalty Six</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_six == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>7</td>
                    <td>Royalty Seven</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_seven == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>8</td>
                    <td>Royalty Eight</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_eight == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>9</td>
                    <td>Royalty Nine</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_nine == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>10</td>
                    <td>Royalty Ten</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_ten == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>11</td>
                    <td>Royalty Eleven</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_eleven == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>12</td>
                    <td>Royalty One</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_twelve == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
                  <tr class="gradeX">
                    <td>13</td>
                    <td>Royalty Thirteen</td>
                    <td style="white-space:nowrap;">
                      <?php
                      $status_cls = 'inactive-staus';
                      $status_txt = 'Not Achieved';
                      if($user->royalty_thirteen == 1){
                        $status_cls = 'active-staus';
                        $status_txt = 'Achieved';
                      }?>
                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                    </td>
                  </tr>
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
