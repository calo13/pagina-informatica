const { Carousel } = require("bootstrap");
const { limitarString } = require("../funciones");

const categoriaItems = document.querySelectorAll('.list-group-item.list-group-item-action')

const buscarProductos = async (e) => {
    const item = e.target;
    const categoria = item.dataset.categoria

    categoriaItems.forEach(i => {
        i.classList.remove('active')
        i.disabled = true;
        document.getElementById(`spinner${i.dataset.categoria}`).style.display = 'none'
        if (i.id == item.id) {
            item.classList.add('active')
            document.getElementById(`spinner${item.dataset.categoria}`).style.display = ''
        }
    })

    try {
        const url = `/API/admin/productos/categoria?categoria=${categoria}`
        const headers = new Headers();
        headers.append('X-Requested-With', 'fetch');
        const config = {
            method: 'GET',
            headers,
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { datos, mensaje, codigo, detalle } = data;
        console.log(datos);
        const contenedor = document.getElementById('divProductos');
        contenedor.innerHTML = ''


        // Selecciona el contenedor donde se mostrarán los productos
        const productosContainer = document.getElementById('divProductos');

        if (datos.length > 0) {
            // Recorre los productos para generar las tarjetas
            datos.forEach(producto => {
                const { pro_id, pro_nombre, pro_descripcion, pro_precio, imagenes } = producto;

                // Construye las imágenes para el carrusel
                let carouselItems = '';
                imagenes.forEach((imagen, index) => {
                    const activeClass = index === 0 ? 'active' : ''; // Marca la primera imagen como activa
                    carouselItems += `
                        <div class="carousel-item ${activeClass}">
                            <img src="${imagen}" class="d-block w-100" alt="Imagen del producto">
                        </div>
                    `;
                });

                let tallasBadges = '';
                producto.tallas.forEach(t => {
                    tallasBadges += `<span class="badge rounded-pill text-bg-primary me-1">${t.tal_nombre}</span>`
                })
                let htmlTallas = ''
                if (producto.tallas.length > 0) {
                    htmlTallas = `<p class="card-text mb-0">Tallas disponibles</p>
                                <div class="d-flex" style="overflow:auto">
                                    ${tallasBadges}
                                </div>
                                </div>`
                }

                // Construye la tarjeta con el carrusel dentro
                const productoCard = `
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                    
                        <div id="carouselProducto${pro_id}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                ${carouselItems}
                            </div>
                            <button class="carousel-control-prev" data-bs-target="#carouselProducto${pro_id}" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" data-bs-target="#carouselProducto${pro_id}" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    
                        <div class="card-body">
                            <h5 class="card-title" style="overflow: hidden">${pro_nombre}</h5>
                            <div style="overflow: hidden; max-height: 25px">
                                <p class="card-text">${limitarString(pro_descripcion, 30)}</p>
                            </div>
                            <p class="card-text"><strong>Precio: Q. ${pro_precio}</strong></p>
                            <div class="mb-2" style="height: 80px">
                            ${htmlTallas}
                            <a href="#" class="btn btn-outline-primary w-100">Ver Detalles</a>
                        </div>
                    </div>
                </div>
                `;

                // Agrega la tarjeta al contenedor
                productosContainer.insertAdjacentHTML('beforeend', productoCard);
            });
            iniciarCarouseles()

        } else {
            let html = `
                <div class='col p-5'>
                    <h5 class="text-muted text-center">No se encontraron resultados</h5>
                    <p class="text-muted text-center w-100">Intente con otra categoría</p>
                </div>
            `;
            productosContainer.innerHTML = html
        }

    } catch (error) {
        console.log(error);
    }

    categoriaItems.forEach(i => {

        i.disabled = false;

        document.getElementById(`spinner${i.dataset.categoria}`).style.display = 'none'


    })
}

categoriaItems.forEach(item => {
    item.addEventListener('click', buscarProductos)
});

categoriaItems[0].click();

const iniciarCarouseles = () => {
    const carouseles = document.querySelectorAll('.carousel')
    carouseles.forEach(car => {
        const carr = new Carousel(car)
        carr.cycle();
    });
}