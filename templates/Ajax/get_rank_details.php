<div class="col-md-12">
  <div class="row nopadding table-cotainer">
      <table id="table-in-popup" class="table table-bordered table-hover table-striped w-100">
         <thead>
            <tr>
              <th>Sr</th>
              <th style="white-space: nowrap;">Payout Amount</th>
              <th style="white-space: nowrap;">No. of Week</th>
              <th style="white-space: nowrap;">Total Week</th>
              <th style="white-space: nowrap;">Date</th>
            </tr>
         </thead>
         <tbody>
            <?php
            if($payouts){
              $i = 1;
              foreach($payouts as $payout){
              ?>
                  <tr class="gradeX">
                    <td><?php echo $i; ?></td>
                    <td style="white-space: nowrap;"><?php echo number_format(($payout->$amountType ?? 0), 2); ?></td>
                    <td style="white-space: nowrap;"><?php echo $i; ?> Weeks</td>
                    <td style="white-space: nowrap;">80 Weeks</td>
                    <td style="white-space: nowrap;"><?php echo date("d/m/Y g:i:a", strtotime($payout->created)); ?></td>
                  </tr>
              <?php
                  $i++;
                }
            }?>
         </tbody>
      </table>
  </div>
</div>