<select id="sel_month" name="sel_month[]" class="form-control selectpicker changmonth"  data-show-subtext="true" data-actions-box="true" data-live-search="true" multiple="multiple">
<?php 
                          if($monthList)
                          {
                            $months=explode(',',$PaidMonthList);
                            for ($i=0; $i <sizeof($monthList) ; $i++)
                          { ?>
                            <option value="<?php echo $monthList[$i]->id; ?>" <?php for ($j=0; $j <sizeof($months) ; $j++) { 
                              if($monthList[$i]->id==$months[$j]){ echo "disabled"; }
                            } ?>><?php echo $monthList[$i]->month_code; ?></option>
                      <?php   }
                          }
                          ?>

</select>
<input type="hidden" name="selected_month_ids" id="selected_month_ids" value="<?php echo $PaidMonthList; ?>">
<!-- 
 -->
<script>
$(document).ready(function(){
  var  selected_roles = $("#selected_month_ids").val();
  var selected_attr = selected_roles.split(',');
  $("#sel_month").selectpicker("val", selected_attr);
  // $("#sel_month").selectpicker('disable',selected_attr);
});
</script>