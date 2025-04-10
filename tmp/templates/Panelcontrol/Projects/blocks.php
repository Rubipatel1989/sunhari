<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Blocks</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Blocks
                    </h2>
                     <a href="<?php echo $backend_url ?>/projects/add-block" class="float-right margin-right-15"><i class="fa fa-plus"></i> Add New Block</a>
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
                                <th>Created On</th>
                                <th>Property</th>
                                <th>Site</th>
                                <th>Title</th>
                                <th>Remark</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              if(!empty($blocks)){
                                $i=1;
                                foreach($blocks as $block){?>
                                  <tr class="gradeX">
                                    <td style="vertical-align: top;"><?php echo $i; ?></td>
                                    <td style="vertical-align: top;"><?php echo date("F j, Y, g:i a", strtotime($block->created)); ?></td>
                                    <td style="vertical-align: top;"><?php echo $block->Properties['title']; ?></td>
                                    <td style="vertical-align: top;"><?php echo $block->Sites['title']; ?></td>
                                    <td style="vertical-align: top;"><?php echo $block->title; ?></td>
                                    <td style="vertical-align: top;"><?php echo $block->remark; ?></td>
                                    <td style="vertical-align: top;">
                                      <?php
                                      $status_cls = 'inactive-staus';
                                      $status_txt = 'Inactive';
                                      if($block->status == 1){
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
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/projects/edit-block/<?php echo base64_encode($block->id); ?>">Edit</a> 
                                          </li>
                                          <li>
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/projects/change-block-status/<?php echo base64_encode(1); ?>/<?php echo base64_encode($block->id); ?>">Active</a> 
                                          </li>
                                          <li>
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/projects/change-block-status/<?php echo base64_encode(0); ?>/<?php echo base64_encode($block->id); ?>">Inactive</a> 
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
</main>
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>