

<select id="district" name="district" class="form-control selectpicker" class="form-control selectpicker"
                       data-show-subtext="true" data-actions-box="true" data-live-search="true"  >
                        <option value="0">Select</option> 
	
		<?php
				foreach ($districtList as $key => $value) { ?>

				<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>

					<?php	}
					?>

</select>