<?php

use View\View;

$name = View::NoHTML($this->agent->getName());

?>
<div class="container">
    <h2 class="text-dark mb-4">Dashboard</h2>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-dark mb-0">Document Types</h3>
        </div>
        <div id="chart-documenttypes" class="chart-area"></div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-dark mb-0">Custom Chart</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="custom-fieldtype">Statistics for</label>
                <select id="custom-fieldtype" name="fieldType" class="form-control">
                    <!--https://stackoverflow.com/questions/3245967/can-an-option-in-a-select-tag-carry-multiple-values-->
                    <?php foreach ($this->documentFields as $field) { ?>
                        <option value="<?php echo htmlspecialchars(json_encode($field)); ?>"><?php echo $field->label; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button id="custom-fieldtype-button" class="btn btn-primary">Create</button>
        </div>
        <div id="chart-custom" class="chart-area"></div>
    </div>


</div>

<script>
    // create the chart
    var chartDocumentTypes = anychart.pie();
    // display the chart in the container
    chartDocumentTypes.container('chart-documenttypes');
    chartDocumentTypes.labels().hAlign('center').position('outside').format('{%Value} [{%PercentValue}%]');
    chartDocumentTypes.draw();

    // create the chart
    var chartCustom = anychart.pie();
    // display the chart in the container
    chartCustom.container('chart-custom');
    chartCustom.labels().hAlign('center').position('outside').format('{%Value} [{%PercentValue}%]');
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
        var obj = JSON.parse(selected);

        var urlRoot = "<?php echo $GLOBALS["ROOT_URL"] . "/dashboard/statistics/custom"; ?>";
        var url = urlRoot + "?label=" + encodeURIComponent(obj.label) + "&fieldtype=" + encodeURIComponent(obj.fieldtype);

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