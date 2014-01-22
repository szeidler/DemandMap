<?php blocks::open("reports");?>
<?php blocks::title(Kohana::lang('ui_main.recent_reports'));?>
<?php
$pageController = new Page_Controller();
print $pageController->index(1);
?>
<table class="table-list">
	<thead>
		<tr>
			<th scope="col" class="title"><?php echo Kohana::lang('ui_main.title'); ?></th>
			<th scope="col" class="location"><?php echo Kohana::lang('ui_main.location'); ?></th>
			<th scope="col" class="date"><?php echo Kohana::lang('ui_main.date'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($incidents->count() == 0)
		{
			?>
			<tr><td colspan="3"><?php echo Kohana::lang('ui_main.no_reports'); ?></td></tr>
			<?php
		}
    $i = 0;
		foreach ($incidents as $incident)
		{
      $i++;
			$incident_id = $incident->id;
			$incident_title = text::limit_chars(html::strip_tags($incident->incident_title), 40, '...', True);
			$incident_date = $incident->incident_date;
			$incident_date = date('M j Y', strtotime($incident->incident_date));
			$incident_location = $incident->location->location_name;
      if ($i % 2) {
        $rowClass = 'odd';
      } else {
        $rowClass = 'even';
      }
		?>
		<tr class="<?php print $rowClass; ?>">
			<td><a href="<?php echo url::site() . 'reports/view/' . $incident_id; ?>"> <?php echo $incident_title ?></a></td>
			<td><?php echo html::escape($incident_location) ?></td>
			<td><?php echo $incident_date; ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<a class="more" href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
<div style="clear:both;"></div>

<?php blocks::close();?>