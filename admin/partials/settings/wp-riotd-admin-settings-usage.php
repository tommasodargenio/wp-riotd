<h1>How to use the plugin</h1>
<hr />
<p>
There are a couple of ways to display the image feed from the subreddit channel you have specified in the settings. 
<br/><br/>
One is by using the main shortcode: <code>[<?php echo $shortcode; ?>]"</code>
which will create a rectangular box where the image, title, subreddit channel will be displayed. You can affect the information displayed by using the 
switches in the Theme Layout settings tab.
<div id="highlight_box">
<h3><span class="dashicons dashicons-admin-post"></span>&nbsp;Display the feed</h3>
Copy and paste this shortcode directly into the page, post or widget where you'd like to display the feed
<input type="text" value="[<?php echo $shortcode; ?>]" size="10" readonly="readonly" style="text-align:center" onClick="this.focus();this.select()" title="To copy, click the field than press Ctrl + C (PC) or Cmd + C (Mac)" />
</div>
</p>
<p style="clear:both;padding-top:25px;">
The second way is to just get the information you are interested to display, instead of using the plugin UI. In this case use the shortcode
<code>[<?php echo $shortcode_data; ?> key=&quot;parameter&quot;]</code>
<div id="highlight_box">
<h3><span class="dashicons dashicons-admin-post"></span>&nbsp;Display a piece of data</h3>
Copy and paste this shortcode directly into the page, post or widget where you'd like to display the requested data
<input type="text" value="[<?php echo $shortcode_data; ?> key=&quot;parameter&quot;]" size="32 " readonly="readonly" style="text-align:center" onClick="this.focus();this.select()" title="To copy, click the field than press Ctrl + C (PC) or Cmd + C (Mac)" />
</div>
</p>

<p style="clear:both;padding-top:25px;">
where parameter is the field you want to extract from the plugin, you can choose from the following list of available data:
<table id="reddit_iotd_admin_table">
    <tbody>
        <tr valign="top">
            <th scope="row">Shortcode key parameter</th>
            <th scope="row">Description</th>
            <th scope="row">Example</th>
        </tr>
        <tr>
            <td>thumbnail_url</td>
            <td>The url pointing at the thumbnail version of the image</td>
            <td><code>[<?php echo $shortcode_data; ?> key="thumbnail_url"]</code></td>
        </tr>
        <tr>
            <td>full_res_url</td>
            <td>The url pointing at the full resolution image</td>
            <td><code>[<?php echo $shortcode_data; ?> key="full_res_url"]</code></td>
        </tr>
        <tr>
            <td>width</td>
            <td>The full resolution width in pixels of the image</td>
            <td><code>[<?php echo $shortcode_data; ?> key="width"]</code></td>
        </tr>
        <tr>
            <td>height</td>
            <td>The full resolution height in pixels of the image</td>
            <td><code>[<?php echo $shortcode_data; ?> key="height"]</code></td>
        </tr>
        <tr>
            <td>title</td>
            <td>The title or caption of the image as provided by the post's author</td>
            <td><code>[<?php echo $shortcode_data; ?> key="title"]</code></td>
        </tr>
        <tr>
            <td>post_url</td>
            <td>The url pointing at the subreddit post containing the image</td>
            <td><code>[<?php echo $shortcode_data; ?> key="post_url"]</code></td>
        </tr>
        <tr>
            <td>author</td>
            <td>The author username of the post containing the image</td>
            <td><code>[<?php echo $shortcode_data; ?> key="author"]</code></td>
        </tr>
        <tr>
            <td>nsfw</td>
            <td>A boolean value (either true or false) indicating if the image is marked as NSFW (i.e.: adult content) or not</td>
            <td><code>[<?php echo $shortcode_data; ?> key="nsfw"]</code></td>
        </tr>

    </tbody>
</table>

</p>
<p>
If you don't like the styling applied by our CSS (it works fine with the standard twenty-twentyone wordpress theme, but it might not with your own theme), you can setup 
the plugin not to use our CSS and you could override all the classes used so to apply your own styling and color palette.
</p>

