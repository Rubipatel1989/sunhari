<?php echo $this->Form->create(NULL, array('id' => 'site_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bulk Plot Upload</h4>
                </div>
                <hr/>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-3">
                            <label>Select Property</label>
                            <select id="property" name="property" class="form-control">
                                <option value="0">Select Property</option>                                
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Site Name </label>
                            <select id="site" name="site" class="form-control">
                                <option value="0">Select Site</option>                                
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Select File</label>
                            <input type="file" class="form-control" id="plot_file" name="plot_file">
                        </div>                       
                    </div>                    

                </div>
                <div class="modal-footer">                   
                    <input type="submit" name="submit" id="submit" class="btn btn-success" value="Upload" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        <?php echo $this->Form->end();?>