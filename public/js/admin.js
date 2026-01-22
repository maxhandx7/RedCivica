// public/js/admin.js
// Funciones de utilidad para el panel de administración

// Confirmación para eliminación
window.confirmarEliminacion = function(event) {
    event.preventDefault();
    const form = event.target.closest('form');
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
};

// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Inicializar popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});

// Función para copiar al portapapeles
window.copiarAlPortapapeles = function(texto, mensaje = 'Copiado al portapapeles') {
    navigator.clipboard.writeText(texto).then(() => {
        Swal.fire({
            icon: 'success',
            title: '¡Copiado!',
            text: mensaje,
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }).catch(err => {
        console.error('Error al copiar: ', err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo copiar al portapapeles',
            timer: 2000
        });
    });
};

// Función para formatear números
window.formatearNumero = function(numero) {
    return new Intl.NumberFormat('es-ES').format(numero);
};

// Inicializar drag and drop para reordenamiento
window.inicializarSortable = function(selector, url) {
    const element = document.querySelector(selector);
    if (!element) return;
    
    const sortable = Sortable.create(element, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'bg-light',
        onEnd: function(evt) {
            const items = Array.from(evt.from.children).map((item, index) => ({
                id: item.dataset.id,
                orden: index + 1
            }));
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    items: items
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Mostrar notificación de éxito
                    const toast = document.createElement('div');
                    toast.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
                    toast.style.zIndex = '9999';
                    toast.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>¡Orden actualizado!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(toast);
                    
                    // Remover automáticamente después de 3 segundos
                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                } else {
                    throw new Error(data.message || 'Error al actualizar el orden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el orden. Por favor, recarga la página e inténtalo de nuevo.',
                    timer: 3000
                });
                
                // Recargar la página para restaurar el orden original
                setTimeout(() => {
                    location.reload();
                }, 1500);
            });
        }
    });
};

// Exportar datos a Excel
window.exportarExcel = function(tablaId, nombreArchivo = 'datos') {
    const tabla = document.getElementById(tablaId);
    if (!tabla) {
        console.error('No se encontró la tabla con ID:', tablaId);
        return;
    }
    
    // Crear libro de trabajo
    const wb = XLSX.utils.book_new();
    
    // Convertir tabla a hoja de trabajo
    const ws = XLSX.utils.table_to_sheet(tabla);
    
    // Agregar hoja al libro
    XLSX.utils.book_append_sheet(wb, ws, 'Datos');
    
    // Descargar archivo
    XLSX.writeFile(wb, `${nombreArchivo}_${new Date().toISOString().split('T')[0]}.xlsx`);
};

// Exportar datos a PDF
window.exportarPDF = function(tablaId, titulo = 'Reporte', nombreArchivo = 'reporte') {
    const tabla = document.getElementById(tablaId);
    if (!tabla) {
        console.error('No se encontró la tabla con ID:', tablaId);
        return;
    }
    
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Agregar título
    doc.setFontSize(18);
    doc.text(titulo, 14, 22);
    
    // Agregar fecha
    doc.setFontSize(10);
    doc.text(`Generado: ${new Date().toLocaleDateString('es-ES')}`, 14, 30);
    
    // Convertir tabla a imagen
    html2canvas(tabla, {
        scale: 2,
        useCORS: true
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 180;
        const pageHeight = 290;
        const imgHeight = canvas.height * imgWidth / canvas.width;
        
        let heightLeft = imgHeight;
        let position = 40;
        
        doc.addImage(imgData, 'PNG', 15, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;
        
        // Agregar páginas adicionales si es necesario
        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            doc.addPage();
            doc.addImage(imgData, 'PNG', 15, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }
        
        // Descargar PDF
        doc.save(`${nombreArchivo}_${new Date().toISOString().split('T')[0]}.pdf`);
    });
};

// Cargar datos con AJAX
window.cargarDatosAjax = function(url, callback, errorCallback) {
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (typeof callback === 'function') {
            callback(data);
        }
    })
    .catch(error => {
        console.error('Error al cargar datos:', error);
        if (typeof errorCallback === 'function') {
            errorCallback(error);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos. Por favor, inténtalo de nuevo.',
                timer: 3000
            });
        }
    });
};

// Validación de formularios
window.validarFormulario = function(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let valido = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            valido = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    return valido;
};

// Función para mostrar/ocultar contraseña
window.togglePassword = function(inputId) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    
    // Cambiar icono
    const icon = document.querySelector(`[data-toggle="${inputId}"] i`);
    if (icon) {
        if (type === 'text') {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
};