#!/usr/bin/php
<?php
#
# Put your screenshots in the INPUT_DIR and name them like:
#     en_US___ios4in___portrait___screen1.png
#         OR
#     en_US___ios4in___screen1.png
#
$user_home_dir = $_SERVER['HOME'];
$screen_shots_dir = "$user_home_dir/Desktop/screenshots";
$itmps_dir = "$user_home_dir/Desktop";

/*
 * STEP 1: INHALE SCREEN SHOTS
 */
file_exists($screen_shots_dir) or die ("Please put your screenshots in $screen_shots_dir");
$screen_shots_by_locale_and_device = array();
foreach (glob("$screen_shots_dir/*.[pP][nN][gG]") as $screen_shot) {
	list($locale, $device, $name) = explode('___', basename($screen_shot));
    $screen_shots_by_locale_and_device[$locale][$device][] = basename($screen_shot);
}

/*
 * STEP 2: INHALE ITUNES CONNECT EXPORT
 */
$itmsps = glob("$itmps_dir/*.itmsp/metadata.xml");
if (count($itmsps) != 1)
	echo "WARNING: Was expecting 1 .itmsp file, found ".count($itmsps).". Continuing without itmsp integration.\n";
else
	$itmsp_parsed = simplexml_load_file($itmsps[0]);

/*
 * STEP 3: ITERATE ON THE SCREEN SHOTS
 */

$tmp_file_output = '';
foreach ($screen_shots_by_locale_and_device as $locale => $screen_shots_by_device) {
	// Save all screen shot XML data
	$xml_to_insert = '<software_screenshots>';
	$xml_for_screenshots .= "\n\n\nSCREEN SHOTS FOR LOCALE: $locale\n\n";
	foreach ($screen_shots_by_device as $device => $screen_shots)
		foreach ($screen_shots as $position => $screen_shot)
			$xml_to_insert .= xmlChunk($device, $position+1, "$screen_shots_dir/$screen_shot", $screen_shot) . "\n";
	$xml_to_insert .= '</software_screenshots>';
	$tmp_file_output .= "\n\n\nSCREEN SHOTS FOR LOCALE: $locale\n\n" . $xml_to_insert;

	if (!isset($itmsp_parsed))
		continue;

	// Find part of itmsp file to shove XML into
	$matched_itmsp_locale = NULL;
    foreach ($itmsp_parsed->software->software_metadata->versions->version->locales->locale as $itmsp_locale) 
        if ($locale == (string)$itmsp_locale->attributes()->name)
            $matched_itmsp_locale = $itmsp_locale;

	// Shove it
	if ($matched_itmsp_locale) {
		echo "Splicing in screenshots for $locale\n";
		unset($matched_itmsp_locale->software_screenshots);
		// https://stackoverflow.com/questions/3418019/simplexml-append-one-tree-to-another
		$dom1 = dom_import_simplexml($matched_itmsp_locale);
		$dom2 = dom_import_simplexml(simplexml_load_string($xml_to_insert));
		$dom2 = $dom1->ownerDocument->importNode($dom2, TRUE);
		$dom1->appendChild($dom2);
	} else
		echo "Screenshots found for locale $locale but no matching metadata found in .itmsp, skipping\n";
}

file_put_contents("$screen_shots_dir/xml_chunks_DEBUG.txt", $tmp_file_output);
echo "Saved XML chunks of ".count($screen_shots_by_locale_and_device, COUNT_RECURSIVE)." screen shots to $screen_shots_dir/xml_chunks_DEBUG.txt\n";

if (isset($itmsp_parsed)) {
    $itmsp_parsed->asXML("$screen_shots_dir/metadata.xml");
    echo "Saved updated metadata.xml file to $screen_shots_dir/metadata.xml\n";
}

function xmlChunk($display_target, $position, $file_path, $file_name)
{
    $file_size = filesize($file_path);
    $md5 = md5_file($file_path);

    return <<<END
                                <software_screenshot display_target="$display_target" position="$position">
                                    <size>$file_size</size>
                                    <file_name>$file_name</file_name>
                                    <checksum type="md5">$md5</checksum>
                                </software_screenshot>
END;
}


function translateDevice($device)
{
    if ($device == 'iphone4') {
        return 'iOS-3.5-in';
    } elseif ($device == 'iphone5') {
        return 'iOS-4-in';
    } elseif ($device == 'ipad') {
        return 'iOS-iPad';
    } else {
        print "\n\n\n******\n\nWTF $device\n\n\n";
    }
}
