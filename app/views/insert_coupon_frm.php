<div class="container-fluid mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-8 col-10">
            <div class="card loginCard p-4">

                <div class="row justify-content-center">
                    <div class="col-8">
                        <form action="?ct=coupon&mt=new_coupon_submit" method="post" novalidate>   
                            <h1 class="text-center text-white">Registrar Cupom</h1>
                        
                            <label class="form-label">Código: </label>
                            <input class="form-control" name="code" id="code" type="number" size="20" maxlength="100">

                            <label class="form-label">CPF: </label>
                            <input class="form-control" name="cpf" id="cpf" type="text" size="20" maxlength="11">
                            
                            <label class="form-label">Valor: </label>
                            <input class="form-control" name="valor" id="valor" type="number" step="0.01"  maxlength="100">
                            
                            <label class="form-label">Loja: </label>
                            <input class="form-control" name="store" id="store" type="text" size="20" maxlength="100">
                            
                            <label class="form-label">Data-Hora da Compra: </label>
                            <input class="form-control" name="date_time" id="date_time" type="datetime-local" size="20" maxlength="100">

                            <label class="form-label">Status: </label>
                            <select class="form-control" name="status" id="status">
                            <option value="1">Ativo</option>
                            <option value="0">Desativado</option>
                            </select>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary-bg btn-secondary px-4">Registrar</button>
                            </div>
                            <?php if(!empty($errors)): ?> 
                                <div class="alert alert-danger p-2 my-2 text-center">
                                    <?php foreach($errors as $error): ?>
                                        <div><?= $error ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif(empty($errors) AND !empty($message)): ?>
                                <div class="alert alert-success p-2 my-2 text-center">
                                        <div><?= $message ?> </div>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>