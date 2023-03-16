<div class="container-fluid mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-8 col-10 my-3">
            <div class="d-flex text-center justify-content-center my-2">
                <h2 class="text-white"><strong>Informações do Sorteio</strong></h2>
            </div>
            <div class="card loginCard p-4">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-sm-4 justify-content-center text-center">
                            <label class="text-white" for=""><strong> Estado: </strong></label>
                            <?php if($sweepstake_status): ?>
                                <label class="btn btn-success w-full my-2">Realizado </label>
                            <?php else: ?>
                                <label class="btn btn-danger w-full my-2"> Não Realizado </label>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if(!empty($sweepstake_winner)): ?>
                        <div class="alert alert-success p-2 my-2 text-center">

                            <div><strong>Nome: </strong><?= $sweepstake_winner->name ?></div>
                            <div><strong>Número da Sorte: </strong><?= $sweepstake_winner->hash ?></div>
                            <div><strong>Data do Sorteio: </strong><?= $sweepstake_winner->created_at ?></div>
                    </div>   
                    <?php endif;?> 
  
                </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
    </div>
</div>