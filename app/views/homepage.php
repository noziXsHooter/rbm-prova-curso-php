<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        
        <div class="d-flex flex-row flex-wrap justify-content-center">
            
            <!-- registro de cupons -->
            <a href="?ct=coupon&mt=coupons_add_new_frm" class="unlink m-2">
                <div class="home-option p-5 text-center h-5">
                    <h3 class="mb-3"><i class="fa-solid fa-file-invoice"></i></h3>
                    <h5>Registro de Cupons</h5>
                </div>
            </a>
            
            <!-- lista de clientes -->
            <?php if($_SESSION['user']->profile == 'admin'): ?>
            <a href="?ct=user&mt=list_clients" class="unlink m-2">
                <div class="home-option p-5 text-center">
                    <h3 class="mb-3"><i class="fa-solid fa-users"></i></h3>
                    <h5>Clientes</h5>
                </div>
            </a>
            <?php endif;?>

            <!-- Meus Cupons -->
            <a href="?ct=coupon&mt=my_coupons" class="unlink m-2">
                <div class="home-option p-5 text-center">
                    <h3 class="mb-3"><i class="fa-solid fa-upload"></i></h3>
                    <h5>Meus Cupons</h5>
                </div>
            </a>

            <!-- lista de cupons ativos -->
            <?php if($_SESSION['user']->profile == 'admin'): ?>
            <a href="?ct=coupon&mt=list_active_coupons" class="unlink m-2">
                <div class="home-option p-5 text-center">
                    <h3 class="mb-3"><i class="fa-solid fa-file-invoice"></i></h3>
                    <h5>Cupons Ativos</h5>
                </div>
            </a>
            <?php endif;?>

            <!-- lista de números da sorte -->
            <?php if($_SESSION['user']->profile == 'admin'): ?>
            <a href="?ct=lucknumber&mt=luck_numbers" class="unlink m-2">
                <div class="home-option p-5 text-center">
                    <h3 class="mb-3"><i class="fa-solid fa-clover"></i></h3>
                    <h5>Números da Sorte</h5>
                </div>
            </a>
            <?php endif;?>

            <!-- lista de números da sorte (Clientes) -->
            <a href="?ct=lucknumber&mt=client_luck_numbers" class="unlink m-2">
                <div class="home-option p-5 text-center">
                    <h3 class="mb-3"><i class="fa-solid fa-clover"></i></h3>
                    <h5>Meus Números da Sorte</h5>
                </div>
            </a>

            <!-- sorteio(clientes) -->
            <a href="?ct=sweepstake&mt=clients_index" class="unlink m-2">
                <div class="home-option p-5 text-center">
                    <h3 class="mb-3"><i class="fa-solid fa-chart-column"></i></h3>
                    <h5>Sorteio</h5>
                </div>
            </a>

            <!-- sorteio administração-->
            <?php if($_SESSION['user']->profile == 'admin'): ?>
            <a href="?ct=sweepstake&mt=index" class="unlink m-2">
                <div class="home-option p-5 text-center">
                    <h3 class="mb-3"><i class="fa-solid fa-chart-column"></i></h3>
                    <h5>Sorteio (Administração)</h5>
                </div>
            </a>
            <?php endif;?>
            <!-- gestão de utilizadores -->
<!--             <a href="#" class="unlink m-2">
                <div class="home-option p-5 text-center">
                    <h3 class="mb-3"><i class="fa-solid fa-user-gear"></i></h3>
                    <h5>Gestão de utilizadores</h5>
                </div>
            </a> -->

        </div>

    </div>
</div>