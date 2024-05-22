<?php
namespace WPTopGem;

use \WP_Query;

class OrderGame {

    public $post_type = 'ordergame';

    public function initialize() {
        add_action('init', array($this, 'register_post_type'));
        add_action( 'cmb2_admin_init', array($this, 'register_cmb2') );
        add_action( 'wp_ajax_topupgame', array($this, 'topupgame') );
        add_action( 'wp_ajax_nopriv_topupgame', array($this, 'topupgame') );
    }

    public function register_post_type() {
        $args = array(
         'labels' => array(
             'name'              => 'Order Game',
             'singular_name'     => $this->post_type,
             'add_new'           => __( 'Tambah Orderan', 'velocity-gameol' ),
             'add_new_item'      => __( 'Tambah Orderan', 'velocity-gameol' ),
         ),
         'public'                => true,
         'has_archive'           => false,
         'show_in_rest'          => false,
         'publicly_queryable'    => false,
         'show_in_menu'          => 'edit.php?post_type=itemgame',
         'supports'              => array('title'),
         'menu_icon'             => 'dashicons-games',
        );
        register_post_type($this->post_type, $args);
    }

    public function register_cmb2() {
        $cmb = new_cmb2_box( array(
            'id'           => $this->post_type.'_cmb2_metabox',
            'title'        => 'Detail Pesanan',
            'priority'     => 'high',
            'object_types' => array( $this->post_type ),
        ));
        $cmb->add_field( array(
            'name'      => 'Nomor Invoice',
            'desc'      => '',
            'type'      => 'text',
            'id'        => 'invoice',
            'default'   => $this->generate_invoice(),
        ));
        $cmb->add_field( array(
            'name'      => 'Status',
            'desc'      => '',
            'type'      => 'select',
            'id'        => 'status',
            'column'    => true,
            'options'   => array(
                'baru'      => __( 'Pesanan Baru', 'cmb2' ),
                'lunas'     => __( 'Lunas', 'cmb2' ),
                'sukses'    => __( 'Sukses', 'cmb2' ),
                'gagal'     => __( 'Gagal', 'cmb2' ),
            ),
        ));
        $cmb->add_field( array(
            'name'          => 'Game',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'game',
            'column'        => true,
        ));
        $cmb->add_field( array(
            'name'          => 'ID Game',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'id_game',
        ));
        $cmb->add_field( array(
            'name'          => 'Data Player',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'player',
            'repeatable'    => true, 
        ));
        $cmb->add_field( array(
            'name'          => 'Nominal',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'nominal',
            'column'        => true,
        ));
        $cmb->add_field( array(
            'name'          => 'Kode Promo',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'kode_promo',
        ));
        $cmb->add_field( array(
            'name'          => 'Potongan',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'potongan',
        ));
        $cmb->add_field( array(
            'name'          => 'Total Nominal',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'total_nominal',
        ));
        $cmb->add_field( array(
            'name'          => 'Metode Pembayaran',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'metodebayar',
        ));
        $cmb->add_field( array(
            'name'          => 'Biaya Metode Pembayaran',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'total_metodebayar',
        ));
        $cmb->add_field( array(
            'name'          => 'Total Bayar',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'total_bayar',
            'column'        => true,
        ));
        $cmb->add_field( array(
            'name'          => 'No. WhatsApp',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'nowa',
            'column'        => true,
        ));
        $cmb->add_field( array(
            'name'          => 'Email',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'email',
        ));
    }

    public function generate_invoice() {
        return strtoupper(bin2hex(random_bytes(6)));
    }

    public function status() {
        $status = array(
            'baru'      => 'Pesanan Baru',
            'lunas'     => 'Lunas',
            'sukses'    => 'Sukses',
            'gagal'     => 'Gagal',
        );
        return $status;
    }
    
