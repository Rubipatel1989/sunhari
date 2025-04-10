<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Sites
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/projects/add-site"><i class="fa fa-plus"></i> Add New Site</a>
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="wallets" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Created On</th>
                                  <th>Property</th>
                                  <th>Title</th>
                                  <th>Remark</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($sites)){
                                  $i=1;
                                  foreach($sites as $site){?>
                                    <tr class="gradeX">
                                      <td style="vertical-align: top;"><?php echo $i; ?></td>
                                      <td style="vertical-align: top;"><?php echo date("F j, Y, g:i a", strtotime($site->created)); ?></td>
                                      <td style="vertical-align: top;"><?php echo $site->Properties['title']; ?></td>
                                      <td style="vertical-align: top;"><?php echo $site->title; ?></td>
                                      <td style="vertical-align: top;"><?php echo $site->remark; ?></td>
                                      <td style="vertical-align: top;">
                                        <?php
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($site->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <td style="vertical-align: top;">
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/projects/edit-site/<?php echo base64_encode($site->id); ?>">Edit</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/projects/change-site-status/<?php echo base64_encode(1); ?>/<?php echo base64_encode($site->id); ?>">Active</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/projects/change-site-status/<?php echo base64_encode(0); ?>/<?php echo base64_encode($site->id); ?>">Inactive</a> 
                                            </li>
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
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>