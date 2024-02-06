<?php
namespace WPTopGem;

class OrderGame extends ItemGame {

    public $id;

    public function __construct($post_id) {
        $this->id = $post_id;
    }

    public function initialize() {
    //     add_action('wp_ajax_nopriv_formordergame', array($this, 'ajax'));
    //     add_action('wp_ajax_formordergame', array($this, 'ajax'));
    }

    // public function ajax(){
    //     // Check for nonce security      
    //     if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
    //         return false;
    //     }
        
    //     // Mengurai data yang di-serialize
    //     parse_str($_POST['form'], $data);

    //     print_r($data);

    // }
    
    public function form() {
        ?>
        <form id="formOrderGame" action="" method="post">

            <div class="card my-4 border-dark shadow-sm">
                <div class="card-header text-bg-dark d-flex align-items-center">
                    <span class="text-bg-light rounded-circle px-3 py-2 me-3 fs-6 fw-bold">1</span>
                    <h5 class="m-0">Data Pengguna</h5>
                </div>
                <div class="card-body">
                    <?php $this->form_dataplayer(); ?>         
                </div>
            </div>

            <div class="card my-4 border-dark shadow-sm">
                <div class="card-header text-bg-dark d-flex align-items-center">
                    <span class="text-bg-light rounded-circle px-3 py-2 me-3 fs-6 fw-bold">2</span>
                    <h5 class="m-0">Pilih Nominal</h5>
                </div>
                <div class="card-body">
                    <?php $this->form_datanominal(); ?>         
                </div>
            </div>

            <div class="card my-4 border-dark shadow-sm">
                <div class="card-header text-bg-dark d-flex align-items-center">
                    <span class="text-bg-light rounded-circle px-3 py-2 me-3 fs-6 fw-bold">3</span>
                    <h5 class="m-0">Metode Pembayaran</h5>
                </div>
                <div class="card-body">
                    <?php $this->form_datapembayaran(); ?>         
                </div>
            </div>

            <div class="card my-4 border-dark shadow-sm">
                <div class="card-header text-bg-dark d-flex align-items-center">
                    <span class="text-bg-light rounded-circle px-3 py-2 me-3 fs-6 fw-bold">4</span>
                    <h5 class="m-0">Kontak</h5>
                </div>
                <div class="card-body">                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="Email" placeholder="email@email.com">
                        <label for="email">Email</label>
                    </div>                        
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nowhatsapp" name="No_Whatsapp" placeholder="08000000">
                        <label for="nowhatsapp">Nomor Whatsapp</label>
                    </div>     
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-lg px-4 btn-success rounded-pill icon-link justify-content-center icon-link-hover shadow">
                    Proses Pesanan 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/> </svg>
                </button>
            </div>
        </form>

        <?php
    } 
    
    public function form_datanominal() {
        $data_nominal = get_post_meta($this->id,'data_nominal',true);
        $icon_nominal = get_post_meta($this->id,'icon_nominal',true);
        if($data_nominal) {
        ?>
            <div class="row">
                <?php foreach($data_nominal as $n => $data): ?>
                    <?php $title = $data['title'];?>
                    <?php $price = $data['harga'];?>
                    <div class="col-md-6 pb-3">                    
                        <input type="radio" class="btn-check" name="Nominal" id="nominal-<?php echo $n;?>" value="<?php echo $title;?>" autocomplete="off" required>
                        <label class="btn btn-outline-secondary d-block text-start" for="nominal-<?php echo $n;?>">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="fw-bold" style="font-size: 15px;"><?php echo $title;?></div>
                                    <small class="fst-italic"><?php echo $price;?></small>
                                </div>
                                <?php if($icon_nominal): ?>
                                    <div>
                                        <img src="<?php echo $icon_nominal;?>" class="img-fluid" loading="lazy" width="60"/>
                                    </div>                                    
                                <?php endif; ?>
                            </div>
                        </label>                    
                    </div>
                <?php endforeach; ?>
            </div>  
        <?php 
        }
    }

    public function form_dataplayer() {
        $data_player        = get_post_meta($this->id,'data_pengguna',true);
        $info_data_player   = get_post_meta($this->id,'info_data_pengguna',true);
        if($data_player) {
        ?>
            <div class="row">
                <?php foreach( $data_player as $n => $data): ?>
                    <?php $name = $data?str_replace(" ","_",$data):$data; ?>
                    <div class="col-md-6 pb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="dp-<?php echo $n;?>" name="<?php echo $name;?>" placeholder="<?php echo $data;?>" required>
                            <label for="dp-<?php echo $n;?>"><?php echo $data;?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if($info_data_player): ?>
                <!-- Button trigger modal -->
                <div class="text-end">
                    <button type="button" class="btn btn-primary btn-sm px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#infoModal">
                        Info Pengguna
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="<?php echo $info_data_player;?>" alt="" class="w-100" loading="lazy"/>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php
        }
    }

    public function form_datapembayaran() {
        $data_pem = get_option( 'itemgame_option_pembayaran' );
        $data_pem = isset($data_pem['opsi_bayar'])?$data_pem['opsi_bayar']:array();
        
        if($data_pem) {
            ?>
            <div class="accordion" id="accordionbayar">
                <?php foreach( $data_pem as $n => $data): ?>
                    <div class="accordion-item border rounded mb-2 overflow-hidden">
                        <h2 class="accordion-header">                          
                            <input type="radio" class="w-100 p-3 btn-check" name="Pembayaran" id="pembayaran-<?php echo $n;?>" value="<?php echo $data['nama'].'|'.$data['deskripsi'];?>" autocomplete="off" required>                        
                            <label class="accordion-button btn collapsed text-start overflow-hidden" for="pembayaran-<?php echo $n;?>"  data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $n;?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill me-2" viewBox="0 0 16 16"> <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1"/> </svg>
                                <?php echo $data['nama'];?>
                            </label>
                        </h2>
                        
                        <div id="collapse<?php echo $n;?>" class="accordion-collapse collapse" data-bs-parent="#accordionbayar">
                            <div class="accordion-body">
                                <?php echo $data['deskripsi'];?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        }
    }

}

// Inisialisasi class OrderGame
// $orderGame = new OrderGame();
// $OrderGame->initialize();