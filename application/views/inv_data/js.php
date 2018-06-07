
<!-- Show hide add new data box widget -->
<script type="text/javascript">
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
<!-- / Show hide add new data box widget -->

<!-- Jquery Validate -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
<!-- / Jquery Validate -->

<!-- Jquery-steps -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script> -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-steps/jquery.steps.css'); ?>">
	<style media="screen">
		.wizard .content {
			min-height: 100px;
		}
		.wizard .content > .body {
			width: 100%;
			height: auto;
			padding: 15px;
			position: absolute;
		}
		.wizard .content .body.current {
			position: relative;
		}
	</style>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-steps/jquery.steps.min.js'); ?>"></script>
	<script type="text/javascript">
		var form = $("#input_form");
		form.steps({
	    headerTag: "h3",
	    bodyTag: "fieldset",
	    transitionEffect: "slideLeft",
	    onStepChanging: function (event, currentIndex, newIndex)
	    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
	    },
	    onFinishing: function (event, currentIndex)
	    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
	    },
	    onFinished: function (event, currentIndex)
	    {
        form.submit();
	    }
		});
	</script>
<!-- / Jquery-steps -->

<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/iCheck/square/square.css'); ?>">
	<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/iCheck/icheck.min.js'); ?>"></script>
	<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck-1x/skins/square/square.css'); ?>"> -->
	<!-- <script type="text/javascript" src="<?php echo base_url('assets/plugins/icheck-1x/icheck.min.js'); ?>"></script> -->
	<script>
		$(document).ready(function(){
		  $('input').iCheck({
		    checkboxClass: 'icheckbox_square',
		    radioClass: 'iradio_square',
		    increaseArea: '20%' // optional
		  });
		});
	</script>
<!-- / iCheck -->

<!-- Color if color_switch selected -->
	<script type="text/javascript">
		var color_switch = $('#color_switch');
		var color        = $('#color_container');
		var new_color    = $('#new_color');

		color_switch.on('ifChecked', function(event){
			color.hide();
			color.val("");
			new_color.show();
			new_color.prop('required', 'required');
			new_color.addClass('required');
		});

		color_switch.on('ifUnchecked', function(event){
			new_color.hide();
			new_color.val("");
			color.show();
			color.prop('required', 'required');
			color.addClass('required');
		});

	</script>
<!-- / Color if color_switch selected -->

<!-- Autocomplete -->
	<style media="screen">
		.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
		.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
		.autocomplete-selected { background: #F0F0F0; }
		.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
	</style>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/jQuery-Autocomplete/dist/jquery.autocomplete.min.js'); ?>"></script>
	<script type="text/javascript">
		// Lookup value
		var list_of_brand = [<?php
		// Loop only when brand_list exists
		if (isset($brand_list)) {
			$total = count($brand_list->result());
			$no    = 0;
			foreach ($brand_list->result() as $bdl) {
				$no++;
				echo "'".$bdl->brand."'";
				if ($no<$total) {
					echo ", ";
				}
			}
		}
		?> ];

		// Autocomplete
		$("#brand").autocomplete({
	    lookup: list_of_brand
		});
	</script>
<!-- / Autocomplete -->

<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/select2/select2.min.css'); ?>">
	<style media="screen">
		.select2-container .select2-selection--single{
			height: auto;
		}
	</style>
	<script type="text/javascript" src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/select2/select2.full.min.js'); ?>"></script>
	<script type="text/javascript">
		$(".select2").select2();
	</script>
<!-- / Select2 -->

<!-- Fancybox  -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fancybox/dist/jquery.fancybox.min.css'); ?>">
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/fancybox/dist/jquery.fancybox.min.js'); ?>"></script>
<!-- / Fancybox -->

<!-- Chartjs -->
	<script type="text/javascript" src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/chartjs/Chart.bundle.min.js'); ?>"></script>
	<?php if (isset($summary)) {
		if (count($summary->result()) > 0) { ?>
		<script type="text/javascript">
			new Chart(document.getElementById("chart"), {
				type: 'horizontalBar',
				data: {
					labels: [
						<?php $x = 0;
						foreach ($summary->result() as $chartdata) {
							$x++;
							echo "'".$chartdata->name."'";
							if ($x < count($summary->result())) {
								echo ",";
							}
						} ?>
					],
		      datasets: [{
		        label: "Total Data ",
		        data: [
							<?php $x = 0;
							foreach ($summary->result() as $chartdata) {
								$x++;
								echo $chartdata->total;
								if ($x < count($summary->result())) {
									echo ",";
								}
							} ?>
						],
						backgroundColor: 'rgba(60, 141, 188,0.5)',
		        fill: false,
		        borderWidth: 1
		      }]
				},
				options: {
					title: {
	            display: true,
	            text: 'Total Inventory Per Category'
	        },
					legend : {
						display:false
					},
		      scales: {
		        xAxes: [{
		          ticks: {
		            beginAtZero: true,
								userCallback: function(label, index, labels) {
	                 // when the floored value is the same as the value we have a whole number
	                 if (Math.floor(label) === label) {
	                   return label;
	                 }
	               },
		          }
		        }]
		      },
		    }
			});
		</script>
	<?php }
	} ?>

<!-- / Chartjs -->
