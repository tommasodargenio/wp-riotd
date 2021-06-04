function closest(e, t) { 
    return !e? false : e === t ? true : closest(e.parentNode, t);
}

function wp_riotd_image_link(url) {
    if ( url != "" ) {
        window.open(url, '_blank');
    }    
}

function wp_riotd_image_fullscreen() {    
    var box = document.getElementById("reddit-iotd-full-size");
    box.style.display = "block";

      var full_img = document.getElementById("ig-iotd-full");

      if (full_img.clientWidth > box.clientWidth) {
          var resized = full_img.clientWidth;
          //while ( resized >= box.clientWidth ) {
            resized = full_img.clientWidth - (box.clientWidth * .15);
          //}
          full_img.style.width = resized.toString() + "px";          
      }
      if (full_img.clientHeight > box.clientHeight) {
          var resized = full_img.clientHeight;
          //while( resized >= box.clientHeight ) {
            resized = full_img.clientHeight - (box.clientHeight * .15);
          //}
          full_img.style.height = resized.toString() + "px";          
      }
    
}

function wp_riotd_image_close() {
    var box = document.getElementById("reddit-iotd-full-size");
    box.style.display = "none";   
}

document.addEventListener("click", function(e) {
    var box = document.getElementById("reddit-iotd-full-size");
    if (!closest(e.target, box)) {
        box.style.display = "none";        
    }
});