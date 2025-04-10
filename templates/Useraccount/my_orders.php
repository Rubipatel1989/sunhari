<?php
use Cake\ORM\TableRegistry;
echo $this->Html->css('frontend/css/my-account.css');
$productsTable  = TableRegistry::get('Products');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   My Orders
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
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
                                  <th>Date</th>
                                  <th>Order Info</th>
                                  <th>Delivery Info.</th>
                                  <th>Grand Total</th>
                                  <th>Status</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($orders)){
                                  $i=1;
                                  foreach($orders as $order){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($order->created)); ?></td>
                                      <td>
                                        
                                        Order Id : <strong><?php echo $order->order_id; ?></strong>
                                        <table cellpadding="0" cellspacing="0" border="0" class="tbl-order-info">
                                          <tr>
                                            <td style="border-bottom: 1px solid #222;"><strong>Product</strong></td>
                                            <td style="border-bottom: 1px solid #222;"><strong>Qty.</strong></td>
                                            <td style="border-bottom: 1px solid #222;"><strong>Pirce</strong></td>
                                          </tr>
                                          <?php
                                          foreach($order->ordereditems as $ordereditems){
                                            $prodctInfo = $productsTable->find('all', array('fields' => array('Products.name'), 'conditions' => array('Products.id' => $ordereditems->product_id)))->first();
                                          ?>
                                            <tr>
                                              <td><?php echo $prodctInfo->name; ?></td>
                                              <td><?php echo number_format($ordereditems->quantity);?></td>
                                              <td>Rs <?php echo number_format($ordereditems->price, 2);?></td>
                                            </tr>
                                          <?php
                                          }?>
                                        </table>
                                      </td>
                                      <td>
                                        Name : <strong><?php echo $order->first_name.' '.$order->last_name; ?></strong>
                                        <br> Email : <strong><?php echo $order->email; ?></strong>
                                        <br> Contact No. : <strong><?php echo $order->contact_no; ?></strong>
                                        <br> Address : <strong><?php echo $order->delivery_address; ?></strong>
                                      </td>
                                      <td>
                                        <?php
                                        if(!empty($order->discount_price)){?>
                                            <span class="primary-price"><span class="package-currency">Rs</span><?php echo number_format($order->price, 2); ?></span>
                                            &nbsp;<span class="final-price"><span class="package-currency">Rs</span><?php echo number_format($order->discount_price, 2); ?></span>
                                        <?php
                                        }else{?>
                                            <span class="package-currency">Rs </span><?php echo number_format($order->grand_total, 2); ?>
                                          <?php
                                         }?>
                                      </td>
                                      <td>
                                        <?php
                                        $status_cls = 'processing-staus';
                                        $status_txt = 'Processing';
                                        if($order->status == 2){
                                          $status_cls = 'completed-staus';
                                          $status_txt = 'Delivered';
                                        }
                                        elseif($order->status == 3){
                                          $status_cls = 'cancelled-staus';
                                          $status_txt = 'Cancelled';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
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