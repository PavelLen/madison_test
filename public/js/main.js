$(document).ready(function () {

    /**
     * Load modification data
     */
    $('input[type=radio]').on('change', function() {
        var radio = $(this).val();
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: {"radio" : radio},
            dataType: 'json',
            success: function(data) {
                $('#specification').removeAttr('hidden');
                $('#buyNow').removeAttr('hidden');
                $('#vendoreCode').text(data.vendorCode);
                $('#color').text(data.color);
                $('#size').text(data.size);
                $('#price').text(data.price);
            },
            error: function() {
                console.log('radio (modifications) it broke');
            }
        });
    });

    /**
    *Add minus or plus icon for collapse element
    */
    $(".panel-heading a").each(function(){

        $(this).on('click', function(){
            if($(this).find('span.glyphicon').hasClass("glyphicon-plus") ){
                $(this).find('span.glyphicon').removeClass("glyphicon-plus");
                $(this).find('span.glyphicon').addClass("glyphicon-minus");
            } else {
                $(this).find('span.glyphicon').removeClass("glyphicon-minus");
                $(this).find('span.glyphicon').addClass("glyphicon-plus");
            }
        });

    });

    /**
     * Edit, new, delete price period
     */
    $(".bs-example").on('click', '.btn', function(){
        var attr = $(this).attr('name');
        var modificationId = $(this).attr('data-modif');
        var pricePeriodId = $(this).attr('data-id');
        var data;

        /**
         * New Price Period
         */
        if (attr === 'save') {
            $('#newPeriodForm_'+modificationId).on('submit', function (e) {
                e.preventDefault();
                data = $('#newPeriodForm_'+modificationId).serialize()+'&'+$.param({ 'newPricePeriod' : modificationId });

                addPricePeriod(data, modificationId);
                $('form#newPeriodForm_'+modificationId).trigger('reset');
                $(this).off(e);
            });
        }
        /**
         * Edit Price Period
         */
        else if(attr === 'edit'){
            var tdVals = $(this).parent('td').siblings('td').map(function(i, td){
                return $(td).text();
            });

            $('#newPeriodFrom_'+modificationId).val(tdVals[0]);
            $('#newPeriodTo_'+modificationId).val(tdVals[1]);
            $('#newPeriodPrice_'+modificationId).val(parseFloat(tdVals[2]));
            $("#save_"+modificationId).attr({'name' : 'submit'});
            $('#newPeriodForm_'+modificationId).on('submit', function (e) {
                e.preventDefault();
                data = $('#newPeriodForm_'+modificationId).serialize()+'&'+$.param({ 'editPricePeriodId' : pricePeriodId });
                editPricePeriod(data, modificationId);
                $('form#newPeriodForm_'+modificationId).trigger('reset');
                $("#save_"+modificationId).attr({ 'name' : 'save'});
                $(this).off(e);
            });
        }
        /**
         * Delete Price Period
         */
        else if (attr === 'delete') {

            data = $.param({ 'deletePricePeriodId' : pricePeriodId });
            deletePricePeriod(data);
            $('form#newPeriodForm_'+modificationId).trigger('reset');
        }
        /**
         * Clear form
         */
        else if(attr === 'cancel') {
            productId = $(this).attr('data-prod');
            $('form#newPeriodForm_'+modificationId).trigger('reset');
            $("#save_"+modificationId).attr({'name' : 'save'});
        }
    });

    /**
     * Add new price period
     */
    function addPricePeriod(data, modificationId) {
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: data,
            success: function(data)
            {
                if(data.error){
                    $("#error_"+modificationId).removeAttr('hidden').text(data.error);
                } else {
                    console.log(data.action);
                    $("#error_"+modificationId).hide();
                    $( "#table_"+modificationId+" tbody").append(
                        '<tr id="edit_period_'+data.id+'">' +
                            '<td id="periodForm_'+data.id+'">'+data.dateFrom+'</td>' +
                            '<td id="periodTo_'+data.id+'">'+data.dateTo+'</td>' +
                            '<td id="periodPrice_'+data.id+'">'+data.price+' руб'+'</td>' +
                            '<td>' +
                                '<button name="edit" type="button" class="btn btn-primary" data-id="'+data.id+'" data-modif="'+modificationId+'">edit</button>' +
                                '<button style="margin-left: 25px;" name="delete" type="button" class="btn btn-danger" data-id="'+data.id+'">delete</button>' +
                            '</td>' +
                        '</tr>'
                    );
                }
            },
            error: function() {
                console.log('function addPricePeriod it broke');
            }
        });
    }

    /**
     * Edit price period
     */
    function editPricePeriod(data, modificationId) {
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: data,
            success: function(data)
            {
                if(data.error){
                    $("#error_"+modificationId).removeAttr('hidden').text(data.error);
                } else {
                    console.log(data.action);
                    $("#error_"+modificationId).hide();
                    $("#periodForm_"+data.id).html(data.dateFrom);
                    $("#periodTo_"+data.id).html(data.dateTo);
                    $("#periodPrice_"+data.id).html(data.price+' руб');
                }
            },
            error: function() {
                console.log('function editPricePeriod it broke');
            }

        });
    }

    /**
     * Delete Price Period
     */
    function deletePricePeriod(data){
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: data,
            success: function(data)
            {
                console.log(data.action);
                $('#edit_period_'+data.id).remove();
            },
            error: function(data) {
                console.log('function deletePricePeriod it broke'+data);
            }
        });
    }

    /**
     * Google Charts
     */
   /* google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Sales', 'Expenses'],
            ['2013',  1000,      400],
            ['2014',  1170,      460],
            ['2015',  660,       1120],
            ['2016',  1030,      540]
        ]);

        var options = {
            title: 'Company Performance',
            hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }*/
});