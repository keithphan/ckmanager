/*!
    * Start Bootstrap - SB Admin Pro v2.0.0 (https://shop.startbootstrap.com/product/sb-admin-pro)
    * Copyright 2013-2021 Start Bootstrap
    * Licensed under SEE_LICENSE (https://github.com/StartBootstrap/sb-admin-pro/blob/master/LICENSE)
    */
    window.addEventListener('DOMContentLoaded', event => {
    // Activate feather
    feather.replace();

    // Enable tooltips globally
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enable popovers globally
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Activate Bootstrap scrollspy for the sticky nav component
    const stickyNav = document.body.querySelector('#stickyNav');
    if (stickyNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#stickyNav',
            offset: 82,
        });
    }

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sidenav-toggled'));
        });
    }

    // Close side navigation when width < LG
    const sidenavContent = document.body.querySelector('#layoutSidenav_content');
    if (sidenavContent) {
        sidenavContent.addEventListener('click', event => {
            const BOOTSTRAP_LG_WIDTH = 992;
            if (window.innerWidth >= 992) {
                return;
            }
            if (document.body.classList.contains("sidenav-toggled")) {
                document.body.classList.toggle("sidenav-toggled");
            }
        });
    }

    // Add active state to sidbar nav links
    let activatedPath = window.location.pathname.match(/([\w-]+\.html)/, '$1');

    if (activatedPath) {
        activatedPath = activatedPath[0];
    } else {
        activatedPath = 'index.html';
    }

    const targetAnchors = document.body.querySelectorAll('[href="' + activatedPath + '"].nav-link');

    targetAnchors.forEach(targetAnchor => {
        let parentNode = targetAnchor.parentNode;
        while (parentNode !== null && parentNode !== document.documentElement) {
            if (parentNode.classList.contains('collapse')) {
                parentNode.classList.add('show');
                const parentNavLink = document.body.querySelector(
                    '[data-bs-target="#' + parentNode.id + '"]'
                );
                parentNavLink.classList.remove('collapsed');
                parentNavLink.classList.add('active');
            }
            parentNode = parentNode.parentNode;
        }
        targetAnchor.classList.add('active');
    });
});

$('#lfm').filemanager('image');

var rowNumber = $(".rows").children().length;
for(var i = 0; i < rowNumber; i++){
    $('#lfm-' + (i + 1) ).filemanager('image');
}

var varinantNumber = $("#variant-wrapper").children().length;
for(var i = 0; i < varinantNumber; i++){
    $('#variant_gallery_button-' + (i + 1) ).filemanager('image');
}

$(function () {
    $("#toastBasic").toast("hide");
    if($(".toast-body").text()){
        $("#toastBasic").toast("show");
    }
});

$(document).on('click','.delete',function(){
    let id = $(this).attr('data-id');
    $("#id").val(id);
});

$(document).on('click','.finish',function(){
    let id = $(this).attr('data-id');
    $("#orderId2").val(id);
});

$(document).on('click','.restore',function(){
    let id = $(this).attr('data-id');
    $("#orderId3").val(id);
});

$(document).on('click','.deliver',function(){
    let id = $(this).attr('data-id');
    let shippingAddress = $('#customerDeliverAddress').val();
    $("#shippingAddress").text(shippingAddress);
    $("#orderId").val(id);
});

$(document).on('click','#deleteItems',function(){
    $("#itemIds").val($("input.selectedItems:checked").map(function() { return this.value;}).get());
});

$(document).on('change', '#selectAll', function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});

$(document).on('change', '.selectedItems', function () {
    if(this.checked == false){
		$("#selectAll").prop('checked', false);
	}

    if ($('.selectedItems:checked').length == $('.selectedItems').length){
		$("#selectAll").prop('checked', true);
	}
});


