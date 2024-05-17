<?php
namespace WPTopGem;

class FormOrderGame extends OrderGame
{
    public $id;

    public function __construct($post_id=null) {
        $this->id = $post_id;
    }
    
    public function form() {
        ?>
        <div class="form-order-game">
            <form id="formOrderGame" action="" method="post">

                <div class="card mb-4 rounded-4 shadow-sm">
                    <div class="card-header py-3 bg-transparent border-0 d-flex align-items-center">
                        <span class="text-bg-primary rounded-circle px-3 py-2 me-3 fs-6 fw-bold">1</span>
                        <h3 class="fs-5 m-0">Data Akun</h3>
                    </div>
                    <div class="card-body">
                        <?php $this->form_dataplayer(); ?>         
                    </div>
                </div>

                <div class="card mb-4 rounded-4 shadow-sm">
                    <div class="card-header py-3 bg-transparent border-0 d-flex align-items-center">
                        <span class="text-bg-primary rounded-circle px-3 py-2 me-3 fs-6 fw-bold">2</span>
                        <h3 class="fs-5 m-0">Pilih Nominal</h3>
                    </div>
                    <div class="card-body">
                        <?php $this->form_datanominal(); ?>         
                    </div>
                </div>

                <div class="card card-promo mb-4 rounded-4 shadow-sm">
                    <div class="card-header py-3 bg-transparent border-0 d-flex align-items-center">
                        <span class="text-bg-primary rounded-circle px-3 py-2 me-3 fs-6 fw-bold">3</span>
                        <h3 class="fs-5 m-0">Kode Promo</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-8 col-md-9 col-xl-10">
                                <div class="input-kodepromo form-control p-0 position-relative" style="border-style:dashed;">
                                    <input type="text" class="form-control border-0" id="kode_promo" name="kode_promo" placeholder="Ketik kode promo jika ada">
                                </div>
                            </div>
                            <div class="col-4 col-md-3 col-xl-2 text-end">
                                <span class="btn btn-primary w-100 text-truncate btn-promogame">Gunakan</span>
                            </div>
                        </div>
                        <input type="hidden" name="potongan" id="potongan" value="0">        
                    </div>
                </div>

                <div class="card mb-4 rounded-4 shadow-sm">
                    <div class="card-header py-3 bg-transparent border-0 d-flex align-items-center">
                        <span class="text-bg-primary rounded-circle px-3 py-2 me-3 fs-6 fw-bold">4</span>
                        <h3 class="fs-5 m-0">Metode Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        <?php $this->form_datapembayaran(); ?>         
                    </div>
                </div>

                <div class="card mb-4 rounded-4 shadow-sm">
                    <div class="card-header py-3 bg-transparent border-0 d-flex align-items-center">
                        <span class="text-bg-primary rounded-circle px-3 py-2 me-3 fs-6 fw-bold">5</span>
                        <h3 class="fs-5 m-0">Info Kontak</h3>
                    </div>
                    <div class="card-body">                      
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="notelepon" name="nowa" placeholder="08000000">
                            <label for="nowa">Nomor Whatsapp</label>
                        </div>                  
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="email@email.com">
                            <label for="email">Email</label>
                            <div id="emailHelp" class="form-text">Opsional, Jika anda ingin mendapatkan bukti transaksi.</div>
                        </div>       
                    </div>
                </div>

                <div class="card mb-4 rounded-4 shadow-sm">
                    <div class="card-header py-3 bg-transparent border-0 d-flex align-items-center">
                        <span class="text-bg-primary rounded-circle px-3 py-2 me-3 fs-6 fw-bold">6</span>
                        <h3 class="fs-5 m-0">Rincian</h3>
                    </div>
                    <div class="card-body card-rincian">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>Total dibayar</div>
                            <div class="fs-4 ps-2 fw-bold text-end totalbayar-text">Rp 0</div>
                        </div>
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill icon-link justify-content-center icon-link-hover shadow">
                        Proses Pesanan 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/> </svg>
                    </button>
                </div>

                <input type="hidden" value="<?php echo get_the_title($this->id); ?>" name="game">
                <input type="hidden" value="<?php echo $this->id; ?>" name="id_game">
                <input type="hidden" value="0" name="total_metodebayar" id="totalmetodebayar">
                <input type="hidden" value="0" name="total_nominal" id="totalnominal">
                <input type="hidden" value="0" name="total_bayar" id="totalbayar"> 
                <?php wp_nonce_field( 'ordergame-action', 'ordergame-nonce' ); ?>

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
                    <?php
                    $title = $data['title'];
                    $price = $data['harga'];
                    $icon  = isset($data['icon'])&&$data['icon']?$data['icon']:$icon_nominal;
                    ?>
                    <div class="col-6 col-md-4 col-xl-3 pb-3 wptopgem-btn-nominal">
                        <input type="radio" class="btn-check" name="nominal" id="nominal-<?php echo $n;?>" value="<?php echo $title.'|'.$price;?>" autocomplete="off" required>
                        <label class="btn btn-outline-dark rounded-4 h-100 d-flex justify-content-center align-items-center" for="nominal-<?php echo $n;?>">
                                                   
                            <div>                
                                <?php if($icon): ?>
                                    <div>
                                        <img src="<?php echo $icon;?>" class="img-fluid" loading="lazy" width="45"/>
                                    </div>                                    
                                <?php endif; ?>                        
                                <div>
                                    <div class="fw-bold" style="font-size: 15px;"><?php echo $title;?></div>
                                    <small class="fst-italic"><?php echo wptopgem_rupiah($price);?></small>
                                </div>
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
            <div class="row g-2">
                <?php foreach( $data_pem as $n => $data): ?>
                    <?php
                        $nama   = $data['nama'];
                        $biaya  = $data['biaya']?$data['biaya']:0;
                        $logo   = $data['logo'];
                    ?>
                    <div class="col-12 wptopgem-btn-bayar" data-biaya="<?php echo $biaya;?>">
                        <input type="radio" class="btn-check" name="metodebayar" id="metodebayar-<?php echo $n;?>" value="<?php echo $nama.'|'.$biaya;?>" autocomplete="off" required>
                        <label class="btn btn-outline-primary p-3 d-flex justify-content-between align-items-center" for="metodebayar-<?php echo $n;?>">

                            <div>
                                <?php if($logo): ?>
                                    <img src="<?php echo $logo;?>" class="img-fluid bg-white" loading="lazy" width="100"/>                                
                                <?php else: ?>              
                                    <div class="fw-bold"><?php echo $nama;?></div>                
                                <?php endif; ?> 
                            </div>                           
                            <div>
                                <small class="fst-italic"><?php echo wptopgem_rupiah($biaya);?></small>
                            </div>

                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        }
    }

}