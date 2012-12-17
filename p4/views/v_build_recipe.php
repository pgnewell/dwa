<!-- 
	Recipe block splits into two columns one for the recipe being built 
	and one for the pallet, the list of types of steps you can add
  -->
<div id="recipe-block">
<!--
	palette has the images that pass as icons for possible steps in a recipe, there are 
	probably not nearly enough but this is just to get the idea. The block include the 
	form which will only become apparent whey the item is selected and transferred
	to the content column
	most of the forms are identical - not sure how to do this DRY - add buttons later 
	from above
  -->
	<div id="recipe-palette">
		<h4>Step types</h4>
		<div class="icon-block icon-click">
			<img src="./images/mipl.jpg" alt="ingredients" title="Ingredients"/>
			<div class='caption'>Ingredients</div>
			<div class='step-instructions hide'>
				<br><label>enter ingredient list here</label>
				<textarea class="recipe-textarea" onfocus="this.value='';">
				</textarea><br>
			</div>
			<div class='step-actions hide'></div>
		</div>
		<div class="icon-block icon-click">
			<img src="./images/stir.jpg" alt="stir" title="Stir"/>
			<div class='caption'>stir</div>
			<div class='step-instructions hide'>
				<br><label>enter instructions here</label>
				<textarea class="recipe-textarea" onfocus="this.value='';">
				</textarea><br>
			</div>
			<div class='step-actions hide'></div>
		</div>
		<div class="icon-block icon-click">
			<img src="./images/fold.jpg" alt="fold" title="Fold"/>
			<div class='caption'>fold</div>
			<div class='step-instructions hide'>
				<br><label>enter instructions here</label>
				<textarea class="recipe-textarea" onfocus="this.value='';">
				</textarea><br>
			</div>
			<div class='step-actions hide'></div>
		</div>
		<div class="icon-block icon-click">
			<img src="./images/bake.jpg" alt="bake" title="Bake"/>
			<div class='caption'>bake</div>
			<div class='step-instructions hide'>
				<br><label>enter instructions here</label>
				<textarea class="recipe-textarea" onfocus="this.value='';">
				</textarea><br>
			</div>
			<div class='step-actions hide'></div>
		</div>
		<div class="icon-block icon-click">
			<img src="./images/roll.jpg" alt="roll" title="Roll"/>
			<div class='caption'>roll</div>
			<div class='step-instructions hide'>
				<br><label>enter instructions here</label>
				<textarea class="recipe-textarea" onfocus="this.value='';">
				</textarea><br>
			</div>
			<div class='step-actions hide'></div>
		</div>
		<div class="icon-block icon-click">
			<img src="./images/chop.jpg" alt="chop" title="Chop"/>
			<div class='caption'>chop</div>
			<div class='step-instructions hide'>
				<br><label>enter instructions here</label>
				<textarea class="recipe-textarea" onfocus="this.value='';">
				</textarea><br>
			</div>
			<div class='step-actions hide'></div>
		</div>
		<div class="icon-block icon-click">
			<img src="./images/chill.png" alt="chill" title="chill"/>
			<div class='caption'>chill</div>
			<div class='step-instructions hide'>
				<br><label>enter instructions here</label>
				<textarea class="recipe-textarea" onfocus="this.value='';">
				</textarea><br>
			</div>
			<div class='step-actions hide'></div>
		</div>
	</div>
<!--
	content starts with three blocks - one for the header, one for the footer which is 
	like the last step but it isn't really useful any more now that the drag and 
	drop is gone and one for the message for any error messages.
  -->
	<div id="recipe-content">
		<div id="recipe-header">
			<h4>Recipe</h4>
		</div>
		<div id="recipe-step-list">
			<div id='recipe-footer' class="recipe-step droppable">
				<p>click on a step icon on left</p>
				<div class='execute-button'>
					<input type='button' id='execute-recipe' value='Execute'>
				</div>
			</div>
		</div>
		<div id="message-block" class="hide"></div>
		<div id="icon-buttons" class="hide">
			<input type='button' class='done-button' value='Done'>
			<input type='button' class='can-button' value='Cancel'>
		<div id="after-buttons" class="hide">
			<input type='button' class='del-button' value='Delete'>
			<input type='button' class='depends-button' value='Depends'>
		</div>
		<div id="exec-done-button" class="hide">
			<input type='button' class='exec-done-button' value='Done'>
		</div>

		</div>
		<p class='clear'></p>
	</div>
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

	
<p class='clear'></p>