<?php
namespace WPTopGem;

class OrderGame extends ItemGame {

    public $id;

    public function __construct($post_id=null) {
        $this->id = $post_id;
    }

    public function save($data=null){
                

    }
    
    public function form() {
        ?>
        <div class="form-order-game">
            <form id="formOrderGame" action="" method="post">

                <div class="card overflow-hidden mb-3 mb-md-4 shadow">
                    <div class="card-header p-0">
                        <span class="btn btn-primary rounded-0">1</span>
                        <span class="p-2 fw-bold">Data Pengguna</span>
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
                    <button type="submit" data-bs-toggle="modal" data-bs-target="#responOrderModal" class="btn btn-lg px-4 btn-success rounded-pill icon-link justify-content-center icon-link-hover shadow">
                        Proses Pesanan 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/> </svg>
                    </button>
                </div>

            </form>
                
            <!-- Modal -->
            <div class="modal fade" id="responOrderModal" tabindex="-1" aria-labelledby="responOrderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            ...
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
        $data_player        = get_post_meta($this->id,'data_player',true);
        $info_dataplayer    = get_post_meta($this->id,'info_data_player',true);
        $imginfo_dataplayer = get_post_meta($this->id,'img_info_data_player',true);
        if($data_player) {
        ?>
            <div class="row">
                <?php foreach( $data_player as $n => $data): ?>
                    <?php                     
                        $title = strpos($data,'|') !== false?explode("|",$data)[0]:$data;
                        $plchd = strpos($data,'|') !== false?explode("|",$data)[1]:$data;
                    ?>
                    <div class="col-md-6 pb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="dp-<?php echo $n;?>" name="dataplayer[<?php echo $title;?>]" placeholder="<?php echo $plchd;?>" required>
                            <label for="dp-<?php echo $n;?>"><?php echo $plchd;?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if($info_dataplayer): ?>
                <div class="fst-italic small">
                    <?php echo $info_dataplayer;?>
                </div>
            <?php endif; ?>

            <?php if($imginfo_dataplayer): ?>
                <!-- Button trigger modal -->
                <div class="text-end">
                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#imginfoModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247m2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="imginfoModal" tabindex="-1" aria-labelledby="imginfoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="<?php echo $imginfo_dataplayer;?>" alt="" class="w-100" loading="lazy"/>
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