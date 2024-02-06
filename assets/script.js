jQuery(function($){
    $(document).ready(function() {
        $('#formOrderGame').submit(function(event) { 
            // Menghentikan pengiriman form bawaan browser
            event.preventDefault();

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
                    console.log(response);
                    alert('Form berhasil dikirim!');
                },
                error: function() {
                    // Menangani respons dari server jika terjadi kesalahan
                    alert('Terjadi kesalahan saat mengirim form!');
                }
            });
        });
    });
});