
$(document).ready(function(){

    $('.add-order-product').on('click', function(){
        var name = $(this).data('name');
        var id = $(this).data('id');
        var price = $(this).data('price');

        var newOrderProduct = `
        <tr>
        <th>${name}</th>
        <th><input type="number" value="1" step="1" name="quantities[${id}][quantity]" min="1" data-price="${price}" class="quantity"></th>
        <th class="product-price">${price}</th>
        <th><button class="btn btn-danger btn-sm remove-order-product" data-id="${id}">
                <i class="fa fa-trash"></i>
            </button></th>
        </tr>
        `;

        $('.order-list').append(newOrderProduct);

        $(this).removeClass('btn-success').addClass('btn-default');
        $(this).attr('disabled', true);

        calculateTotalPrice();
    });


    $('body').on('click', '.remove-order-product', function(e){
        e.preventDefault();

        var removedProductId = $(this).data('id');
        $(this).closest('tr').remove();

        $('#product-'+removedProductId).removeClass('btn-default').addClass('btn-success').removeAttr('disabled');

        calculateTotalPrice();
    });

    // calculate each product total price
    $('body').on('change keyup', '.quantity', function(){

        var productQunatity = $(this).val();
        var productPrice = $(this).data('price');

        $(this).closest('tr').find('.product-price').html(productPrice * productQunatity);

        calculateTotalPrice()

    });

    // display order products
    $('.order-products').on('click', function(){
        var url = $(this).data('url');
        
        $.ajax({
            url: url,
            method: 'get',
            success: function(data){
                $('#order-product-list').html(data);
            }

        })
    });


});

// calculate total price
function calculateTotalPrice(){
    var totalPrice = 0;
    $('.product-price').each(function(){
        totalPrice += parseInt($(this).html());
    })

    $('.total-price').html(totalPrice);

    if(totalPrice > 0){
        $('#add-order-form-btn').removeAttr('disabled');
    }else{
        $('#add-order-form-btn').attr('disabled', true);
    }
}