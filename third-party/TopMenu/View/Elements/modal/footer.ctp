			
<table style="width: 100%; padding-top: 40px;"><tr><td>&nbsp;</td></tr></table> <!-- only to force div height -->
</div>
</div>
</div>
<script type="text/javascript">
    go();
    window.addEventListener('resize', go);
    function go() {
        // Select the div
        var div = $('#modalConfirmation');
        // Get the width;
        var width = div.outerWidth();
        var windowWidth = $(document).width();
        var total = (windowWidth - width);
        // Change the margin-left to half negative
        div.css({'marginLeft': -(total / 2) + 'px'});
        div.css({'left': Math.abs(total) + 'px'});
        total = null;        
    }//@ sourceURL=pen.js
        
    $('#please_wait_spinner').hide();
    
</script>