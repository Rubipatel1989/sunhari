<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Transferred Epins</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Transferred Epins
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <form name="epin_list_form" id="epin_list_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                        <div class="row nopadding table-cotainer">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Transferred On</th>
                                    <th>Epin</th>
                                    <th>Transferred To</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($epinHistories)){
                                  $i=1;
                                  foreach($epinHistories as $epinHistory){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($epinHistory->created)); ?></td>
                                      <td><?php echo $epinHistory->Epins['epin']; ?></td>
                                      <td><?php echo $epinHistory->TransferredTo['username'].' ( '.$epinHistory->DetialsTo['first_name'].' '.$epinHistory->DetialsTo['last_name'].' )'; ?></td>
                                    </tr>
                                  <?php
                                    $i++;
                                  }
                                }?>
                             </tbody>
                          </table>
                        </div> 
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>