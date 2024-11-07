<!-- Page Header Start -->
<div class="container-fluid page-header-2 py-5 mb-5 wow animate__animated animate__fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5 mt-4">
        <h1 class="display-2 text-white mb-3 animated slideInDown">Contáctenos</h1>
    </div>
</div>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto wow animate__animated animate__fadeIn" data-wow-delay="0.1s"
            style="max-width: 600px;">
            <h1 class="display-6 mb-3">¿Tiene alguna duda? Contáctenos</h1>
            <!-- <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tellus augue, iaculis id elit eget, ultrices pulvinar tortor.</p> -->
        </div>
        <div class="row contact-info position-relative g-0 mb-5">
            <div class="col-lg-6">
                <a href="tel:+50223035400" class="d-flex justify-content-lg-center text-decoration-none bg-primary p-4">
                    <div class="icon-box-light flex-shrink-0">
                        <i class="bi bi-phone text-dark"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="text-white">Llamenos</h5>
                        <h2 class="text-white mb-0">2303 5400</h2>
                    </div>
                </a>
            </div>
            <div class="col-lg-6">
                <a href="mailto:industriamilitar@gmail.com"
                    class="d-flex justify-content-lg-center text-decoration-none bg-primary p-4">
                    <div class="icon-box-light flex-shrink-0">
                        <i class="bi bi-envelope text-dark"></i>
                    </div>
                    <div class="ms-3 " style="overflow: hidden;">
                        <h5 class="text-white">Correo</h5>
                        <h2 class="text-white mb-0">industriamilitar@gmail.com</h2>
                    </div>
                </a>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-lg-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.1s">
                <form id="formContacto" method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Su Nombre">
                                <label for="name">Su Nombre</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Su Email">
                                <label for="email">Su Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Asunto">
                                <label for="subject">Asunto</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Introduzca su mensaje aqui" name="message"
                                    id="message" style="height: 200px"></textarea>
                                <label for="message">Mensaje</label>
                            </div>
                        </div>
                        <div class="row justify-content-center text-center mt-3 p-auto">
                            <div id="captcha" class="col">
                                <div class="g-recaptcha w-100" data-sitekey="6Lc8UrYkAAAAAM6qyRHb6WLTHH2Q7-TkLlrhFoBP"
                                    data-size="normal" data-callback="verificar" data-expired-callback="expirado"
                                    data-error-callback="error"></div>

                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary py-3 px-5" type="submit" id="btnEnviar">Enviar <span
                                    id="spanLoader" class="spinner-border spinner-border-sm ms-2"
                                    aria-hidden="true"></span></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                <iframe src="https://embed.waze.com/es/iframe?zoom=20&lat=14.615801&lon=-90.506268&pin=1&desc=1"
                    class="w-100 h-100"></iframe>
                <a class="btn btn-info w-100 text-white"
                    href="https://www.waze.com/ul?ll=14.613177%2C-90.512499&z=8&navigate=yes"><i
                        class="fas fa-location-arrow me-2"></i> Conducir hacia esa dirección</a>
            </div>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="./build/js/pages/contacto.js"></script>