<?php
//echo '<pre>';
//print_r($attachment);exit;
if($file_size == 2){
	if($file_format == 1){
		if(!empty($attachment)){
			$ex_file = explode(".", $attachment->file);
			if(strtolower($ex_file[1]) == 'pdf'){
				$attachment_file = 'frontend/img/pdf-default.png';
				$cls = "";
				$link = $home_url.'attachments/'.$attachment->file;
			}
			elseif(strtolower($ex_file[1]) == 'doc'){
				$attachment_file = 'frontend/img/msdoc-default.gif';
				$cls = "";
				$link = $home_url.'/attachments/'.$attachment->file;
			}
			elseif(strtolower($ex_file[1]) == 'mp4'){
				$attachment_file = 'frontend/img/video-default.png';
				$cls = "fancybox fancybox.ajax";
				$link = $home_url.'/ajax/show_attachments/'.$attachment->id;
			}else{
				$attachment_file = 'attachments/'.$attachment->file;
				$cls = "fancybox fancybox.ajax";
				$link = $home_url.'/ajax/show_attachments/'.$attachment->id;
			}
		?>
			<div class="attchment-container">
			  	<div class="col-xs-12 attchment-inner-container">
			  		<div class="col-xs-12 nopadding">
						<span class="remove-attachment-container" onclick="return removeAttachment(this, '<?php echo $attachment->id; ?>');" title="Remove"><i class="fa fa-times"></i></span>
						<a href="<?php echo $link; ?>" class="<?php echo $cls; ?>" target="_blank"><img src="<?php echo $home_url; ?>/<?php echo $attachment_file; ?>" alt="<?php echo $attachment->caption; ?>" /></a>
						<?php echo $this->Form->input('Attachment.id_proof.', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $attachment->id)); ?>
					</div>
			  	</div>
			  	<div class="col-xs-12 padding-left-10 padding-right-10 margin-top-12">
					<?php echo $this->Form->input('Attachment.id_proof_caption.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Caption')); ?>
				</div>
			</div>
		<?php
		}
	}else{
		echo $file_format;
	}
}else{
	echo $file_size;
}

?>