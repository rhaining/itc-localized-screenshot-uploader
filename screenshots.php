#!/usr/bin/php
<?php

$user_home_dir = $_SERVER['HOME'];
$input_dir = "$user_home_dir/Desktop/screenshots";
$output_dir = "$user_home_dir/Desktop/screenshots_for_upload";

if (!file_exists($input_dir)) {
    print "Please put your screenshots in $input_dir\n";
    exit();
}

if (!file_exists($output_dir)) {
    mkdir($output_dir);
}

$root_dh  = opendir($input_dir);
while (false !== ($lang_dir = readdir($root_dh))) {
    if (isRealFileOrDir($lang_dir)) {
        $lang_dir_path = "$input_dir/$lang_dir";
        $lang_dh = opendir($lang_dir_path);
        print "$lang_dir\n\n";
        while (false !== ($device_dir = readdir($lang_dh))) {
            if (isRealFileOrDir($device_dir)) {
                $device_path = "$lang_dir_path/$device_dir";
                $device_dh = opendir($device_path);
                $position = 1;
                while (false !== ($image_name = readdir($device_dh))) {
                    if (isRealFileOrDir($image_name)) {
                        $full_image_path = "$device_path/$image_name";
                        // print "$full_image_path\n";
                        $display_target = translateDevice($device_dir);
                        $new_image_name = $lang_dir . "_" . $display_target . "_" . $image_name;
                        $output_path = "$output_dir/$new_image_name";
                        // print $output_path . "\n";
                        copy($full_image_path, $output_path);
                        print xmlChunk($display_target, $position, $output_path, $new_image_name);
                        print "\n";
                        $position++;
                    }
                }
                closedir($device_dh);
            }
        }
        closedir($lang_dh);
        print "\n\n\n\n";
    }
}
closedir($root_dh);

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

function isRealFileOrDir($test)
{
    $firstletter = substr($test, 0, 1);

    return $firstletter != '.';
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
