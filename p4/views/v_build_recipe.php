
<!--
palette has the images that pass as icons for possible steps in a recipe, there are 
probably not nearly enough but this is just to get the idea. The block include the 
form which will only become apparent whey the item is selected and transferred
to the content column
most of the forms are identical - not sure how to do this DRY - add buttons later 
from above
 -->
<div id='recipe-palette'>
	<h4>Step types</h4>
	<div id='step-type-list'></div>
</div>
<!--
content starts with three blocks - one for the header, one for the footer which is 
like the last step but it isn't really useful any more now that the drag and 
drop is gone and one for the message for any error messages.
 -->
<div id='recipe-content'>
	<div id='recipe-header'>
		<h4>Recipe</h4>
		<form method='POST'>
		  Name<br>
		  <input id='recipe-name' type='text' name='Recipe name' value='<?=$name?>'><br>
			Description<br>
		  <textarea id='recipe-description' name='description' value='<?=$description?>'></textarea><br>
		</form>
	</div>
	<div id='recipe-step-list'>
		<div id='recipe-footer' class='recipe-step droppable'>
			<p>click on a step icon on left</p>
		  <input id='save-recipe' type='button' value='Save'>
		</div>
	</div>
	<div id='message-block'></div>

	<p class='clear'></p>
</div>
