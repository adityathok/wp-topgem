jQuery(function($){
    $(document).ready(function() {
        $('#formOrderGame').submit(function(event) { 
            // Menghentikan pengiriman form bawaan browser
            event.preventDefault();

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
                    action: 'formordergame',
                    nonce: wptopgem.nonce,
                    form: formData,
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
});