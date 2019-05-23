<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?php echo $template['title']?></title>
<meta name="keywords" content="Backstage Interface" />
<meta name="description" content="Backstage Interface" />
<?php
foreach ($template['css'] as $val) {
	echo "<link rel='stylesheet' type='text/css' href='{$val}'/>";
}
?>
</head>
<body>
	<div id="top">
		<div class="logo">
			Control Center
		</div>

		<div class="login_info">
			<a href="#" style="color:#fff;">Homepage</a>&nbsp;|&nbsp;
			Administrator: Jenny <a href="#">[Sign out]</a>
		</div>
	</div>

		<div id="sidebar">
		<ul>
			<li>
				<div class="small_title">System</div>
				<ul class="child">
					<li><a class="current" href="#">System Info</a></li>
					<li><a href="#">Administrator</a></li>
					<li><a href="#">Add Administrator</a></li>
					<li><a href="#">Site Settings</a></li>
				</ul>
			</li>
			<li><!--  class="current" -->
				<div class="small_title">Content</div>
				<ul class="child">
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='parent_module.php') {echo 'class="current"';}?> href="parent_module.php">Parent Site Lists</a></li>
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='parent_module_add.php') {echo 'class="current"';}?> href="parent_module_add.php">Add Parent Site</a></li>
					<?php 
						if(basename($_SERVER['SCRIPT_NAME'])=='parent_module_update.php'){
							echo '<li><a class="current">Modify Parent Site</a></li>';
						}
					?>
					
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='child_module.php') {echo 'class="current"';}?> href="child_module.php">Child Site Lists</a></li>
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='child_module_add.php') {echo 'class="current"';}?> href="child_module_add.php">Add Child Site</a></li>
					<?php 
						if(basename($_SERVER['SCRIPT_NAME'])=='child_module_update.php'){
							echo '<li><a class="current">Modify Child Site</a></li>';
						}
					?>
					<li><a href="#">Management</a></li>
				</ul>
			</li>
			<li>
				<div class="small_title">User</div>
				<ul class="child">
					<li><a href="#">User List</a></li>
				</ul>
			</li>
		</ul>
	</div>