<table cellpadding="0" cellspacing="0" border="0" class="variations">
	<tr>
		<th class="firt">
			<?php echo __("Type"); ?>
		</th>
		<th style="border-left: 1px solid #444">
			<?php echo __("aujourd'hui"); ?>
		</th>
		<th>
			<?php echo format_date(strtotime("-1 month"), "P"); ?>
		</th>
		<th>
			<?php echo format_date(strtotime("-2 month"), "P"); ?>
		</th>
		<th style="border-left: 1px solid #000">
			<?php echo __("Variation 30j"); ?>
		</th>
		<th>
			<?php echo __("Variation 60j"); ?>
		</th>
	</tr>
	<?php foreach($data as $key => $d): ?>
	<tr>
		<td class="firt">
			<?php echo $d[0]; ?>
		</td>
		<td style="border-left: 1px solid #444">
			<?php echo $d[2]; ?>
		</td>
		<td>
			<?php echo $d[3]; ?>
		</td>
		<td>
			<?php echo $d[4]; ?>
		</td>
		<td style="border-left: 1px solid #000">
			+ <?php echo ($d[2] - $d[3]); ?>
		</td>
		<td>
			+ <?php echo ($d[2] - $d[4]); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>