jQuery(function($){
    $(document).ready(function() {
        $('#formOrderGame').submit(function(event) { 
            // Menghentikan pengiriman form bawaan browser
            event.preventDefault();
            $('#responOrderModal').modal('show'); 

            $form = $(this);
            $form.find('.form-alert-msg').remove();
            $form.addClass('placeholder bg-transparent w-100');
            $modal = $('#responOrderModal').find('.modal-body');
            $modal.html('<div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div>');

            // Mendapatkan data form yang di-serialize
            var formData = $(this).serialize();

            // Mengirim data form ke server
            $.ajax({
                type: 'POST',
                url: wptopgem.ajaxurl,
                data: {
                    action: 'topupgame',
                    nonce: wptopgem.nonce,
                    formdata: formData,
                },
                success: function(response) {
                    // Menangani respons dari server jika sukses
                    $form.removeClass('placeholder bg-transparent w-100');
                    $form.trigger("reset");
                    $modal.html(response);
                },
                error: function() {
                    // Menangani respons dari server jika terjadi kesalahan
                    $form.removeClass('placeholder bg-transparent w-100');
                    $form.prepend('<div class="form-alert-msg alert alert-danger">Terjadi kesalahan, silahkan coba lagi</div>');
                    console.log(response);
                }
            });
        });
    });

    $(document).on('click','#formOrderGame .btn-promogame', function(){
        var kode    = $('#kode_promo').val();
        var nominal = $('input[name="nominal"]:checked').val();
        $('#formOrderGame .card-promo .card-body .alert').remove();
        $('#formOrderGame .card-promo .card-body .btnhapuspromo').remove();
        if(kode && nominal){
            $('#formOrderGame .btn-promogame').html('Loading...');
            $.ajax({
                url: wptopgem.ajaxurl,
                method: 'POST',
                data: {
                    action: 'submitkodepromogame',
                    kode: kode,
                    nominal: nominal
                },
                success: function(response) {
                    $('#formOrderGame .card-promo .card-body .alert').remove();
                    $('#formOrderGame #potongan').val(response.potongan);
                    $('#formOrderGame .btn-promogame').html('Gunakan');
                    if(response.success == 1){
                        $('#formOrderGame .card-promo .card-body').append('<div class="alert alert-success mt-2 alert-dismissible fade show">'+response.message+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        $('#formOrderGame .card-promo .card-body .input-kodepromo').append('<span class="btnhapuspromo btn btn-danger position-absolute top-0 end-0" title="Hapus Promo">X</span>');
                    } else {
                        $('#formOrderGame .card-promo .card-body').append('<div class="alert alert-warning mt-2 alert-dismissible fade show">'+response.message+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                }
            });
            
        } else {
            $('#formOrderGame .card-promo .card-body').append('<div class="alert alert-warning mt-2 alert-dismissible fade show">Masukkan Kode dan Pilih Nominal !<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        }
    });

    function hapusKodePromo(){
        $('#formOrderGame .card-promo .card-body .alert').remove();
        $('#formOrderGame #potongan').val(0);
        $('#formOrderGame #kode_promo').val('');
        $('#formOrderGame .btn-promogame').html('Gunakan');
        $('#formOrderGame .card-promo .card-body .btnhapuspromo').remove(); 
    }
    $(document).on('click','#formOrderGame .btnhapuspromo', function(){
        hapusKodePromo();
    });
    $(document).on('change','#formOrderGame input[name="nominal"]', function(){
        hapusKodePromo();
    });

});