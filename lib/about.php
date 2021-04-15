<div class="wrap" style="max-width: 700px;">

    <h1>How to use testimonials</h1>
    <p>Testimonials can be displayed anywhere on your website by using shortcodes.</p>
    <p>You can either display a single testimonial, a group of testimonials, or all of your testimonials at once.</p>
    <p><strong>Note:</strong> shortcodes must be used in the content editor of pages and posts.</p>

    <br><hr><br>

    <h3>Testimonials display style</h3>
    <p>When more than one testimonial ID is provided to the shortcode, or more than one testimonials is found by the query if no IDs are supplied, the shortcode automatically displays testimonials in a slider on the front-end (provided you are using an Organik theme).</p>
    <p>If you would like to display the FAQs like normal page content, you can set the 'style' parameter to 'list'.</p>
    <code style="display: block; font-family: monospace; margin: 0 0 1em 0; font-size: 16px; background-color: #fff; padding: 10px; border-radius: 4px;">[<?php echo ORGNK_TESTIMONIALS_SHORTCODE_NAME ?> style="list"]</code></p>
    <p><strong>Note:</strong> The 'style' parameter is only applied to each instance of a testimonial shortcode.</p>

    <br><hr><br>

    <h3>Limits based on 'style' parameter</h3>
    <p>Whenever the slider style is used, in order to ensure that the slider displays normally and is functional on smaller devices, <strong>the number of testimonials that can be displayed in a single shortcode is limited to eight</strong>.</p>
    <p>This limit includes the first eight testimonial IDs provided to the shortcode, or the first eight found by the query if no IDs are supplied. To display more testimonials sliders, use another instance of the shortcode using different IDs.</p>

    <br><hr><br>

    <h3>Displaying a single testimonial</h3>
    <p>To display a single testimonial on a page or post, simply include a shortcode similar to the example below, using the ID of the testimonial you wish to display.</p>
    <p>You can find a shortcode for each testimonial on the <a href="/wp-admin/edit.php?post_type=<?php echo ORGNK_TESTIMONIALS_CPT_NAME ?>">all testimonials</a> page, which you can copy and paste. Every time you create a new testimonial, a shortcode is automatically generated.</p>
    <code style="display: block; font-family: monospace; margin: 0 0 1em 0; font-size: 16px; background-color: #fff; padding: 10px; border-radius: 4px;">[<?php echo ORGNK_TESTIMONIALS_SHORTCODE_NAME ?> id="46"]</code></p>
    <p>Displaying a single testimonial like this will default the display style to 'list'.</p>
    <p><strong>Note:</strong> Check the ID you are using in the shortcode carefully. If the ID is invalid, it will be ignored, which will prevent your testimonial from displaying on the front-end.</p>

    <br><hr><br>

    <h3>Displaying a group of testimonials</h3>
    <p>If you would like to display a group of testimonials on a page or post, you can use a shortcode similar to the example above, but include a comma-seperated list of IDs instead, like the example below.</p>
    <code style="display: block; font-family: monospace; margin: 0 0 1em 0; font-size: 16px; background-color: #fff; padding: 10px; border-radius: 4px;">[<?php echo ORGNK_TESTIMONIALS_SHORTCODE_NAME ?> id="1,2,3"]</code></p>
    <p>If you provide more than one ID to the shortcode, the testimonials will automatically display in a slider on the front-end (provided you are using an Organik theme) which will limit the output to eight testimonials, unless you set the 'style' parameter to 'list'.</p>
    <p><strong>Note:</strong> Check each of the IDs you are using in the shortcode carefully. If any of the IDs are invalid, they will be ignored. If all of the IDs are invalid, no testimonials will display on the front-end.</p>

    <br><hr><br>

    <h3>Displaying all testimonials</h3>
    <p>If you want to display all of your testimonials, then you don't need to use IDs, and you can simply use the following shortcode to display all testimonials.</p>
    <code style="display: block; font-family: monospace; margin: 0 0 1em 0; font-size: 16px; background-color: #fff; padding: 10px; border-radius: 4px;">[<?php echo ORGNK_TESTIMONIALS_SHORTCODE_NAME ?>]</code></p>
    <p><strong>Note:</strong> Because the default display style is 'slider', use of this shortcode will limit the output to eight testimonials. You must set the 'style' parameter to 'list' to bypass this limit.</p>
</div>
