<?php echo $custom_css; ?>
<div id="reddit-iotd">
    <div id="reddit-iotd-title-header">
        <div id="reddit-iotd-title">Reddit image of the day</div>
        <div id="reddit-iotd-subtitle">from <a href="<?php echo $reddit_channel_url; ?>" title="Click to open the subreddit channel" target="_blank"><?php echo $reddit_channel; ?></a></div>
    </div>
    <!-- Main display area -->
    <div id="ig-main">
        <!-- Main image -->       
            <img id="ig-iotd" alt="<?php echo $scraped; ?>" title="<?php echo $scraped; ?>" src="https://via.placeholder.com/300x150/e5d2d3/000000?text=<?php echo $scraped; ?>"/>       
        <!-- Image title -->
        <p id="ig-title"><?php echo $scraped; ?></p>
    </div>

</div>