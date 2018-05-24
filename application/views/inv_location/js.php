
<!-- Show hide add new data box widget -->
<script>
	$('#myboxwidget').on('click', function(event) {
		event.preventDefault();
		var add_new = $('#add_new');
		if (add_new.hasClass('hide')) {
			add_new.prop('class', 'box-body show');
		}
		else if (add_new.hasClass('show')) {
			add_new.prop('class', 'box-body hide');
		};
	});;
</script>

<!-- Fancybox  -->
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fancybox/dist/jquery.fancybox.min.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/plugins/fancybox/dist/jquery.fancybox.min.js'); ?>"></script>
