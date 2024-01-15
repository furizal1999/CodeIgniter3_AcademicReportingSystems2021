			<footer class="footer bg-dark text-white">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul class="nav">
							<li class="nav-item">
								<a class="nav-link" href="http://eng.uir.ac.id/" target="_BLANK">
									Fakultas Teknik Universitas Islam Riau
								</a>
							</li>
							
						</ul>
					</nav>
					<div class="copyright ml-auto">
						Copyright © 2021 <span>Fakultas Teknik</span>. All rights reserved.
					</div>				
				</div>
			</footer>
		</div>

	<script src="<?php echo base_url('templates/');?>assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="<?php echo base_url('templates/');?>assets/js/core/popper.min.js"></script>
	<script src="<?php echo base_url('templates/');?>assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Chart JS -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/chart.js/chart.min.js"></script>
	<script src="<?php echo base_url('templates/');?>Chart.js//Chart.bundle.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<!-- <script src="<?php echo base_url('templates/');?>assets/js/plugin/chart-circle/circles.min.js"></script> -->

	<!-- Datatables -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/datatables/datatables.min.js"></script>

	<!-- Bootstrap Notify -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

	<!-- Sweet Alert -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="<?php echo base_url('templates/');?>assets/js/atlantis.min.js"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="<?php echo base_url('templates/');?>assets/js/setting-demo.js"></script>
	<script src="<?php echo base_url('templates/');?>assets/js/demo.js"></script>
	<script>
		Circles.create({
			id:'circles-1',
			radius:45,
			value:60,
			maxValue:100,
			width:7,
			text: 5,
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-2',
			radius:45,
			value:70,
			maxValue:100,
			width:7,
			text: 36,
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value:40,
			maxValue:100,
			width:7,
			text: 12,
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

		var mytotalIncomeChart = new Chart(totalIncomeChart, {
			type: 'bar',
			data: {
				labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
				datasets : [{
					label: "Total Income",
					backgroundColor: '#ff9e27',
					borderColor: 'rgb(23, 125, 255)',
					data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				scales: {
					yAxes: [{
						ticks: {
							display: false //this will remove only the label
						},
						gridLines : {
							drawBorder: false,
							display : false
						}
					}],
					xAxes : [ {
						gridLines : {
							drawBorder: false,
							display : false
						}
					}]
				},
			}
		});

		$('#lineChart').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});
	</script>

	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->

	<script>
      function myLoginFunction() {
            if(document.getElementById('login-form').style.display != 'none'){
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('daftar-form').style.display = 'none';
                // document.getElementById('logo').style.display = 'inline';
            }
            else{
                document.getElementById('login-form').style.display = 'inline';
                document.getElementById('daftar-form').style.display = 'none';
                document.getElementById('logo').style.display = 'none';
            }
      }

      function myDaftarFunction() {
            if(document.getElementById('daftar-form').style.display != 'none'){
                document.getElementById('daftar-form').style.display = 'none';
                document.getElementById('login-form').style.display = 'none';
                // document.getElementById('logo').style.display = 'inline';
            }
            else{
                document.getElementById('daftar-form').style.display = 'inline';
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('logo').style.display = 'none';
            }
      }
  </script>

	<!-- DATA TABLES -->
	<script type="text/javascript" src="<?php echo base_url() ?>templates/plugins/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>templates/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>templates/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>templates/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
      $(function () {
        $('#mydata').DataTable({

          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true
          // "columnDefs":[
          //                 { responsivePriority: 1, targets:0}
          //                 // { responsivePriority: 2, targets:2}
          // ]
        });
	  });
	  
	  $(function () {
        $('#mydata2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true
          // "columnDefs":[
          //                 { responsivePriority: 1, targets:0}
          //                 // { responsivePriority: 2, targets:2}
          // ]
        });
      });

       $(function () {
        $('#mydatascroll').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          // "responsive": true,
          "scrollX": true
          
        });
      });
    </script>
	

</body>
</html>

<!-- $(document).ready(function() {
    $('#example').DataTable( {
        "scrollX": true
    } );
} ); -->