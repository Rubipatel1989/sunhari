<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>Dashboard
</h3>
<div data-toggle="notify" data-onload data-message="&lt;b&gt;This is notify!&lt;/b&gt; Dismiss with a click or wait for it to disappear." data-options="{&quot;status&quot;:&quot;warning&quot;, &quot;pos&quot;:&quot;bottom-right&quot;}" class="hidden-xs"></div>
<div class="row">
   <!-- START dashboard main content-->
   <section class="col-md-9">
      <!-- START chart-->
      <div class="row">
         <div class="col-lg-12">
            <!-- START widget-->
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                           <table id="packages" class="table table-striped table-hover">
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
            <!-- END widget-->
         </div>
      </div>
      <!-- END chart-->
      <div class="row">
         <div class="col-md-4">
            <!-- START widget-->
            <div data-toggle="play-animation" data-play="fadeInLeft" data-offset="0" data-delay="100" class="panel widget">
               <div class="panel-body bg-primary">
                  <div class="row row-table row-flush">
                     <div class="col-xs-8">
                        <p class="mb0">Total Members</p>
                        <h3 class="m0">
                           <?php 
                           $totalMember = 0;
                           if(isset($adminStatistics[0]['totalMember']) && !empty($adminStatistics[0]['totalMember'])){
                              $totalMember = $adminStatistics[0]['totalMember'];
                           }
                           echo number_format($totalMember); 
                           ?> 
                        </h3>
                     </div>
                     <div class="col-xs-4 text-right">
                        <em class="fa fa-users fa-2x"></em>
                     </div>
                  </div>
               </div>
               <div class="panel-body">
                  <!-- Bar chart-->
                  <div class="text-center">
                     <div data-width="100%" data-resize="true" data-bar-color="primary" data-height="30" data-bar-width="6" data-bar-spacing="6" data-values="[5,3,4,6,5,9,4,4,10,5,9,6,4]" class="inlinesparkline"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <!-- START widget-->
            <div data-toggle="play-animation" data-play="fadeInDown" data-offset="0" data-delay="100" class="panel widget">
               <div class="panel-body bg-success">
                  <div class="row row-table row-flush">
                     <div class="col-xs-8">
                        <p class="mb0">Total Upgraded</p>
                        <h3 class="m0">
                           <?php 
                           $totalUpgraded = 0;
                           if(isset($adminStatistics[0]['totalUpgraded']) && !empty($adminStatistics[0]['totalUpgraded'])){
                              $totalUpgraded = $adminStatistics[0]['totalUpgraded'];
                           }
                           echo number_format($totalUpgraded); 
                           ?> 
                        </h3>
                     </div>
                     <div class="col-xs-4 text-right">
                        <em class="fa fa-users fa-2x"></em>
                     </div>
                  </div>
               </div>
               <div class="panel-body">
                  <!-- Bar chart-->
                  <div class="text-center">
                     <div data-width="100%" data-resize="true" data-bar-color="success" data-height="30" data-bar-width="6" data-bar-spacing="6" data-values="[10,30,40,70,50,90,70,50,90,40,40,60,40]" class="inlinesparkline"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <!-- START widget-->
            <div data-toggle="play-animation" data-play="fadeInRight" data-offset="0" data-delay="100" class="panel widget">
               <div class="panel-body bg-danger">
                  <div class="row row-table row-flush">
                     <div class="col-xs-8">
                        <p class="mb0">Company Direct</p>
                        <h3 class="m0">
                           <?php 
                           $totalDirectCompany = 0;
                           if(isset($adminStatistics[0]['totalDirectCompany']) && !empty($adminStatistics[0]['totalDirectCompany'])){
                              $totalDirectCompany = $adminStatistics[0]['totalDirectCompany'];
                           }
                           echo number_format($totalDirectCompany
                           ); 
                           ?>
                        </h3>
                     </div>
                     <div class="col-xs-4 text-right">
                        <em class="fa fa-users fa-2x"></em>
                     </div>
                  </div>
               </div>
               <div class="panel-body">
                  <!-- Bar chart-->
                  <div class="text-center">
                     <div data-width="100%" data-resize="true" data-bar-color="danger" data-height="30" data-bar-width="6" data-bar-spacing="6" data-values="[2,7,5,9,4,2,7,5,7,5,9,6,4]" class="inlinesparkline"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- START messages and activity-->
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <div class="pull-right label label-success"><?php echo $totalPaymentRequest; ?></div>
                  <div class="panel-title">5 Recent Pending Payment Request</div>
               </div>
               <!-- START list group-->
               <div class="list-group">
                  <?php
                  if(!empty($fundrequests)){
                     foreach($fundrequests as $fundrequest){
                     ?>
                        <a href="#" class="list-group-item">
                           <div class="media">
                              <div class="pull-left">
                              <?php
                              $profilePic =  $home_url.'/backend/img/user/01.jpg';
                              if(!empty($fundrequest->Attachments['file'])){
                                 $profilePic =  $home_url.'/attachments/'.$fundrequest->Attachments['file'];
                              }
                              ?>
                                 <img src="<?php echo $profilePic; ?>" alt="Image" class="media-object img-circle thumb48">
                              </div>
                              <div class="media-body clearfix">
                                 <small class="pull-right"><?php echo date("F j, Y", strtotime($fundrequest->created)); ?></small>
                                 <strong class="media-heading text-primary"> <?php echo $fundrequest->Users['username']; ?></strong>
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
                        </a>
                  <?php
                     }
                  }?>
               </div>
               <!-- END list group-->
               <!-- START panel footer-->
               <div class="panel-footer clearfix">
                  <a href="<?php echo $backend_url; ?>/wallet/fund-request" class="pull-left">
                     <small>See All Payment Request</small>
                  </a>
               </div>
               <!-- END panel-footer-->
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <div class="pull-right label label-success"><?php echo $totalTickets; ?></div>
                  <div class="panel-title">5 Recent Tickets</div>
               </div>
               <!-- START list group-->
               <div class="list-group">
                  <!-- START list group item-->
                  <?php
                  if(!empty($tickets)){
                     foreach($tickets as $ticket){
                     ?>
                        <div class="list-group-item">
                           <div class="media">
                              <div class="pull-left">
                                 <span class="fa-stack fa-lg">
                                    <em class="fa fa-circle fa-stack-2x text-warning"></em>
                                    <em class="fa fa-envelope-o fa-stack-1x fa-inverse text-white"></em>
                                 </span>
                              </div>
                              <div class="media-body clearfix">
                                 <div class="media-heading text-warning m0"><?php echo $ticket->subject; ?></div>
                                 <small class="text-muted pull-right"><?php echo date("F j, Y", strtotime($ticket->created)); ?></small>
                                 <p class="m0">
                                    <strong>Ticket By : </strong> <?php echo $ticket->Users['username']; ?>
                                 </p>
                                 <p class="m0">
                                    <small><?php echo $ticket->description; ?></small>
                                 </p>
                              </div>
                           </div>
                        </div>
                  <?php
                     }
                  }?>
                  <!-- END list group item-->
               </div>
               <!-- END list group-->
               <!-- START panel footer-->
               <div class="panel-footer clearfix">
                  <a href="<?php echo $backend_url ?>/support/tickets" class="pull-left">
                     <small>See All Tickets</small>
                  </a>
               </div>
               <!-- END panel-footer-->
            </div>
         </div>
      </div>
      <!-- END messages and activity-->
   </section>
   <!-- END dashboard main content-->
   <!-- START dashboard sidebar-->
   <aside class="col-md-3">
      <!-- START widget-->
      <div class="panel widget">
         <div class="panel-body text-center">
            <a href="#">
               <img src="<?php echo $home_url; ?>/frontend/img/logo.png" alt="" class="block-center img-rounded" style="max-width: 215px;">
            </a>
            <p>
               <strong>Welcome To Administrator</strong>
               
            </p>
         </div>
      </div>
      <!-- END widget-->
      <!-- START Secondary Widgets-->
      <!-- START widget-->
      <div class="panel widget">
         <div class="panel-body">
            <div class="text-right text-muted">
               <em class="fa fa-globe fa-2x"></em>
            </div>
            <h4 class="mt0">
               <?php 
               $todayTransaction = 0;
               if(isset($adminStatistics[0]['todayTransaction']) && !empty($adminStatistics[0]['todayTransaction'])){
                  $todayTransaction = $adminStatistics[0]['todayTransaction'];
               } 
               ?>
               Rs <?php echo number_format($todayTransaction, 2); ?>
            </h4>
            <p class="text-muted">Today transactions</p>
            <div class="progress progress-striped progress-xs">
               <div role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-purple progress-50">
                  <span class="sr-only">50% Complete</span>
               </div>
            </div>
         </div>
      </div>
      <!-- END widget-->
      <!-- START widget-->
      <div class="panel widget">
         <div class="panel-body">
            <div class="text-right text-muted">
               <em class="fa fa-gamepad fa-2x"></em>
            </div>
            <h4 class="mt0">
               <?php 
               $monthlyTransaction = 0;
               if(isset($adminStatistics[0]['monthlyTransaction']) && !empty($adminStatistics[0]['monthlyTransaction'])){
                  $monthlyTransaction = $adminStatistics[0]['monthlyTransaction'];
               } 
               ?>
               Rs <?php echo number_format($monthlyTransaction, 2); ?>
            </h4>
            <p class="text-muted">This month transactions</p>
            <div class="progress progress-striped progress-xs">
               <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-warning progress-60">
                  <span class="sr-only">60% Complete</span>
               </div>
            </div>
         </div>
      </div>
      <!-- END widget-->
      <!-- START widget-->
      <div class="panel widget">
         <div class="panel-body">
            <div class="text-right text-muted">
               <em class="fa fa-coffee fa-2x"></em>
            </div>
             <h4 class="mt0">
               <?php 
               $yearlyTransaction = 0;
               if(isset($adminStatistics[0]['yearlyTransaction']) && !empty($adminStatistics[0]['yearlyTransaction'])){
                  $yearlyTransaction = $adminStatistics[0]['yearlyTransaction'];
               } 
               ?>
              Rs <?php echo number_format($yearlyTransaction, 2); ?>
             </h4>
            <p class="text-muted">This year transactions</p>
            <div class="progress progress-striped progress-xs">
               <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-green progress-80">
                  <span class="sr-only">80% Complete</span>
               </div>
            </div>
         </div>
      </div>
      <!-- END widget-->
      <!-- START widget-->
      <div class="panel widget">
         <div class="panel-body">
            <div class="text-right text-muted">
               <em class="fa fa-upload fa-2x"></em>
            </div>
            <h4 class="mt0">
               <?php 
               $totalTransaction = 0;
               if(isset($adminStatistics[0]['totalTransaction']) && !empty($adminStatistics[0]['totalTransaction'])){
                  $totalTransaction = $adminStatistics[0]['totalTransaction'];
               } 
               ?>
               Rs <?php echo number_format($totalTransaction, 2); ?>
            </h4>
            <p class="text-muted">Total tansactions</p>
            <div class="progress progress-striped progress-xs">
               <div role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-info progress-40">
                  <span class="sr-only">40% Complete</span>
               </div>
            </div>
         </div>
      </div>
      <!-- END widget-->
      <!-- END Secondary Widgets-->
   </aside>
   <!-- END dashboard sidebar-->
</div>