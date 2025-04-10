<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Plots</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Plots
                    </h2>
                     <a href="<?php echo $backend_url ?>/setting/add-tax-and-commission" class="float-right margin-right-15"><i class="fa fa-plus"></i> Add Tax & Commission </a>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-xs-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <div class="row nopadding table-cotainer">
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                           <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Tax (in %)</th>
                                  <th>Amount (in %)</th>
                                  <th>Remark</th>
                                  <th>Status</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($commissions)){
                                  $i=1;
                                  foreach($commissions as $commission){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo number_format($commission->tax, 2); ?></td>
                                      <td><?php echo number_format($commission->amount, 2); ?></td>
                                      <td><?php if($commission->remark != ''){echo html_entity_decode($commission->remark);}else{echo 'N/A';} ?></td>
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($commission->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                      </td>
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
        </div>
    </div>
</main>