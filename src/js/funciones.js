import Swal from 'sweetalert2';
export const validarFormulario = (formulario, excepciones = []) => {
    const elements = formulario.querySelectorAll("input, select, textarea");
    let validarFormulario = []
    elements.forEach(element => {
        if (!element.value.trim() && !excepciones.includes(element.id)) {
            element.classList.add('is-invalid');

            validarFormulario.push(false)
        } else {
            element.classList.remove('is-invalid');
        }
    });

    let noenviar = validarFormulario.includes(false);

    return !noenviar;
}

export const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

export const confirmacion = async (text = '¿Esta seguro que desea borrar este registro?', icon = 'warning', buttonText = 'Si, eliminar') => {
    const alerta = Swal.fire({
        title: 'Confirmación',
        icon,
        text,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: buttonText
    })
    const resultado = (await alerta).isConfirmed
    return resultado;
}

export const validarUsuario = (nombreUsuario) => {
    // Definir las reglas de validación
    const longitudMinima = 3;
    const longitudMaxima = 15;
    const regex = /^[a-zA-Z][a-zA-Z0-9_]*$/;

    // Verificar la longitud del nombre de usuario
    if (nombreUsuario.length < longitudMinima || nombreUsuario.length > longitudMaxima) {
        return {
            valido: false,
            mensaje: `El nombre de usuario debe tener entre ${longitudMinima} y ${longitudMaxima} caracteres.`
        };
    }

    // Verificar que el nombre de usuario cumple con el regex
    if (!regex.test(nombreUsuario)) {
        return {
            valido: false,
            mensaje: 'El nombre de usuario solo puede contener letras, números y guiones bajos (_), y debe comenzar con una letra.'
        };
    }

    // Si pasa todas las validaciones
    return {
        valido: true,
        mensaje: 'El nombre de usuario es válido.'
    };
};

export const soloNumeros = (e) => {
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
}

export const sinSimbolos = (e) => {
    e.target.value = e.target.value.replace(/[^a-zA-Z0-9\s]/g, '');
}

export const mayusculas = (e) => {
    e.target.value = e.target.value.toUpperCase();
}


export const limitarString = (texto, longitudMaxima) => {
    // Verificar si el texto es más largo que la longitud máxima
    if (texto.length > longitudMaxima) {
        // Recortar el texto y agregar "..."
        return texto.slice(0, longitudMaxima) + '...';
    }
    // Si no, devolver el texto original
    return texto;
}