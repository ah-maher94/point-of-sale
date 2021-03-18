$(document).ready(function(){

    $('.add-order-product').on('click', function(){
        var name = $(this).data('name');
        var id = $(this).data('id');
        var price = $(this).data('price');

        var newOrderProduct = `
        <tr>
        <th>${name}</th>
        <th><input type="number" value="1" step="1" min="1"></th>
        <th>${price}</th>
        <th><button class="btn btn-danger btn-sm remove-order-product" data-id="${id}">
                <i class="fa fa-trash"></i>
            </button></th>
        </tr>
        `;

        $('.order-list').append(newOrderProduct);

        $(this).removeClass('btn-success').addClass('btn-default');
        $(this).attr('disabled', true);
    });


    $('body').on('click', '.remove-order-product', function(e){
        e.preventDefault();

        var removedProductId = $(this).data('id');
        $(this).closest('tr').remove();

        $('#product-'+removedProductId).removeClass('btn-default').addClass('btn-success').removeAttr('disabled');

    });

});