$(function () {
    $('.selectParent').select2({
        theme: 'bootstrap-5',
        placeholder: 'None',
        allowClear: true,
    });

    $('.selectBrand').select2({
        theme: 'bootstrap-5',
        placeholder: 'None',
        allowClear: true,
    });

    $('#categories').select2({
        theme: 'bootstrap-5',
        // placeholder: 'None',
        // allowClear: true,
    });

    $('#company_id').select2({
        theme: 'bootstrap-5',
        // placeholder: 'None',
    });

    $('#category_id').select2({
        theme: 'bootstrap-5',
        // allowClear: true,
    });

    $('#productList').select2({
        theme: 'bootstrap-5',
        // allowClear: true,
    });

    $('#customer').select2({
        theme: 'bootstrap-5',
        // allowClear: true,
    });

    $(document).on("click", "#btnImgAdd", function () {
        var number = $(".rows").children().length;
        var ele = $("<div class='row'></div>").html("<div class='col-12'><div class='mb-3'><div class='input-group'><input id='gallery-" + (number + 1) + "' class='form-control' type='text' name='gallery[]'><a id='lfm-" + (number + 1) + "' data-input='gallery-" + (number + 1) + "' data-preview='holder-" + (number + 1) + "' class='btn btn-primary'>Choose</a></div><div id='holder-" + (number + 1) + "' style='margin-top:15px;margin-bottom:15px;max-height:200px;'></div></div></div>");
        $(".rows").append(ele);
        $('#lfm-' + (number + 1) ).filemanager('image');
    });

    $(document).on("click", "#addVariant", function () {
        var number = $("#variant-wrapper").children().length;
        if(number < 5){
            var ele = $("<div class='row'></div>").html("<div class='col-2'><div class='mb-3'><input class='form-control' name='variant_name[]'></div></div><div class='col-2'><div class='mb-3'><div class='input-group'><div class='input-group-text'>$</div><input class='form-control' type='number' name='variant_price[]' step='any' min='0' value='0'></div></div></div><div class='col-1'><div class='mb-3'><input class='form-control' type='number' name='variant_quantity[]' step='any' min='0' value='0'></div></div><div class='col-7'><div class='mb-3'><div class='input-group'><input class='form-control' id='variant_gallery-" + (number + 1) +  "' type='text' name='variant_gallery[]'><a id='variant_gallery_button-" + (number + 1) + "' data-input='variant_gallery-" + (number + 1) + "' data-preview='variant-gallery-holder-" + (number + 1) + "' class='btn btn-primary'>Choose</a></div><div id='variant-gallery-holder-" + (number + 1) + "' style='margin-top:15px;margin-bottom:15px;max-height:200px;'></div></div></div>");
            $("#variant-wrapper").append(ele);
            $('#variant_gallery_button-' + (number + 1)).filemanager('image');
        }else{
            alert("Only 5 variants allowed");
        }
    });

    


    $(document).on("click", "#btnAddressAdd", function () {
        var number = $(".rows").children().length;
        if(number <= 5){
            var ele = $("<div class='row'></div>").html("<div class='input-group mb-3'><span class='input-group-text' data-bs-toggle='tooltip' data-bs-placement='left' title='Set as default'><input type='radio' name='default' value=" + (number - 1) + "></span><input class='form-control' id='customerDeliverAddress' type='text' name='customerDeliverAddresses[]'></div>");
            $(".rows").append(ele);
        }else{
            alert("Only 5 addresses allowed");
        }
    });

    $(document).on("keyup change", '#customerDeliverAddress', function () {
        var customerDeliverAddress = $("#customerDeliverAddress").val();
        $("#filled_address").text(customerDeliverAddress);
    });

    $(document).on("click keyup change", '.selectedItems, #shipping_fee, .itemsQty', function () {
        var itemsList = $('.selectedItems:checked').map(function(){return $(this).val();}).get();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var itemsQtyElements = $(".itemsQty").map(function(){return this}).get();

        var data = [];

        itemsList.forEach(element => {
            itemsQtyElements.forEach(ele => {
                if(element === $(ele).attr("product-id")){
                    data.push([element, $(ele).val()])
                }
            })
        });

        $.ajax({
            type: "POST",
            url: "/orders/getTotalPriceByIds",
            data: {_token: CSRF_TOKEN, data: data},
            dataType: "json",
            success: function (response) {
                var shipping_fee = $("#shipping_fee").val();
                $("#filled_total").text("$" + response.total / 100);
                $("#total").val(response.total / 100 + parseInt(shipping_fee ? shipping_fee : 0));
            }
        });
    });

    $(document).on("change", '#customer', function () {
        let customer_id = this.value;

        if(customer_id!= ""){
            let company_id = $('.company_id').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: "POST",
                url: "/customers/getCustomerInfoByIdAndCompanyId",
                data: {_token: CSRF_TOKEN, data: [customer_id, company_id]},
                dataType: "json",
                success: function (response) {
                    let customer = response.customer;
                    $("#customerName").val(customer.name);
                    $("#customerPhoneNumber").val(customer.phone_number);
                    $("#customerEmailAddress").val(customer.email);
                    $("#customerDeliverAddress").val(response.deliverAddress);
                    $("#filled_address").text(response.deliverAddress);
                }
            });
        }else{
            $("#customerName").val("");
            $("#customerPhoneNumber").val("");
            $("#customerEmailAddress").val("");
            $("#customerDeliverAddress").val("");
            $("#filled_address").text("...");
        }
    });

    $(document).on("click", '.button-apply',function () {
        var dateString = $('#litepickerRangePlugin').val();
        var date = dateString.split('-');
        window.location.href = '/revenue/eflux?startDate=' + date[0].replaceAll('/', '-').trim() + "&endDate=" + date[1].replaceAll('/', '-').trim();
    });
});

