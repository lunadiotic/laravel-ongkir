$(document).ready(function () {
    $('select[name="province_origin"]').on('change', function(){
        let provinceId = $(this).val();
        if(provinceId) {
            jQuery.ajax({
                url: '/api/province/'+provinceId+'/cities',
                type:"GET",
                dataType:"json",
                success:function(data) {
                    $('select[name="city_origin"]').empty();
                    $.each(data, function(key, value){
                        $('select[name="city_origin"]').append(`<option value="${key}"> ${value} </option>`);
                    });
                },
            });
        } else {
            $('select[name="city_origin"]').empty();
        }
    });

    $('#city_destination').select2({
        ajax: {
            url: "/api/cities",
            type: "POST",
            dataType: "json",
            delay: 150,
            data: function (params) {
               return {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    search: $.trim(params.term)
               }
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
});
