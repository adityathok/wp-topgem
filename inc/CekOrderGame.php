<?php
namespace WPTopGem;

use \WP_Query;

class CekOrderGame extends OrderGame {

    public function initialize() {
        add_shortcode('wptopgem-cekorder', array($this, 'cekorder'));
        add_action( 'wp_ajax_cekordergame', array($this, 'ajax_cekordergame') );
        add_action( 'wp_ajax_nopriv_cekordergame', array($this, 'ajax_cekordergame') );
    }

    public function cekorder(){
        ob_start();
        ?>
        <div class="wptopgem-cekorder">
            <form id="form-wptopgem-cekorder" action="" method="post">
                <div class="mb-3">
                    <label for="noinvoice" class="form-label">Nomor Invoice Kamu</label>
                    <input type="text" class="form-control" id="noinvoice" name="noinvoice" placeholder="66xxxxxx" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"> <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/> </svg>
                        <span>Cek Transaksi</span>
                    </button>
                </div>
            </form>
            <div class="result"></div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function ajax_cekordergame(){
        parse_str($_POST['formdata'], $formData);
        $invoice = $formData['noinvoice'];
        if($invoice):
            // The Query.
            $the_query = new WP_Query( array(
                'post_type'     => 'ordergame',
                'meta_key'      => 'invoice',
                'meta_value'    => $invoice,
                'meta_compare'  => '=='
            ) );

            // The Loop.
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();

                    $stt = array(
                        'baru'      => 'Pesanan Baru',
                        'lunas'     => 'Lunas',
                        'sukses'    => 'Sukses',
                        'gagal'     => 'Gagal',
                    );
    
                    $status         = get_post_meta( get_the_ID(), 'status', true );
                    $nominal        = get_post_meta( get_the_ID(), 'nominal', true );
                    $nominal        = isset($nominal)&!empty($nominal)?explode("|",$nominal):'';
                    $nilai_nominal  = $nominal?str_replace(".", "", $nominal[1]):0;
                    $nama_nominal   = $nominal?$nominal[0]:0;
                    $pembayaran     = get_post_meta( get_the_ID(), 'metodebayar', true );
                    $potongan       = get_post_meta( get_the_ID(), 'potongan', true );
                    $total_bayar    = get_post_meta( get_the_ID(), 'total_bayar', true );
    
                    echo '<div class="card text-center shadow my-3 text-dark border-2">';
                        echo '<div class="card-header text-bg-dark d-flex align-items-center justify-content-between">';
                            echo '<div class="fw-bold fs-5">'.$invoice.'</div>';
                            echo '<span class="badge bg-primary">'.$stt[$status].'</span>';
                        echo '</div>';
                        echo '<div class="card-body text-start">';
                            echo '<div class="table-responsive">';
                                echo '<table class="table">';
                                    echo '<tbody>';
                                        echo '<tr>';
                                            echo '<td class="fw-bold">Game</td>';
                                            echo '<td>'.get_post_meta(get_the_ID(),'game',true).'</td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                            echo '<td class="fw-bold">Nominal</td>';
                                            echo '<td>';
                                                echo $nama_nominal;
                                            echo '</td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                            echo '<td class="fw-bold">Data Player</td>';
                                            echo '<td>';
                                                $data_player = get_post_meta( get_the_ID(), 'data_player', true );
                                                if($data_player):
                                                    echo '<ul class="ps-3">';
                                                    foreach ($data_player as $key => $value) {
                                                        echo '<li>';
                                                            echo $key.' : '.$value;
                                                        echo '</li>';
                                                    }
                                                    echo '</ul>';
                                                endif;
                                            echo '</td>';
                                        echo '</tr>';
    
                                        ///INFO PEMBAYARAN
                                        if(isset($bayarm[$pembayaran])){
                                            $infobayarm = $bayarm[$pembayaran];
                                            echo '<tr>';
                                                echo '<td class="fw-bold">Pembayaran</td>';
                                                echo '<td>';
                                                    echo $infobayarm['logo']?'<img src="'.$infobayarm['logo'].'" width="90" alt="'.$infobayarm['title'].'">':$infobayarm['title'];
                                                echo '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                                echo '<td class="fw-bold">Rekening tujuan</td>';
                                                echo '<td>';
                                                    echo $infobayarm['description'];
                                                echo '</td>';
                                            echo '</tr>';
                                        } else {
                                            $mbayar = isset($pembayaran)&!empty($pembayaran)?explode("|",$pembayaran):'';
                                            echo '<tr>';
                                                echo '<td class="fw-bold">Pembayaran</td>';
                                                echo '<td>';
                                                    echo $mbayar[0];
                                                echo '</td>';
                                            echo '</tr>';
                                        }
    
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                            echo '<div class="row">';
                                echo '<div class="col-md-4 col-xl-5">';
                                    echo '<div class="px-2 fw-bold">TAGIHAN</div>';
                                echo '</div>';
                                echo '<div class="col-md-8 col-xl-7">';
                                    echo '<div class="table-responsive">';
                                        echo '<table class="table table-borderless">';
                                            echo '<tbody>';
                                                echo '<tr>';
                                                    echo '<td>Harga</td>';
                                                    echo '<td>';
                                                        echo 'Rp '.number_format($nilai_nominal,0,',','.');
                                                    echo '</td>';
                                                echo '</tr>'; 
                                                echo '<tr>';
                                                    echo '<td>Potongan</td>';
                                                    echo '<td>';
                                                        echo 'Rp '.number_format($potongan,0,',','.');
                                                    echo '</td>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                    echo '<td class="fw-bold">Total harus dibayar</td>';
                                                    echo '<td class="fw-bold">';
                                                        echo 'Rp '.number_format($total_bayar,0,',','.');
                                                    echo '</td>';
                                                echo '</tr>';
                                            echo '</tbody>';
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

                }
            } else {
                echo '<div class="alert alert-danger">Data Transaksi tidak ditemukan</div>';
            }
            // Restore original Post Data.
            wp_reset_postdata();
        endif;

        wp_die();
    }
}

// Inisialisasi class CekOrderGame
$CekOrderGame = new CekOrderGame();
$CekOrderGame->initialize();