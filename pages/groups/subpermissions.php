<?php
/**
 * Manage group subpermissions.
 *
 * @package ElggGroups
 */

gatekeeper();

$guid = (int) get_input("group_guid");

elgg_set_page_owner_guid($guid);

$group = get_entity($guid);

$title = elgg_echo("groups:subpermissions");

if (!empty($group) && elgg_instanceof($group, "group") && $group->canEdit()) {
	// change page title	
	elgg_push_breadcrumb(elgg_echo("groups"), "groups/all");
	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb($title);

	$acls = unserialize($group->subpermissions);
	/*
	$access_collection = create_access_collection("Onderzoek PP: Test Collection", 5866);
	var_dump($access_collection);
	$group->subpermissions = serialize(array($access_collection));
	$group->save();*/

	//var_dump(get_write_access_array());
	//exit();
	
	foreach($acls as $aclid) {
		$acl = get_access_collection($aclid);
		$members = get_members_of_access_collection($aclid);

		$content .= "<h2>" . $acl->name . "</h2>";

		$content .= "<ul>";
		foreach ($members as $member) {
			$content .= "<li>" . $member->name . "</li>";
		}
		$content .= "</ul>";
	}

	//add_user_to_access_collection(279, $aclid);	
	//remove_user_from_access_collection(279, $aclid);

} else {
	$content = elgg_echo("groups:noaccess");
}

$params = array(
	"content" => $content,
	"title" => $title,
	"filter" => "",
);
$body = elgg_view_layout("content", $params);

echo elgg_view_page($title, $body);