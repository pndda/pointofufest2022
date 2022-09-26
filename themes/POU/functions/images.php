<?php
/**
 * Add custom image sizes
 */
add_image_size('hero', 1600, 650, array('center', 'center'));
add_image_size('square', 200, 200, array('center', 'center'));
add_image_size('mail', 600, 9999, false); // 600 width, unlimited height

/**
 * Filter the upload size limit for non-administrators.
 * https://developer.wordpress.org/reference/hooks/upload_size_limit/
 *
 * @param string $size Upload size limit (in bytes).
 * @return int (maybe) Filtered size limit.
 */
function filter_site_upload_size_limit( $size ) {
    // Set the upload size limit to 2 MB for users lacking the 'manage_options' capability. (non-admins)
    // Admins can use the default size limit.
    if ( ! current_user_can( 'manage_options' ) ) {
        $size = 1024 * 2000; // 1000 per MB
    }
    return $size;
}
add_filter( 'upload_size_limit', 'filter_site_upload_size_limit', 20 );

/**
 * Resize smaller images
 */
if (!function_exists('thumbnail_upscale')) {
    function thumbnail_upscale($default, $orig_w, $orig_h, $new_w, $new_h, $crop)
    {
        if (!$crop) return null; // let the wordpress default function handle this
        $aspect_ratio = $orig_w / $orig_h;
        $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

        $crop_w = round($new_w / $size_ratio);
        $crop_h = round($new_h / $size_ratio);

        $s_x = floor(($orig_w - $crop_w) / 2);
        $s_y = floor(($orig_h - $crop_h) / 2);

        return array(0, 0, (int)$s_x, (int)$s_y, (int)$new_w, (int)$new_h, (int)$crop_w, (int)$crop_h);
    }
}
add_filter('image_resize_dimensions', 'thumbnail_upscale', 10, 6);

/**
 * Image upload quality check
 */
add_filter('wp_handle_upload_prefilter', 'validate_images');
function validate_images($file)
{
    // Check if upload is image, if so apply validation
    if (preg_match("/\.(gif|png|jpg)$/", $file['name'])) {

        $image = getimagesize($file['tmp_name']);

        $minimum = array(
            'width' => '250',
            'height' => '200'
        );
        $maximum = array(
            'width' => '1920',
            'height' => '2500'
        );

        $image_width = $image[0];
        $image_height = $image[1];

        $too_small = "Image dimensions are too small. Minimum size is {$minimum['width']} by {$minimum['height']} pixels. Uploaded image is $image_width by $image_height pixels.";
        $too_large = "Image dimensions are too large. Maximum size is {$maximum['width']} by {$maximum['height']} pixels. Uploaded image is $image_width by $image_height pixels.";

        if ($image_width < $minimum['width'] || $image_height < $minimum['height']) {
            $file['error'] = $too_small;
            return $file;
        } elseif ($image_width > $maximum['width'] || $image_height > $maximum['height']) {
            $file['error'] = $too_large;
            return $file;
        } else
            return $file;
    } else {
        return $file;
    }
}

/**
 * Allow .svg to be uploaded
 */
function add_file_types_to_uploads($file_types): array
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    return array_merge($file_types, $new_filetypes );
}
add_action('upload_mimes', 'add_file_types_to_uploads');
