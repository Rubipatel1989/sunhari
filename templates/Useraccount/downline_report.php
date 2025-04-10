<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Downline Team</h3>
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
          <a href="<?php echo $home_url; ?>/my-account">Dashboard</a>
        </li>
        <li class="breadcrumb-item active d-flex align-items-center">
          Downline Team
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
            <table id="table-with-download" class="table table-bordered table-hover table-striped w-100">
                <thead>
                    <tr>
                       <th style="white-space: nowrap;">Sr. No.</th>
                       <th style="white-space: nowrap;">ID</th>
                       <th style="white-space: nowrap;">Sponser</th>
                       <th style="white-space: nowrap;">Level</th>
                       <th style="white-space: nowrap;">Date & Time</th>
                       <th style="white-space: nowrap;">Customers</th>
                    </tr>
                 </thead>
                 <tbody>
                      <?php 
                      if(count($downlines) > 0){
                          $i=1;
                          foreach($downlines as $downline){
                              if($downline->Users['status'] == 1){
                                  $status = 'Active';
                              }else{
                                   $status = 'Registered';
                              }
                          ?>
                              <tr class="gradeX">
                                  <td style="white-space: nowrap;"><?php echo $i; ?></td>
                                  <td style="white-space: nowrap;"><?php echo $downline->Users['username']; ?></td>
                                  <td style="white-space: nowrap;"><?php echo $downline->Sponsers['username']; ?></td>
                                  <td style="white-space: nowrap;"><?php echo $downline->level; ?></td>
                                  <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($downline->modified); ?></span><?php echo date('d M Y', strtotime($downline->modified)); ?></td>
                                  <td style="white-space: nowrap;"><a href="<?php echo $home_url; ?>/my-account/team/customers?username=<?php echo $downline->Users['username']; ?>">View</a></td>
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