<canvas id="myChart" width="400" height="400"></canvas>

<?php echo $this->Html->script('Charts.min.js'); ?>
<script type="text/javascript">
    
    // Get the context of the canvas element we want to select
    var ctx = document.getElementById("myChart").getContext("2d");
    var myNewChart = new Chart(ctx).PolarArea(data);
    
    // instantiated the Pie Chart class on the canvas
    var myPieChart = new Chart(ctx[0]).Pie(data,options);
</script>
    

