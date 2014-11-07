<form id="form-filter">
	<div class="name">Source:</div>
	<select name="source">
		<option value="">None</option>
		<option value="php">PHP</option>
		<option value="xml">XML</option>
		<option value="json">JSON</option>
	</select>
	<div class="clear"></div>
	<div class="name">Group:</div>
	<select name="group">
		<option value="">All</option>
		<option value="world">World</option>
		<option value="europe">Europe</option>
	</select>
	<div class="clear"></div>
	<div class="name">Filtering By:</div><br/>
	<div class="name">Field:</div>
	<select name="filter_field">
		<option value="">None</option>
		<option value="value">Price</option>
		<option value="code">Code</option>
		<option value="name">Name</option>
	</select>
	<div class="clear"></div>
	<div class="name">Type:</div>
	<select name="filter_type">
		<option value="">None</option>
		<option value=">">></option>
		<option value="<"><</option>
		<option value="ilike">ilike</option>
	</select>
	<div class="clear"></div>
	<div class="name">Value:</div>
	<input name="filter_value" />
	<div class="clear"></div>
	<div class="name">Sort By:</div>
	<select name="sort">
		<option value="">Unsorted</option>
		<option value="value">Price</option>
		<option value="code">Code</option>
		<option value="name">Name</option>
	</select>
	<div class="clear"></div>
	<div class="name">Sort Order:</div>
	<select name="order">
		<option value="asc">ASC</option>
		<option value="desc">DESC</option>
	</select>
	<div class="clear"></div>
	<button type="button">Submit</button>
</form>
