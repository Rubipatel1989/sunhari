<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Products
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/products/add"><i class="fa fa-plus"></i> Add Product</a>
            </div>
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
                                    <th  class="nowrap">Sr. No.</th>
                                    <th>Name</th>
                                    <th>Price Info.</th>
                                    <th>Business Volume</th>
                                    <th>Business Point</th>
                                    <th class="nowrap">Quantity</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($products)){
                                  $i=1;
                                  foreach($products as $product){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $product->name; ?></td>
                                      <td>
                                        Price : <strong><?php echo number_format($product->price, 2); ?></strong>
                                        <br>Discount : <strong><?php echo number_format($product->discount, 2); ?>%</strong>
                                        <br>Discount Price : <strong><?php echo number_format($product->discount_price, 2); ?></strong>
                                      </td>
                                      <td><?php echo number_format($product->business_volume, 2); ?></td>
                                      <td><?php echo number_format($product->business_point, 2); ?></td>
                                      <td><?php echo number_format($product->quantity, 2); ?></td>

                                      <td><?php echo $product->position; ?></td>
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($product->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                             <li><a href="<?php echo $backend_url; ?>/products/edit/<?php echo $product->id; ?>">Edit</a> 
                                             </li>
                                             <li><a href="<?php echo $backend_url; ?>/products/update_status/<?php echo $product->id; ?>/1">Active</a>
                                             </li>
                                             <li><a href="<?php echo $backend_url; ?>/products/update_status/<?php echo $product->id; ?>/0">Inactive</a>
                                             </li>
                                             <li><a onclick="return confirm('Delete operation will the data permanently from database. Are you sure?');" href="<?php echo $backend_url; ?>/products/delete/<?php echo $product->id; ?>">Delete</a>
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