<h1 class="text-center">Inicio de sesión</h1>
<p class="text-center lead">Bienvenido al administrador de la página</p>
<div class="container py-4">
    <div class="row justify-content-center align-items-center">
        <div class="card shadow col-lg-5 col-md-8 col-12">
            <div class="card-body p-4">
                <h5 class="card-title mb-2">Ingrese sus credenciales</h5>
                <form id="formLogin" autocomplete="off" novalidate>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-sm" name="username" id="username"
                                    placeholder="Nombre de usuario" autocomplete="off" required>
                                <label for="floatingInput" class="text-secondary">Nombre de usuario</label>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control form-control-sm" name="password"
                                    id="password" placeholder="password" autocomplete="off" required>
                                <label for="floatingInput" class="text-secondary">Contraseña</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-lg w-100 btn-primary" id="btnLogin"><span
                                    class="spinner-border spinner-border-sm me-2 d-none" id="spanLoader"></span>Iniciar
                                Sesión</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<script src="<?= asset('/build/js/auth/login.js') ?>"></script>