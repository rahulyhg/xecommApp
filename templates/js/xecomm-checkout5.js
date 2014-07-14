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

  },
  validateVoucher:function(voucher_field_id, form_id, discount_field_id, net_field_id){
      // $.univ().ajaxec('index.php?page=xecommApp_page_ajaxhandler&cut_page=1&task=validateVoucher&v_no='+$(voucher_no).val()+'&subpage=xecomm-junk');      
      if($(voucher_field_id).val()=="") return;
      $.ajax({
            url: 'index.php?page=xecommApp_page_ajaxhandler&cut_page=1&task=validateVoucher&v_no='+$(voucher_field_id).val()+'&subpage=xecomm-junk',
            type: 'GET',
            data: {
              form : form_id,
              voucher_field: $(voucher_field_id).attr('name'),
              discount_field: discount_field_id, 
              net_field: net_field_id
            }
          })
          .done(function(ret) {
            eval(ret);
            console.log(ret);
          })
          .fail(function() {
            $(this).univ().errorMessage('Oops, Activity was not edited');
          })
          .always(function() {
            console.log("complete");
          });
  }

},$.univ._import);
