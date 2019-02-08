$(document).ready(function(){
    $("#reservation_storageVolumeId").chained("#reservation_storageTypeId");
    $("#reservation_storageVolumeId").prop("disabled", true);
})
$( "#reservation_storageTypeId" ).on('click', function () {
    $( "#reservation_storageVolumeId" ).prop("disabled", false);
})
$(".hasDeliveryDetails").prop("hidden", true);
$("#delivery_dateFrom_year, #delivery_dateFrom_month, #delivery_dateFrom_day, #delivery_dateTo_day, #delivery_dateTo_month, #delivery_dateTo_year, #delivery_address, #delivery_phoneNumber ")
    .prop("required", false).prop("disabled", true);
$( "#reservation_hasDelivery").change(function () {
    if ($(this).val() == 1) {
        $( ".hasDeliveryDetails " ).prop("hidden", false);
        $("#delivery_dateFrom_year, #delivery_dateFrom_month, #delivery_dateFrom_day, #delivery_dateTo_day, #delivery_dateTo_month, #delivery_dateTo_year, #delivery_address, #delivery_phoneNumber ")
            .prop("required", true).prop("disabled", false);
    } else {
        $( ".hasDeliveryDetails " ).prop("hidden", true);
        $("#delivery_dateFrom_year, #delivery_dateFrom_month, #delivery_dateFrom_day, #delivery_dateTo_day, #delivery_dateTo_month, #delivery_dateTo_year, #delivery_address, #delivery_phoneNumber ")
            .prop("required", false).prop("disabled", true);
    }
})
// $("#reservation_userId").val("5").prop("selected", true);
// $(".hasDeliveryDetails").on('submit', function() {
//     return false;
// })