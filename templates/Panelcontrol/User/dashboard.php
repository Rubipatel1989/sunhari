<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Dashboard</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span><img src="<?php echo $home_url; ?>/dist/libs/images/staff.png" alt=""/>
            </div>
            <div class="align-self-center">
              <a href="<?php echo $backend_url; ?>/agent/index"><h6 class="text-muted mt-2 mb-0">Total Agents</h6></a>
              <h2><?php echo number_format($adminStatistics[0]['totalAgents']); ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span><img src="<?php echo $home_url; ?>/dist/libs/images/staff.png" alt=""/>
            </div>
            <div class="align-self-center">
              <a href="<?php echo $backend_url; ?>/customer/index"><h6 class="text-muted mt-2 mb-0">Total Customers</h6></a>
              <h2><?php echo $adminStatistics[0]['totalCustomers']; ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span><img src="<?php echo $home_url; ?>/dist/libs/images/staff.png" alt=""/>
            </div>
            <div class="align-self-center">
              <a href="<?php echo $backend_url; ?>/customer/index/total-activation"><h6 class="text-muted mt-2 mb-0">Total Active Cutomers</h6></a>
              <h2><?php echo number_format($adminStatistics[0]['totalActiveCustomer']); ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/staff.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">Direct Agents</h6>
              <h2><?php echo number_format($adminStatistics[0]['totalDirectAgents']) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/staff.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">Direct Customers</h6>
              <h2><?php echo number_format($adminStatistics[0]['totalDirectCustomers']) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/staff.png"
                alt="Income"
              />
            </div>
            <div class="align-self-center">
              <a href="<?php echo $backend_url; ?>/customer/index/inactive-ids"><h6 class="text-muted mt-2 mb-0">Today Inactive Customers</h6></a>
              <h2><?php echo number_format($adminStatistics[0]['totalInactiveCustomers']); ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt="Income"
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">Total Packages</h6>
              <h2><?php echo number_format($adminStatistics[0]['totalPackages']); ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt="Income"
              />
            </div>
            <div class="align-self-center">
              <a href="<?php echo $backend_url; ?>/packages/plan-ab-list"><h6 class="text-muted mt-2 mb-0">Today Plan-AB</h6></a>
              <h2><?php echo number_format($adminStatistics[0]['totalPlanAB']); ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <?php 
              $totalPlanMB = $adminStatistics[0]['totalPlanMB'] ?? 0;
              ?>
              <a href="<?php echo $backend_url; ?>/packages/plan-mb-list"><h6 class="text-muted mt-2 mb-0">Total Plan MB</h6></a>
              <h2><?php echo number_format($totalPlanMB) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">Total Customer Business</h6>
              <h2><?php echo number_format($adminStatistics[0]['totalCustomerBusiness'], 2) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">Total Agent Business</h6>
              <h2><?php echo number_format($adminStatistics[0]['totalAgentBusiness'], 2) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">Total Payout</h6>
              <h2><?php echo number_format(0, 2) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">Today Payout</h6>
              <h2><?php echo number_format(0, 2) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">Today Admin Charge</h6>
              <h2><?php echo number_format(0, 2) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">2.5k Coupons</h6>
              <h2><?php echo number_format($adminStatistics[0]['total25kCoupons']) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">5k Coupons</h6>
              <h2><?php echo number_format($adminStatistics[0]['total50kCoupons']) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">7.5k Coupons</h6>
              <h2><?php echo number_format($adminStatistics[0]['total75kCoupons']) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex no-block">
            <div class="me-3 align-self-center">
              <span class="lstick d-inline-block align-middle"></span
              ><img
                src="<?php echo $home_url; ?>/dist/libs/images/expense.png"
                alt=""
              />
            </div>
            <div class="align-self-center">
              <h6 class="text-muted mt-2 mb-0">10k Coupons</h6>
              <h2><?php echo number_format($adminStatistics[0]['total100kCoupons']) ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="d-md-flex">
            <div>
              <h4 class="card-title">
                <span class="lstick d-inline-block align-middle"></span
                >Withdrawal Request
              </h4>
            </div>
            <div class="ms-auto">
              <a href="<?php echo $backend_url; ?>/wallet/withdrawal-request">View all</a>
            </div>
          </div>
          <div class="table-responsive mt-3">
            <table class="table v-middle no-wrap mb-0">
              <thead>
                <tr>
                  <th class="border-0">User Id</th>
                  <th class="border-0">Name</th>
                  <th class="border-0">Amount Details</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if($fundrequests) {
                  foreach($fundrequests as $fundrequest){
                    $amount = $fundrequest->btc_value;
                    $deduction = ($amount*10)/100;
                    $payoutAmount = $amount - $deduction;
                    ?>
                    <tr>
                      <td style="width: 50px">
                        <?php echo $fundrequest->Users['username']; ?>
                      </td>
                      <td>
                        <h6 class="mb-0 font-weight-medium" style="width:166px; white-space: normal;"><?php echo $fundrequest->Users['name']; ?></h6>
                      </td>
                      <td>
                        Payout Amount : <strong><?php echo number_format($amount, 2); ?></strong>
                        <br>Deduction : <strong><?php echo number_format($deduction, 2); ?> (10%)</strong>
                        <br>Paid Amount : <strong><?php echo number_format($payoutAmount, 2); ?></strong>
                      </td>
                    </tr>
                    <?php 
                  }
                } else {?>
                  <tr>
                    <td colspan="3" style="color: #d70f0f;">No withdrawal request are submitted.</td>
                  </tr>
                <?php 
                }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Activity widget find scss into widget folder-->
    <!-- -------------------------------------------------------------- -->
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="d-md-flex">
            <div>
              <h4 class="card-title">
                <span class="lstick d-inline-block align-middle"></span>Open Tickets
              </h4>
            </div>
            <div class="ms-auto">
              <a href="<?php echo $backend_url; ?>/support/tickets">View all</a>
            </div>
          </div>
          <div class="table-responsive mt-3">
            <table class="table v-middle no-wrap mb-0">
              <thead>
                <tr>
                  <th class="border-0">Date</th>
                  <th class="border-0">Ticket Id</th>
                  <th class="border-0">Ticket By</th>
                  <th class="border-0">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if($tickets) {
                  foreach($tickets as $ticket){
                    ?>
                    <tr>
                      <td>
                        <?php echo date("d/m/Y g:i a", strtotime($ticket->created)); ?>
                      </td>
                      <td>
                        <?php echo $ticket->ticket_id; ?>
                      </td>
                      <td>
                        <h6 class="mb-0 font-weight-medium" style="white-space: normal;"><?php echo $ticket->Users['username']; ?></h6>
                      </td>
                      <td><a href="<?php echo $backend_url; ?>/support/view_ticket/<?php echo $ticket->ticket_id; ?>">View</a></td>
                    </tr>
                    <?php 
                  }
                } else {?>
                  <tr>
                    <td colspan="4" style="color: #d70f0f;">No tickets are in open state.</td>
                  </tr>
                <?php 
                }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>