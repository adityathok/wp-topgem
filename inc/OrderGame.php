<?php
namespace WPTopGem;

class OrderGame extends ItemGame {

    public $id;

    public function __construct($post_id) {
        $this->id = $post_id;
    }
    
    public function form() {
        ?>

        <div class="card pt-2 mt-3 mb-4">
            <div class="position-absolute top-0 start-0 translate-middle-y px-3 text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-1-circle-fill" viewBox="0 0 16 16"> <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M9.283 4.002H7.971L6.072 5.385v1.271l1.834-1.318h.065V12h1.312z"/> </svg>
            </div>
            <div class="card-body">
                <div class="card-title fs-5 mb-3 fw-bold">
                    Data Player
                </div> 
                <?php $this->form_dataplayer(); ?>         
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title fs-5 mb-3 fw-bold">
                    Pilih Nominal
                </div> 
                <?php $this->form_datanominal(); ?>         
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title fs-5 mb-3 fw-bold">
                    Kode Promo
                </div> 
                <div class="form-floating">
                    <input type="text" class="form-control" id="kodepromo" name="Kode Promo" placeholder="567">
                    <label for="kodepromo">Masukan Kode Promo</label>
                </div>       
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title fs-5 mb-3 fw-bold">
                    Nomor Whatsapp
                </div> 
                <div class="form-floating">
                    <input type="text" class="form-control" id="nowhatsapp" name="No Whatsapp" placeholder="08000000">
                    <label for="nowhatsapp">Masukan Nomor Whatsapp</label>
                </div>       
            </div>
        </div>

        <div class="text-end">
            <a href="#" class="btn px-4 btn-success rounded-pill icon-link justify-content-center icon-link-hover">
                Proses Pesanan 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/> </svg>
            </a>
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
                    <?php $title = strpos($data,'|') !== false?explode("|",$data)[0]:$data;?>
                    <?php $price = strpos($data,'|') !== false?explode("|",$data)[1]:$data;?>
                    <div class="col-md-6 pb-3">
                    
                    <input type="radio" class="btn-check" name="Nominal" id="nominal-<?php echo $n;?>" value="<?php echo $data;?>" autocomplete="off" required>
                    <label class="btn btn-outline-primary d-block text-start" for="nominal-<?php echo $n;?>">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold" style="font-size: 15px;"><?php echo $title;?></div>
                                <small class="fst-italic"><?php echo $price;?></small>
                            </div>
                            <div class="col-lg-3 col-2 m-auto text-end">
                                <?php if($icon_nominal): ?>
                                    <img src="<?php echo $icon_nominal;?>" class="img-fluid w-100" loading="lazy"/>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16"> <path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.6l3-4zm11.386 3.785-1.806-2.41-.776 2.413 2.582-.003zm-3.633.004.961-2.989H4.186l.963 2.995 5.704-.006zM5.47 5.495 8 13.366l2.532-7.876-5.062.005zm-1.371-.999-.78-2.422-1.818 2.425 2.598-.003zM1.499 5.5l5.113 6.817-2.192-6.82L1.5 5.5zm7.889 6.817 5.123-6.83-2.928.002-2.195 6.828z"/> </svg>
                                <?php endif; ?>
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
        $info_data_player   = get_post_meta($this->id,'info_data_player',true);
        if($data_player) {
        ?>
            <div class="row">
                <?php foreach( $data_player as $n => $data): ?>
                        <?php $title = strpos($data,'|') !== false?explode("|",$data)[0]:$data;?>
                        <?php $plchd = strpos($data,'|') !== false?explode("|",$data)[1]:$data;?>
                        <div class="col-md-6 pb-2">
                            <label for="id-<?php echo $n;?>" class="form-label"><?php echo $title;?></label>
                            <input type="text" class="form-control" name="<?php echo $title;?>" id="id-<?php echo $n;?>" placeholder="<?php echo $plchd;?>" required>
                        </div>
                <?php endforeach; ?>
            </div>

            <?php if($info_data_player): ?>
                <div class="text-end mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#infoPlayerModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/> <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/> </svg> 
                        Info
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="infoPlayerModal" tabindex="-1" aria-labelledby="infoPlayerModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">                                
                                <img src="<?php echo $info_data_player;?>" class="img-fluid w-100" loading="lazy"/>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php
        }
    }

}