$(document).ready(function () {
     // Initialize select2 if needed
     if ($.fn.select2) {
          $('select[name="farm_id"]').select2();
     }

     // Handle farm selection
     $('select[name="farm_id"]').on('change', function () {
          var farmId = $(this).val();
          if (!farmId) return;

          // Show loading state
          $('#ajax_farm_name').text('লোড হচ্ছে...');
          $('#ajax_owner_name, #ajax_phone_number, #ajax_address, #ajax_unique_id').text('...');
          $('#ajax_photo').attr('src', '{{ asset("assets/img/dummy.png") }}');

          // Send AJAX request
          $.ajax({
               url: '/get-farm-details/' + farmId,
               method: 'GET',
               dataType: 'json',
               success: function (data) {
                    $('#ajax_farm_name').text(data.farm_name + ',');
                    $('#ajax_unique_id').text(data.unique_id);
                    $('#ajax_owner_name').text(data.owner_name);
                    $('#ajax_phone_number').text(data.phone_number);
                    $('#ajax_address').text(data.address);
                    $('#ajax_photo').attr('src', data.photo);
               },
               error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('#ajax_farm_name').text('ত্রুটি হয়েছে');
               }
          });
     });

     // Reset select2 fields on form reset
     $('form').on('reset', function () {
          // Slight delay to allow form reset to complete
          setTimeout(function () {
               $('select[data-control="select2"]').each(function () {
                    $(this).val('').trigger('change'); // or null based on your use-case
               });
          }, 50);

          // Clear the AJAX-loaded fields
          $('#ajax_farm_name').text('খামারের নাম,');
          $('#ajax_unique_id').text('100010');
          $('#ajax_owner_name').text('মালিকের নাম');
          $('#ajax_phone_number').text('০১৭০০-০০০০০০');
          $('#ajax_address').text('আপন ঠিকানা');
          $('#ajax_photo').attr('src', '/assets/img/dummy.png');

     });
});