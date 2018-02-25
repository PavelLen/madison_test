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

    $('#new').su('click', 'td', function() {
        var href = $(this).find("a").attr("href");
        console.log('sdsd');
        if(href) {
            window.location = href;
        }
    });

    /*$('#table_admin').on('click', 'tr', function() {
        var id = $(this).attr('data-id');
        $('#modifications').remove();
        $('.position').toggle(function () {
            $('.position').slideDown('fast').show();
            $('.position').removeClass('glyphicon glyphicon-arrow-left').addClass('glyphicon glyphicon-arrow-down');
        });

        $('#' + id).after('<tbody id="modifications">' +
            '<tr style="background-color:green">' +
            '<td>vendoreCode</td>' +
            '<td>color</td>' +
            '<td>size</td>' +
            '<td>prise</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="vendoreCode"></td>' +
            '<td class="color"></td>' +
            '<td class="size"></td>' +
            '</tr>' +
            '</tbody>');

        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: {"id" : id},
            dataType: 'json',
            success: function(data) {
                $('#specification').removeAttr('hidden');
                $.each(data, function(i) {
                    $('.vendoreCode').text(data[i].vendorCode);
                    $('.color').text(data[i].color);
                    $('.size').text(data[i].size);
                    /!*$('#price').text(data.price);*!/
                    //console.log(data[i].id);
                })
            },
            error: function() {
                console.log('it broke');
            }
        });
    });*/

});