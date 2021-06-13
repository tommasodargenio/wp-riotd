<?php defined( 'ABSPATH' ) || die( 'No direct script access allowed!' ); // Prohibit direct script loading. ?>
<h1>How to use the plugin</h1>
<hr />
<p>
The first step is to setup the plugin, indicating the subdreddit <a href="<?php $this->get_tab_url("channel", true); ?>">channel</a> you want to fetch images from, 
the <a href="<?php $this->get_tab_url("image", true); ?>">image</a> resolution and aspect ratio, which kind of data you want it <a href="<?php $this->get_tab_url("layout", true); ?>">displayed</a>.
</p>
<p>
There are a couple of ways to display the image feed from the subreddit channel you have specified in the <a href="<?php $this->get_tab_url("channel", true); ?>">settings</a>. 
It involves using shortcodes (specific keywords contained in square brackets, read more <a href="https://wordpress.com/support/shortcodes/" title="open the wordpress support web page in a new tab" target="_blank">here</a>),
beware that shortcodes might not be processed in posts' excerpts but only in full posts depending on how your wordpress theme has been developed.
<br/><br/>
One is by using the main shortcode: <code>[<?php echo $shortcode; ?>]</code>
which will create a rectangular box where the image, title, subreddit channel will be displayed. You can affect the information displayed by using the 
switches in the Theme Layout <a href="<?php $this->get_tab_url("layout", true); ?>">settings</a> tab.
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
<h1>Styling</h1>
<hr />

<p>
While the CSS styling built-in with this plugin is compatible in color palette and style with the default WordPress theme Twenty Twenty-One, it might not be of your liking
or it could not work with your theme of choice. In such case you can disable the plug-in CSS with the toggle in the <a href="<?php $this->get_tab_url("layout", true); ?>">setting</a> page, and override the CSS classes we use with your
own styling. You can find below a summary of the classes used by the plugin:
<table id="reddit_iotd_admin_table">
    <tbody>
        <tr valign="top">
            <th scope="row">CSS Id #</th>
            <th scope="row">Description</th>            
            <th scope="row">CSS Id #</th>
            <th scope="row">Description</th>                
        </tr>
        <tr>
            <td><code>reddit-iotd</code></td>
            <td>this is the main box that will contain the title, image, links, etc.</td>            
            <td><code>ig-main</code></td>
            <td>the main box where the image is contained</td>            
        </tr>
        <tr>
            <td><code>reddit-iotd-title-header</code></td>
            <td>the main title area</td>            
            <td><code>ig-iotd</code></td>
            <td>the thumbnail image styling</td>            
        </tr>
        <tr>
            <td><code>reddit-iotd-title</code></td>
            <td>the plugin name by default or a title of your choice as specified in the <a href="<?php $this->get_tab_url("general", true); ?>">settings</a></td>
            <td><code>ig-iotd-full</code></td>
            <td>the full resolution image styling</td>            
        </tr>
        <tr>
            <td><code>reddit-iotd-subtitle</code></td>
            <td>the subtitle, containing the subreddit from which the image has been fetched</td>
            <td><code>ig-title</code></td>
            <td>the image caption and its author</td>            
        </tr>               
        <tr>
            <td><code>reddit-iotd-close-button</code></td>
            <td>the close button showing in the ligthbox</td>
            <td><code>reddit-iotd-close-button span:hover</code></td>
            <td>the style change on the mouseOver of the close button</td>            
        </tr>  
        <tr>
            <td><code>reddit-iotd-link-button</code></td>
            <td>the link button showing in the lightbox, this will contain the link to the original subreddit post with the image</td>
            <td><code>reddit-iotd-link-button span:hover</code></td>
            <td>the style change on the mouseOver event of the link button</td>            
        </tr>        
        <tr>
            <td><code>reddit-iotd-full-size</code></td>
            <td>the lightbox containing the full-resolution image</td>
            <td></td>
            <td></td>            
        </tr>           
    </tbody>
</table>
</p>

