$(document).ready(function () {
    $('input[type=radio]').on('change', function() {
        var radio = $(this).val();
        console.log(radio);
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
                console.log('it broke');
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

    /*$(".btn-primary[name=submit]").on('click', function(e){
        e.preventDefault();
        console.log('sdf');
    });*/

    $("button").on('click', function(event){
        var attr = $(this).attr('name');
        if(attr === 'edit'){
            var tdVals = $(this).parent('td').siblings('td').map(function(i, td){
                return $(td).text();
            });

            var productId = $(this).attr('data-prod');
            var modificationId = $(this).attr('data-modif');
            var pricePeriodId = $(this).attr('data-id');

            console.log(productId, modificationId, pricePeriodId);

            $('#newPeriodFrom_'+productId).val(tdVals[0]);
            $('#newPeriodTo_'+productId).val(tdVals[1]);
            $('#newPeriodPrice_'+productId).val(parseFloat(tdVals[2]));

            $('#newPeriodForm_'+productId).submit(function (e) {
                e.preventDefault();
                var data = $('#newPeriodForm_'+productId).serialize()+'&'+$.param({ 'pricePeriodId' : pricePeriodId });
                console.log(data);
                console.log('end');
                editPeriod(data);
                $('form#newPeriodForm_'+productId).trigger('reset');
                $(this).off(e);
            });
        }
    });

    /*update old or add new price period*/
    function editPeriod(data) {
        var data = data;
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: data,
            success: function(data)
            {
                $("#periodForm_"+data[0].id).html(data[0].dateFrom);
                $("#periodTo_"+data[0].id).html(data[0].dateTo);
                $("#periodPrice_"+data[0].id).html(data[0].price+'.00 руб');
            }
        });
    }
});