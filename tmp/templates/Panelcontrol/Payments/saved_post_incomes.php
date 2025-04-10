<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Saved Post Incomes</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Saved Post Incomes
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <div class="row nopadding table-cotainer">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                              <thead>
                                <tr>
                                  <th style="white-space: nowrap;">Sr. No.</th>
                                  <th style="white-space: nowrap;">Total Upgrades</th>
                                  <th style="white-space: nowrap;">Gold</th>
                                  <th style="white-space: nowrap;">Platinum</th>
                                  <th style="white-space: nowrap;">Ambrand</th>
                                  <th style="white-space: nowrap;">Diamond</th>
                                  <th style="white-space: nowrap;">King</th>
                                  <th style="white-space: nowrap;">Status</th>
                                  <th style="white-space: nowrap;">Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($postIncomes)){
                                  $i=1;
                                  foreach($postIncomes as $postIncome){
                                  ?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $postIncome->number_of_upgraded_users; ?></td>
                                      <td><?php echo number_format($postIncome->gold, 2); ?></td>
                                      <td><?php echo number_format($postIncome->platinum, 2); ?></td>
                                      <td><?php echo number_format($postIncome->ambrand, 2); ?></td>
                                      <td><?php echo number_format($postIncome->diamond, 2); ?></td>
                                      <td><?php echo number_format($postIncome->king, 2); ?></td>
                                      <td>
                                        <?php
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Pending';
                                        if($postIncome->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Paid';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <?php
                                            if(empty($postIncome->status)){?>
                                              <li>
                                                <a href="<?php echo $backend_url; ?>/payments/pay-post-income/<?php echo $postIncome->id; ?>">Pay</a>
                                              </li>
                                            <?php
                                            }?>
                                          </ul>
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
        </div>
    </div>
</main>