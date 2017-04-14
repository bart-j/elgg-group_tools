<?php
$subpermission_id = elgg_extract("subpermission_id", $vars);
$group = elgg_get_page_owner_entity();
$access_collection = get_access_collection($subpermission_id);
$members = group_tools_get_members_of_access_collection($subpermission_id);

?>

<div class="elgg-module elgg-module-info">
	<div class="elgg-head">
		<?php
			// email dialog
			$data_members = array();
			foreach ($members as $member) { $data_members[] = $member->guid; }

			if (elgg_is_xhr()) {
				echo elgg_view('output/url', array(
					"text" => elgg_echo("group_tools:subpermissions:select"),
					"data-members" => implode(',', $data_members),
					"class" => "elgg-button-action group-tools-button-right group-tools-subpermissions-email-select"
				));
			} else {
				if ($group->canEdit()) {
					echo elgg_view('output/confirmlink', array(
						"text" => elgg_echo("delete"),
						"href" => "action/group_tools/subpermissions/delete?access_guid=" . $subpermission_id . "&group_guid=" . $group->guid,
						"class" => "elgg-button-action group-tools-button-right",
						"confirm" => elgg_echo("group_tools:subpermissions:delete:confirm")
					));

					echo elgg_view('output/url', array(
						"text" => elgg_echo("edit"),
						"href" => "groups/subpermissions_edit/{$group->guid}/{$subpermission_id}",
						"class" => "elgg-button-action group-tools-button-right group-tools-subpermissions-edit"
					));

					echo elgg_view('output/url', array(
						"text" => elgg_echo("group_tools:subpermissions:manage_members"),
						"href" => "groups/subpermissions_manage_members/" . $group->guid . "?access_guid=" . $subpermission_id,
						"class" => "elgg-button-action group-tools-button-right group-tools-subpermissions-manage-members"
					));
				}
			}
		?>
		<h3>
			<?php echo $access_collection->name; ?>
		</h3>
	</div>
	<?php if (!elgg_is_xhr()): ?>
		<div class="elgg-body" id="custom_fields_profile_types_list_custom">
			<?php
				echo elgg_view('group_tools/subpermissions/view', array(
					'group_guid' => $group->guid,
					'access_guid' => $subpermission_id,
					'members' => $members
				));
			?>
		</div>
	<?php endif ?>
</div>
