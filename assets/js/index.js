$(document).ready(function(){
    $("#reservation_storageVolumeId").chained("#reservation_storageTypeId");
    $("#reservation_storageVolumeId").prop("disabled", true).prop("required", true);

    $('.reservation-details').click(function() {
        var url = Routing.generate('reservation_details', {id: $(this).attr('id')});
        $.get(url, function (data) {
            $(".modal-content").html(data);
        });
    });

    $('.admin-reservation-details').click(function() {
        var url = Routing.generate('admin_reservation_details', {id: $(this).attr('id')});
        $.get(url, function (data) {
            $(".modal-content").html(data);
        });
    });

    $('.admin-deactivate-user').click(function() {
        var url = Routing.generate('admin_deactivate_user', {id: $(this).attr('id')});
        $.get(url, function (data) {
            $(".modal-content").html(data);
        });
    });

    $('.admin-activate-user').click(function() {
        var url = Routing.generate('admin_activate_user', {id: $(this).attr('id')});
        $.get(url, function (data) {
            $(".modal-content").html(data);
        });
    });

    $('.admin-edit-user').click(function() {
        var url = Routing.generate('admin_edit_user', {id: $(this).attr('id')});
        console.log(url);
        $.get(url, function (data) {
            $(".modal-content").html(data);
        });
    });

    $('.admin-deactivate-storage-type').click(function() {
        var url = Routing.generate('admin_deactivate_storage_type', {id: $(this).attr('id')});
        $.get(url, function (data) {
            $(".modal-content").html(data);
        });
    });

    $('.admin-activate-storage-type').click(function() {
        var url = Routing.generate('admin_activate_storage_type', {id: $(this).attr('id')});
        $.get(url, function (data) {
            $(".modal-content").html(data);
        });
    });

    $('.admin-edit-storage-type').click(function() {
        var url = Routing.generate('admin_edit_storage_type', {id: $(this).attr('id')});
        console.log(url);
        $.get(url, function (data) {
            $(".modal-content").html(data);
        });
    });
})

$( "#reservation_storageTypeId" ).on('click', function () {
    $( "#reservation_storageVolumeId" ).prop("disabled", false);
})

$(".hasDeliveryDetails").prop("hidden", true);

$(".delivery-required select, input.delivery-required").prop("required", false).prop("disabled", true);

$( "#reservation_hasDelivery").change(function () {
    if ($(this).val() == 1) {
        $( ".hasDeliveryDetails " ).prop("hidden", false);
        $(".delivery-required select, input.delivery-required").prop("required", true).prop("disabled", false);
    } else {
        $( ".hasDeliveryDetails " ).prop("hidden", true);
        $(".delivery-required select, input.delivery-required").prop("required", false).prop("disabled", true);
    }
})