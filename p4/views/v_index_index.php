<div id='main'>

	<div id='main-header'>
		<h1>Active Cookbook</h1>
		<h2>DWA Project 4</h2>
		<h3>
			<p>

			</p>
		</h3>
	</div>
	
	<div id='main-body'>
		<div id='left-sidebar' class='main-subview'>
			<?=$lsb?>
		</div>
		<div id='main-display' class='main-subview'>
			<div id='recipe-display-list'></div>
			<div id='recipe-builder' class='hide'></div>
		<!--
			This is the execution block. it has a sample execution item which the script will use
			as a basis for its blocks. the program will display	all steps with no dependencies. 
			When the user clicks on done the block disappears and all steps that were dependent 
			on should appear. Ideally this would be in some order but that was not done
		  -->
			<div id='recipe-execution' class='hide'></div>
			<div id='user-profile' class='hide'></div>
		</div>
		<div id='right-sidebar' class='main-subview'>
			<?=$rsb?>
		</div>
	</div>
	<div id='main-footer'></div>
</div>