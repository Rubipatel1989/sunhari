<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Staffs</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Staffs
                    </h2>
                     <a href="<?php echo $backend_url ?>/staffs/add" class="float-right margin-right-15"><i class="fa fa-plus"></i> Add Staff</a>
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
                                  <th>Name</th>
                                  <th>Role</th>
                                  <th>Is Block</th>
                                  <th>Status</th>
                                  <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              if(!empty($users)){
                                $i=1;
                                foreach($users as $user){
                                ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $user->Details['first_name'].' '.$user->Details['last_name']; ?></td>
                                    <td><?php echo $user->Roles['title']; ?></td>
                                    <td>
                                      <?php 
                                      $block_txt = 'No';
                                      $block_cls = 'active-staus';
                                      if($user->is_blocked == 1){
                                        $block_txt = 'Yes';
                                        $block_cls = 'inactive-staus';
                                      }
                                      ?>
                                       <div class="whitetext-1 <?php echo $block_cls; ?>"><?php echo $block_txt; ?></div>
                                    </td>
                                    <td>
                                      <?php
                                      
                                      $status_cls = 'inactive-staus';
                                      $status_txt = 'Inactive';
                                      if($user->status == 1){
                                        $status_cls = 'active-staus';
                                        $status_txt = 'Active';
                                      }?>
                                      <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                    </td>
                                    <td>
                                      <div class="btn-group">
                                        <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                        </button>
                                        <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                          <li class="dropdown-item">
                                            <a href="<?php echo $backend_url; ?>/staffs/edit/<?php echo $user->id; ?>">Edit</a> 
                                          </li>
                                          <li class="dropdown-item">
                                            <a href="<?php echo $backend_url; ?>/staffs/block/<?php echo $user->id; ?>">Block</a> 
                                          </li>
                                          <li class="dropdown-item">
                                            <a href="<?php echo $backend_url; ?>/staffs/unblock/<?php echo $user->id; ?>">Unblock</a> 
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