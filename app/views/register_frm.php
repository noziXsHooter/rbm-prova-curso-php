<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-8 col-10">
            <div class="d-flex text-center justify-content-center mb-4">
                <h2 class="text-white"><strong><?= APP_NAME ?></strong></h2>
            </div>
            <div class="card loginCard p-4">

                <div class="d-flex text-center justify-content-center my-4">
                    <h2 class="text-white"><strong>Registrar</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-8">
                        <form action="?ct=main&mt=register_submit" method="post" novalidate>
                            <label class="form-label">Nome: </label>
                            <input class="form-control" name="name" id="name" type="text" size="20" maxlength="100">

                            <label class="form-label">Gênero: </label>
                            <select class="form-control" name="gender" id="gender">
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            </select>
<!--                             <label class="form-label">Gênero: </label>
                            <input class="form-control" name="sex" id="sex" type="number" step="0.01"  maxlength="100"> -->

                            <label class="form-label">Nascimento: </label>
                            <input class="form-control" name="born_in" id="born_in" type="date" size="20" maxlength="100">
                            
                            <label class="form-label">CPF: </label>
                            <input class="form-control" name="cpf" id="cpf" type="text" size="20" maxlength="11">
                                                   
                            <label class="form-label">Senha: </label>
                            <input class="form-control" name="password" id="password" type="password" size="20" maxlength="100">
                            
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary-bg btn-secondary px-4">Registrar</button>
                            </div>

                            <div class="mt-3 text-center">
                                <a class="text-info" href="?ct=main&mt=login_frm">Login</a>
                            </div>

<!--                             <div class="mb-3 text-center">
                                <a class="text-info" href="#">Esqueci minha da senha!</a>
                            </div> -->
                          
                            <?php if(!empty($validation_errors)): ?> 
                                <div class="mt-2 alert alert-danger p-2 text-center">
                                    <?php foreach($validation_errors as $error): ?>
                                        <div><?= $error ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($register_success)): ?> 
                                <div class="mt-2 alert alert-success p-2 text-center">
                                    <div><?= $register_success ?></div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>