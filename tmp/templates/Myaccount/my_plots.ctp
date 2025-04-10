<?php
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">My Plots</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      My Plots
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
                                  <th style="white-space: nowrap;">Sr. No.</th>
                                  <th style="white-space: nowrap;">Plot No</th>
                                  <th style="white-space: nowrap;">Property</th>
                                  <th style="white-space: nowrap;">Site</th>
                                  <th style="white-space: nowrap;">Block</th>
                                  <th style="white-space: nowrap;">Amount</th>
                                  <th style="white-space: nowrap;">Discount</th>
                                  <th style="white-space: nowrap;">Total Deposit</th>
                                  <th style="white-space: nowrap;">Rest Amount</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($assignPlots)){
                                  $i=1;
                                  foreach($assignPlots as $assignPlot){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td>
                                        <?php echo $assignPlot->plot_number; ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo $assignPlot->Properties['title']; ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo $assignPlot->Sites['title']; ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo $assignPlot->Blocks['title']; ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo number_format($assignPlot->grand_total, 2); ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo number_format($assignPlot->discount, 2); ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo number_format($assignPlot->total_paid_payment, 2); ?>
                                      </td>
                                       <td style="white-space: nowrap;">
                                        <?php echo number_format(($assignPlot->grand_total - ($assignPlot->total_paid_payment + $assignPlot->discount)), 2); ?>
                                      </td>
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