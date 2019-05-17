

<select id="studentid" name="studentid" class="form-control selectpicker" class="form-control selectpicker"
                       data-show-subtext="true" data-actions-box="true" data-live-search="true"  >
                        <option value="0">Select</option> 
	
		<?php
				foreach ($studentList as $key => $value) { ?>

				<option value="<?php echo $value->student_id; ?>"><?php echo $value->name."  [Roll-".$value->rollno."]"; ?></option>

					<?php	}
					?>

</select>