    public function topupgame() {
        
        parse_str($_POST['formdata'], $formData);

        // Check for nonce security      
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) || !wp_verify_nonce( $formData['ordergame-nonce'], 'ordergame-action' ) ) {
            return false;
        }

        $invoice = $this->generate_invoice();

        //print_r($formData);

        // Create post object
        $new_post = array(
            'post_title'    => wp_strip_all_tags( $invoice ),
            'post_type'     => $this->post_type,
            'post_content'  => '',
            'post_status'   => 'publish',
            'meta_input'    => array(
                'status'        => 'baru',
                'invoice'       => $invoice,
            ),
        );

        foreach($formData as $key => $value):
            if ( $key == 'ordergame-nonce' ) { continue; }
            if ( $key == '_wp_http_referer' ) { continue; }
            if ( $key == 'dataplayer' ) { continue; }

            if($key == 'kode_promo' && $formData['potongan'] == 0){
                $value = '';
            }

            $new_post['meta_input'][$key] = $value;
        endforeach;

        //dataplayer 
        $dataplayer = [];           
        foreach($formData['dataplayer'] as $key => $value):
            $dataplayer[] = $key.' : '.$value;
        endforeach;
        $new_post['meta_input']['player']       = $dataplayer;
        $new_post['meta_input']['data_player']  = $formData['dataplayer'];

        //SAVE
        $new_postid = wp_insert_post( $new_post );

        echo '<div class="my-2">';  
        if( !is_wp_error($new_postid) ) {    
            echo '<div class="alert alert-success border-2 text-center w-100 mb-4" style="border-style: dashed;">';
                echo 'KODE INVOICE : <br>';
                echo '<div class="fs-2 fw-bold">'.$invoice.'</div>';
            echo '</div>';
            $this->email($new_postid);
        } else {    
            echo '<div class="alert alert-success border-2 text-center w-100 mb-4" style="border-style: dashed;">';
                echo $new_postid->get_error_message();
            echo '</div>';
        }  
        echo '</div>';    

        wp_die();
    }

    function dataorder($id_order=null){
        if(empty($id_order))
        return false;

        $status         = get_post_meta( $id_order, 'status', true );

        $nominal        = get_post_meta( $id_order, 'nominal', true );
        $setnominal     = isset($nominal)&!empty($nominal)?explode("|",$nominal):'';
        $nilai_nominal  = $setnominal?str_replace(".", "", $setnominal[1]):0;
        $nama_nominal   = $setnominal?$setnominal[0]:0;

        $pembayaran     = get_post_meta( $id_order, 'metodebayar', true );
        $setbayar       = isset($pembayaran)&!empty($pembayaran)?explode("|",$pembayaran):[];

        $potongan       = get_post_meta( $id_order, 'potongan', true );
        $total_bayar    = get_post_meta( $id_order, 'total_bayar', true );
        
        $result = [
            'invoice'       => get_post_meta($id_order,'invoice',true),
            'game_id'       => get_post_meta($id_order,'id_game',true),
            'game'          => get_post_meta($id_order,'game',true),
            'status'        => [
                'value'     => $status,
                'title'     => $status?$this->status()[$status]:'',
            ],
            'nominal'       => [
                'value'     => $nominal,
                'nilai'     => $nilai_nominal,
                'title'     => $nama_nominal,
            ],
            'bayar'         => [
                'value'     => $pembayaran,
                'title'     => $setbayar?$setbayar[0]:'',
                'biaya'     => $setbayar?$setbayar[1]:'',
            ],
            'potongan'      => $potongan,
            'total_bayar'   => $total_bayar,
        ];
        
        $data_player = get_post_meta( get_the_ID(), 'data_player', true );
        if($data_player):
            foreach ($data_player as $key => $value) {
                $result['data_player'][$key] = $value;
            }
        endif;

        return $result;

    }
    
    function email($id_order){
        $dataopt = get_option( 'itemgame_option' );
        $admin_email = $dataopt['email_admin']??get_bloginfo('admin_email');
        $admin_templ = $dataopt['email_admin_template']??'Pesanan Baru dengan kode Invoice : <strong>{{invoice}}</strong> <br> Rincian Pesanan : <br> <strong>{{tabel-pesanan}}</strong> <br>';

        $order = $this->dataorder($id_order);

        ob_start();
        ?>
        <div style="background-color:#f4f4f4;padding: 1rem;">
            <div style="background-color:#ffffff;padding: 1rem;max-width:300px;margin:0 auto;">
            <?php echo $admin_templ; ?>
            </div>
        </div>
        <?php
        $message = ob_get_clean();

        //kirim email ke admin
        $admin_subject = 'Pesanan Baru untuk '.$order['game'];
        $admin_send = $this->send_html_email($admin_email, $admin_subject, $message);
    }

    function send_html_email($to, $subject, $message) {
        // $headers .= "From: Your Name <your_email@example.com>\r\n";
        // $headers .= "Reply-To: your_email@example.com\r\n";
        $headers = "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";    
        wp_mail($to, $subject, $message, $headers);
    }

}

// Inisialisasi class OrderGame
$OrderGame = new OrderGame();
$OrderGame->initialize();