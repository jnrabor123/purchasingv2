<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//required
require_once '../../config/setup.php';
//end required

require_once APPPATH . 'view/template/header.php';
?>

<style>
	


</style>

<div id="content-wrapper">

	<div class="container-fluid">

		<center>
			<video style="border-radius: 20px; height: 500px; width: 60%; margin-top: 100px;" controls>
			   <source src="Happiness is helping others.mp4" type="video/mp4">
			 	Your browser does not support the video tag.
			</video> 
			<br/>
			<h5>"HAPPINESS IS HELPING OTHERS"</h5>
		</center>

	</div>

	<?php
	require_once APPPATH . 'view/template/footer.php';
	?>

	<script src="<?php echo base_url; ?>assets/scripts/login/login.js"></script>

</body>


</html>









