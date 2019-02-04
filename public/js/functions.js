$( "#reservation_storageTypeId" ).change(function () {
    $( "#reservation_storageVolumeId" ).prop("disabled", false);
})
$(document).ready(function(){
    $("#reservation_storageVolumeId").chained("#reservation_storageTypeId");
})
$( "#reservation_hasDelivery").change(function () {
    if ($(this).val() == 1) {
        $( ".hasDeliveryDetails " ).prop("hidden", false).prop("disabled", false);
    } else {
        $( ".hasDeliveryDetails " ).prop("hidden", true).prop("disabled", true);
    }
})
// $("#reservation_userId").val("5").prop("selected", true);
// $(".hasDeliveryDetails").on('submit', function() {
//     return false;
// })