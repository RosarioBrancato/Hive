<?php

use View\View;

$name = View::NoHTML($this->agent->getName());

?>
<div class="container">

    <h1>Dashboard Home</h1>
   <p>Welcome <?php echo $name; ?></p>
    <a href="<?php echo $GLOBALS["ROOT_URL"] . '/documents/new'; ?>" class="btn btn-info">Add Document</a>
    <div id="chartsGrid">

    </div>
</div>

<script>
    anychart.onDocumentReady(function() {

        // set the data
        var data = [
            {x: "A", value: 100},
            {x: "B", value: 50},
            {x: "C", value: 12},
            {x: "D", value: 150},
            {x: "E", value: 540},
            {x: "F", value: 191},
        ];

        // create chart
        var chart = anychart.pie();
        // set chart title
        chart.title("Just testing");
        // add data
        chart.data(data);
        // display chart in div chartsGrid
        chart.container('chartsGrid');
        //draw chart
        chart.draw();

    });
</script>