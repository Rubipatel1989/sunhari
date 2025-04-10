<div class="col-md-12">
  <div class="row nopadding table-cotainer">
      <table id="table-in-popup" class="table table-bordered table-hover table-striped w-100">
         <thead>
            <tr>
              <th>Sr</th>
              <th style="white-space: nowrap;">Payout Amount</th>
              <th style="white-space: nowrap;">Deduct Amount</th>
              <th style="white-space: nowrap;">Date</th>
            </tr>
         </thead>
         <tbody>
            <?php
            /*echo '<pre>';
            print_r($fundrequests);exit;*/
            if($fundrequests){
              $i = 1;
              foreach($fundrequests as $fundrequest){
                if($fundrequest->btc_value) {
                  $deductAmount = ($fundrequest->btc_value * 10)/100;
                
              ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td style="white-space: nowrap;"><?php echo number_format(($fundrequest->btc_value ?? 0), 2); ?></td>
                      <td style="white-space: nowrap;"><?php echo number_format(($deductAmount ?? 0), 2); ?></td>
                      <td style="white-space: nowrap;"><?php echo date("d/m/Y g:i:a", strtotime($fundrequest->created)); ?></td>
                    </tr>
              <?php
                    $i++;
                  }
                }
            }?>
         </tbody>
      </table>
  </div>
</div>