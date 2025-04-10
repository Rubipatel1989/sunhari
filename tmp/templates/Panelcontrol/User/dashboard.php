<main id="js-page-content" role="main" class="page-content">
   <ol class="breadcrumb page-breadcrumb">
       <li class="breadcrumb-item active"> Dashboard</li>
       <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
   </ol>
   <div class="row">
       <div class="col-sm-6 col-xl-3">
           <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
               <div class="">
                   <h3 class="display-4 d-block l-h-n m-0 fw-500">
                       <?php 
                       $todayTransaction = 0;
                       if(isset($adminStatistics[0]['todayTransaction']) && !empty($adminStatistics[0]['todayTransaction'])){
                          $todayTransaction = $adminStatistics[0]['todayTransaction'];
                       } 
                       ?>
                       Rs <?php echo number_format($todayTransaction, 2); ?>
                       <small class="m-0 l-h-n">Today transactions</small>
                   </h3>
               </div>
               <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
           </div>
       </div>
       <div class="col-sm-6 col-xl-3">
           <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
               <div class="">
                   <h3 class="display-4 d-block l-h-n m-0 fw-500">
                       <?php 
                       $monthlyTransaction = 0;
                       if(isset($adminStatistics[0]['monthlyTransaction']) && !empty($adminStatistics[0]['monthlyTransaction'])){
                          $monthlyTransaction = $adminStatistics[0]['monthlyTransaction'];
                       } 
                       ?>
                       Rs <?php echo number_format($monthlyTransaction, 2); ?>
                       <small class="m-0 l-h-n">This month transactions</small>
                   </h3>
               </div>
               <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
           </div>
       </div>
       <div class="col-sm-6 col-xl-3">
           <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
               <div class="">
                   <h3 class="display-4 d-block l-h-n m-0 fw-500">
                       <?php 
                       $yearlyTransaction = 0;
                       if(isset($adminStatistics[0]['yearlyTransaction']) && !empty($adminStatistics[0]['yearlyTransaction'])){
                          $yearlyTransaction = $adminStatistics[0]['yearlyTransaction'];
                       } 
                       ?>
                      Rs <?php echo number_format($yearlyTransaction, 2); ?>
                       <small class="m-0 l-h-n">This year transactions</small>
                   </h3>
               </div>
               <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
           </div>
       </div>
       <div class="col-sm-6 col-xl-3">
           <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
               <div class="">
                   <h3 class="display-4 d-block l-h-n m-0 fw-500">
                       <?php 
                       $totalTransaction = 0;
                       if(isset($adminStatistics[0]['totalTransaction']) && !empty($adminStatistics[0]['totalTransaction'])){
                          $totalTransaction = $adminStatistics[0]['totalTransaction'];
                       } 
                       ?>
                       Rs <?php echo number_format($totalTransaction, 2); ?>
                       <small class="m-0 l-h-n">Total tansactions</small>
                   </h3>
               </div>
               <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
           </div>
       </div>
   </div>
   <div class="row">
       <div class="col-lg-12">
           <div id="panel-4" class="panel">
               <div class="panel-hdr">
                   <h2>
                       Recent Transactions
                   </h2>
               </div>
               <div class="panel-container show">
                   <div class="panel-content">
                       <div class="row nopadding table-cotainer">
                           <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                               <thead>
                                     <tr>
                                        <th class="nowrap">Sr. No.</th>
                                        <th class="nowrap">Transaction Id</th>
                                        <th class="nowrap">Username</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th class="nowrap">Transfered by</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                     if(!empty($wallets)){
                                        $i=1;
                                        foreach($wallets as $wallet){?>
                                           <tr class="gradeX">
                                             <td><?php echo $i; ?></td>
                                             <td><?php echo $wallet->transaction_id; ?></td>
                                             <td><?php echo $wallet->Users['username']; ?></td>
                                             <td><?php echo $wallet->Details['first_name'].' '.$wallet->Details['last_name']; ?></td>
                                             <td><?php echo number_format($wallet->amount, 2); ?></td>
                                             <td><?php echo $wallet->Payer['username']; ?></td>
                                             <td>
                                               <?php
                                               
                                               $status_cls = 'inactive-staus';
                                               $status_txt = 'Pending';
                                               if($wallet->status == 1){
                                                 $status_cls = 'active-staus';
                                                 $status_txt = 'Approved';
                                               }?>
                                               <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                             </td>
                                             <td>
                                               <div class="btn-group">
                                                 <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                 </button>
                                                 <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                    <li><a href="<?php echo $backend_url; ?>/wallet/edit/<?php echo $wallet->transaction_id; ?>">Edit</a> 
                                                    </li>
                                                    <li><a href="<?php echo $backend_url; ?>/wallet/update-status/<?php echo $wallet->id; ?>/1">Approve</a>
                                                    </li>
                                                    <li><a href="<?php echo $backend_url; ?>/wallet/update-status/<?php echo $wallet->id; ?>/0">Pending</a>
                                                    </li>
                                                    <li><a onclick="return confirm('Delete operation will the data permanently from database. Are you sure?');" href="<?php echo $backend_url; ?>/wallet/delete/<?php echo $wallet->id; ?>">Delete</a>
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
       <div class="col-lg-6">
           <div id="panel-2" class="panel panel-locked" data-panel-sortable data-panel-collapsed data-panel-close>
               <div class="panel-hdr">
                   <h2>
                       5 Recent Pending Payment Request
                   </h2>
               </div>
               <div class="panel-container show">
                    <div class="panel-content p-0">
                        <div class="d-flex flex-column">
                            <div class="bg-subtlelight-fade custom-scroll" style="height: 244px">
                                <div class="h-100">
                                    <?php
                                    if(!empty($fundrequests)){
                                        foreach($fundrequests as $fundrequest){
                                            $profilePic =  $home_url.'/backend/img/user/01.jpg';
                                            if(!empty($fundrequest->Attachments['file'])){
                                                $profilePic =  $home_url.'/attachments/'.$fundrequest->Attachments['file'];
                                            }
                                            ?>
                                            <div class="d-flex flex-row px-3 pt-3 pb-2">
                                                <!-- profile photo : lazy loaded -->
                                                <span class="status status-danger">
                                                    <span class="profile-image rounded-circle d-inline-block" style="background-image:url('<?php echo $profilePic; ?>')"></span>
                                                </span>
                                                <!-- profile photo end -->
                                                <div class="ml-3">
                                                    <a href="javascript:void(0);" title="Lisa Hatchensen" class="d-block fw-700 text-dark"><?php echo $fundrequest->Users['username']; ?> <small class="pull-right"><?php echo date("F j, Y", strtotime($fundrequest->created)); ?></small></a>
                                                    <p class="mb-sm">
                                                       <strong>Transaction Id : </strong> <small><?php echo $fundrequest->transaction_id; ?></small>
                                                    </p>
                                                    <p class="mb-sm">
                                                       <strong>$ Value : </strong> <small><?php echo number_format($fundrequest->btc_value, 2); ?></small>
                                                    </p>
                                                    <p class="mb-sm">
                                                        <small><?php echo html_entity_decode( $fundrequest->remark); ?></small>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php 
                                        }
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
       </div>
       <div class="col-lg-6">
           <div id="panel-3" class="panel panel-locked" data-panel-sortable data-panel-collapsed data-panel-close>
                <div class="panel-hdr">
                   <h2>
                       5 Recent Tickets
                   </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content p-0">
                        <div class="d-flex flex-column">
                            <div class="bg-subtlelight-fade custom-scroll" style="height: 244px">
                                <div class="h-100">
                                    <?php
                                      if(!empty($tickets)){
                                         foreach($tickets as $ticket){?>
                                            <div class="d-flex flex-row px-3 pt-3 pb-2">
                                                <div class="ml-3">
                                                    <a href="javascript:void(0);" title="Lisa Hatchensen" class="d-block fw-700 text-dark"><?php echo $ticket->subject; ?></a>
                                                    <p class="mb-sm">
                                                       <strong>Date : </strong> <small><?php echo date("F j, Y", strtotime($ticket->created)); ?></small>
                                                    </p>
                                                    <p class="mb-sm">
                                                       <strong>Ticket By : </strong> <small><?php echo $ticket->Users['username']; ?></small>
                                                    </p>
                                                    <p class="mb-sm">
                                                        <small><?php echo $ticket->description; ?></small>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php 
                                        }
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
       </div>
   </div>
</main>