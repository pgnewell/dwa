<div id='main'>

	<div id='main-header'>
		<h1>A Cute Title</h1>
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
			<div id='recipe-execution' class='hide'>
				<div id="execute-header">
					<input type='button' id='exec-clear' value='Clear' onClick='window.location.reload()'>
				</div>
				<div id='recipe-execution-list' class='hide'>
	
					<div id='sample-execute-block' class='hide'>
						<div class='execute-instruction'>instructions go here</div>
						<div class='execute-done'>
							<input type='button' class='execute-done-button' value='Complete'>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div id='right-sidebar' class='main-subview'>
			<?=$rsb?>
		</div>
	</div>
	
</div>