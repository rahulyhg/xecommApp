$.each({
  calculateRow: function(rate_field,qty_field,amount_field){
    $(qty_field).val($(qty_field).val().replace(/[^0-9\.]/g,''));
    $(amount_field).val($(rate_field).val() * $(qty_field).val());
  },
  calculateTotal: function(amount_fields, total_field){
    var total=0
    console.log(amount_fields);
    $.each(amount_fields, function(index, val) {
      total += ($(val).val()*1);
    });
    $(total_field).val(total);
  },
  calculateTax: function(total_field,tax_field,net_field){
    $(net_field).val(($(total_field).val()*1) + (($(tax_field).val() * $(total_field).val() / 100.00))*1);
  },
  calculateNet: function(total_field,points_redeemed_field,net_field, points_req_for_one_rupees, points_available, min_points_req){
    if($(points_redeemed_field).val()*1  > (points_available-min_points_req)) {
      $(points_redeemed_field).val(0);
      $(this).univ().errorMessage('Points not entered correctly ');
    }
    $(net_field).val(($(total_field).val()*1) - ($(points_redeemed_field).val()*1 / points_req_for_one_rupees));
  }

},$.univ._import);
