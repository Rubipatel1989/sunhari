<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0"> Parent Report</h3>
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
          Parent Report
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
              $username = isset($_GET['username']) ? $_GET['username'] : '';
              echo $this->Form->input('username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', "placeholder" => 'Enter User Id', 'value' => $username)); 
               ?>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-12">
          <div class="row nopadding table-cotainer">
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
                <thead>
                  <tr>
                     <th style="white-space: nowrap;">Sr. No.</th>
                     <th style="white-space: nowrap;">User Id</th>
                     <th style="white-space: nowrap;">Name</th>
                     <th style="white-space: nowrap;">Sponser Id</th>
                     <th style="white-space: nowrap;">Sponser Name</th>
                     <th style="white-space: nowrap;">Current Rank</th>
                     <th style="white-space: nowrap;">Level</th>
                  </tr>
               </thead>
               <tbody>
                    <?php 
                    if(count($downlines) > 0){
                        $i=1;
                        foreach($downlines as $downline){
                        ?>
                            <tr class="gradeX">
                              <td style="white-space: nowrap;"><?php echo $i; ?></td>
                              <td style="white-space: nowrap;"><?php echo $downline->Users['username']; ?></td>
                              <td style="white-space: nowrap;"><?php echo $downline->Users['name']; ?></td>
                              <td style="white-space: nowrap;"><?php echo $downline->Sponsors['username']; ?></td>
                              <td style="white-space: nowrap;"><?php echo $downline->Sponsors['name']; ?></td>
                               <td style="white-space: nowrap;"><?php echo $this->UserData->getRankLabelById($downline->Users['current_rank']); ?></td>
                              <td style="white-space: nowrap;"><?php echo $downline->level; ?></td>
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
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>