<?php

use View\View;

$name = View::NoHTML($this->agent->getName());

?>
<div class="container">
    <h2 class="text-dark mb-4">Dashboard</h2>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-dark mb-0">Overview</h3>
        </div>
        <div id="chart-documenttypes" class="chart-area"></div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="text-dark mb-0">Custom Chart</h3>
                <select id="custom-fieldtype" name="fieldType" class="form-control">
                    <!--https://stackoverflow.com/questions/3245967/can-an-option-in-a-select-tag-carry-multiple-values-->
                    <?php foreach ($this->documentFields as $field) { ?>
                        <option value="<?php echo htmlspecialchars(json_encode($field)); ?>"><?php echo $field->label; ?></option>
                    <?php } ?>
                </select>
                <button id="custom-fieldtype-button" class="btn btn-primary">Create</button>
            </div>
        </div>
        <div id="chart-custom" class="chart-area"></div>
    </div>


</div>

<script>
    // create the chart
    var chartDocumentTypes = anychart.pie();

    // set the chart title
    //chart.title("Test");

    // display the chart in the container
    chartDocumentTypes.container('chart-documenttypes');
    chartDocumentTypes.draw();

    var chartCustom = anychart.pie();

    // set the chart title
    //chart.title("Test");

    // display the chart in the container
    chartCustom.container('chart-custom');
    chartCustom.draw();

    anychart.onDocumentReady(function () {

        $.ajax({
            url: "<?php echo $GLOBALS["ROOT_URL"] . "/dashboard/statistics/documenttypes"; ?>",
            success: function (result) {
                console.log(result);
                var data = JSON.parse(result);
                // add the data
                chartDocumentTypes.data(data);
                chartDocumentTypes.draw();
            }
        });

    });

    $('#custom-fieldtype-button').click(function () {
        var selected = $('#custom-fieldtype').val().replace(/&quot;/, "\"");
        console.log(selected);
        var obj = JSON.parse(selected);
        console.log(obj);

        var urlRoot = "<?php echo $GLOBALS["ROOT_URL"] . "/dashboard/statistics/custom"; ?>";
        console.log(urlRoot);

        var url = urlRoot + "?label=" + encodeURIComponent(obj.label) + "&fieldtype=" + encodeURIComponent(obj.fieldtype);
        console.log(url);

        $.ajax({
            url: url,
            success: function (result) {
                console.log(result);
                var data = JSON.parse(result);
                // add the data
                chartCustom.data(data);
                chartCustom.draw();
            }
        });
    });
</script>