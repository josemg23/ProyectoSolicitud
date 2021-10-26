Livewire.on('success', function (data) {
    if (data.modal !== '' || null) {
        $(data.modal).modal('hide');

    }
    iziToast.success({
        title: 'Municipio',
        message: data.mensaje,
        position: 'topRight'
    });
});

Livewire.on('error', function (data) {
    if (data.modal !== '' || null) {
        $(data.modal).modal('hide');

    }
    iziToast.error({
        title: 'Municipio',
        message: data.mensaje,
        position: 'topRight'
    });
});

Livewire.on('info', function (data) {
    if (data.modal !== '' || null) {
        $(data.modal).modal('hide');

    }
    iziToast.info({
        title: 'Municipio',
        message: data.mensaje,
        position: 'topRight'
    });
});

Livewire.on('warning', function (data) {
    if (data.modal !== '' || null) {
        $(data.modal).modal('hide');

    }
    iziToast.warning({
        title: 'Municipio',
        message: data.mensaje,
        position: 'topRight'
    });
});

Livewire.on('eliminarRegistro', function (title, metodo, id) {
    Swal.fire({
        title: title,
        text: "Esta accion ya no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Continuar!',
        cancelButtonText: 'Cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit(metodo, id)
        }
    });
})
