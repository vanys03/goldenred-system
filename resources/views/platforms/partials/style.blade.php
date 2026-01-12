<style>
    /* -------------------------------------- */
    /* 1. PLATFORM GRID & CARD STYLES */
    /* -------------------------------------- */

    /* Contenedor de las tarjetas para dar espacio */
    .platform-grid {
        display: flex;
        gap: 1.5rem;
        /* Espacio entre las tarjetas */
        flex-wrap: wrap;
        /* Permite que las tarjetas salten de línea en pantallas pequeñas */
        padding: 1.5rem;
    }

    /* Estilo base para cada tarjeta (Ahora un DIV) */
    .platform-card {
        /* Esencial para el posicionamiento absoluto del botón de eliminar */
        position: relative;

        /* Define el tamaño (ajusta el width y height si quieres que sean más grandes/pequeñas) */
        width: 180px;
        height: 180px;

        /* Estilos visuales */
        background-color: #f0f2f5;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

        /* Quitar el estilo de enlace */
        text-decoration: none;
        color: #344767;

        /* Transición para el efecto hover */
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        cursor: pointer;
    }

    /* Efecto de hover (interacción) */
    .platform-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    /* Estilo específico para la tarjeta de 'Agregar Nueva' */
    .platform-card.add-new {
        border: 2px dashed #adb5bd;
        /* Borde punteado/discontinuo */
        background-color: #ffffff;
        /* Fondo blanco */
    }

    /* Ajuste del cuerpo de la tarjeta para centrar el contenido */
    .platform-card .card-body {
        padding: 1rem;
        height: 100%;
    }

    /* El enlace dentro de la tarjeta debe ocupar todo el espacio para ser clickeable */
    .platform-card .card-link {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    /* Estilo para el icono */
    .platform-card i {
        font-size: 2.5rem !important;
        color: #344767;
    }

    /* -------------------------------------- */
    /* 2. DELETE BUTTON ('X' en Tarjeta) */
    /* -------------------------------------- */

    .delete-platform-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #ddd;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        line-height: 28px;
        text-align: center;
        cursor: pointer;
        font-size: 1rem !important;
        /* Material icon size */
        padding: 0;
        opacity: 0;
        transition: opacity 0.2s ease, background-color 0.2s;
        color: #f44336;
        /* Color de peligro */
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .platform-card:hover .delete-platform-btn {
        opacity: 1;
        /* Aparece al pasar el ratón */
    }

    .delete-platform-btn:hover {
        background-color: #f44336;
        color: white;
    }

    /* -------------------------------------- */
    /* 3. MODAL STYLES */
    /* -------------------------------------- */

    /* Fondo oscuro que cubre la pantalla */
    .modal-elegant-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    /* Contenido de la modal */
    .modal-elegant-content {
        position: relative;
        /* Esencial para la 'X' de cerrar */
        background-color: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2), 0 5px 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 500px;
        transform: translateY(-50px);
        transition: transform 0.3s ease;
    }

    /* Mostrar la modal */
    .modal-elegant-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .modal-elegant-overlay.show .modal-elegant-content {
        transform: translateY(0);
    }

    /* -------------------------------------- */
    /* 4. MODAL CLOSE BUTTON ('X' en Modal) */
    /* -------------------------------------- */

    .close-button-elegant {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        color: #999;
        /* Gris oscuro para integrarse */
        padding: 0;
        line-height: 1;
        z-index: 1050;
        opacity: 0.7;
        transition: opacity 0.2s, color 0.2s;
    }

    .close-button-elegant:hover {
        opacity: 1;
        color: #344767;
    }

    /* -------------------------------------- */
    /* 5. FORM STYLES */
    /* -------------------------------------- */

    .modal-elegant-body {
        padding: 1.5rem;
    }

    /* Estilos para el formulario */
    .form-group-elegant {
        margin-bottom: 1.5rem;
    }

    .form-label-elegant {
        font-weight: 600;
        color: #344767;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 1.1rem;
    }

    .form-control-elegant {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        border-radius: 0.5rem;
        font-size: 1rem;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control-elegant:focus {
        border-color: #6200EE;
        box-shadow: 0 0 0 0.2rem rgba(98, 0, 238, 0.25);
        outline: none;
    }

    /* Botón de aceptar */
    .elegant-submit-button {
        background-image: linear-gradient(195deg, #66bb6a 0%, #43a047 100%);
        border: none;
        color: white;
        font-weight: 700;
        padding: 0.8rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out;
    }

    .elegant-submit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }
</style>
<style>
    /* --- Estilos Generales y del Contenedor --- */
    .elegant-shadow {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05), 0 3px 6px rgba(0, 0, 0, 0.03);
        /* Sombra suave */
        border-radius: 1rem;
        /* Esquinas más redondeadas */
    }

    .emails-profile-layout-elegant {
        display: flex;
        gap: 25px;
    }

    /* Columna de Correos */
    .emails-list-container-elegant {
        flex: 2;
        max-width: 60%;
        /* Ocupa la mayoría del espacio en pantallas grandes */
    }

    /* Panel de Perfiles */
    .profiles-panel-elegant {
        flex: 1;
        min-width: 250px;
        background-color: #f8f9fa;
        /* Fondo blanco roto/gris claro */
        padding: 20px;
        border-radius: 0.75rem;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.02);
        /* Sombra interior sutil */
    }

    .panel-title-elegant {
        font-weight: 700;
        /* Negrita */
        letter-spacing: 0.5px;
        /* Espaciado sutil */
        color: #344767;
        /* Color principal */
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 10px;
    }

    /* --- Estilos para los Elementos de Correo (Lista) --- */
    .email-item-elegant {
        padding: 15px 20px;
        margin-bottom: 8px;
        font-size: 1.1rem;
        font-weight: 400;
        cursor: pointer;
        border-radius: 0.5rem;
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        /* Borde muy sutil */
        transition: all 0.25s ease-in-out;
    }

    .email-item-elegant:hover {
        background-color: #e3f2fd;
        /* Azul claro sutil al pasar el mouse */
        border-color: #bbdefb;
        transform: translateX(5px);
        /* Deslizamiento sutil */
    }

    /* Estilo para el correo activo/seleccionado */
    .email-item-elegant.active-email-elegant {
        background-color: #6200EE;
        /* Color principal o índigo fuerte */
        color: white;
        font-weight: 600;
        border-color: #6200EE;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .email-item-elegant.active-email-elegant:hover {
        background-color: #5300d3;
        border-color: #5300d3;
        transform: none;
        /* Sin deslizamiento cuando está activo */
    }

    /* --- Estilos para la Caja de Ocupante (Roja) --- */
    .profile-occupant-box-elegant {
        background-color: #fce4ec;
        /* Rosa muy claro para elegancia en lugar de rojo chillón */
        color: #c2185b;
        /* Texto rojo oscuro */
        padding: 15px;
        border-radius: 0.5rem;
        text-align: center;
        border: 1px solid #f8bbd0;
    }

    .occupant-label {
        font-size: 0.8rem;
        margin: 0;
        opacity: 0.8;
    }

    .occupant-name-elegant {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0;
    }

    /* --- Estilos para Botones de Acción --- */
    .action-buttons-grid-elegant {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 20px;
    }

    .elegant-action-button {
        height: 70px;
        font-weight: 600;
        color: #388e3c !important;
        /* Verde oscuro para elegancia */
        border: 1px solid #a5d6a7 !important;
        background-color: #e8f5e9 !important;
        /* Verde muy claro */
        transition: all 0.2s;
    }

    .elegant-action-button:hover {
        background-color: #c8e6c9 !important;
        /* Verde claro al hover */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .elegant-button-outline {
        font-weight: 600;
    }

    /* Estilo específico para la opción de Agregar Nuevo Correo */
    .add-new-email {
        display: flex;
        /* Para alinear el icono y el texto */
        align-items: center;
        justify-content: center;
        /* Centra el contenido horizontalmente */

        /* Estilo visual distinto */
        background-color: #e0f7fa !important;
        /* Azul claro muy suave */
        color: #00838f !important;
        /* Azul verdoso para el texto y el icono */
        font-weight: 700 !important;
        border: 1px dashed #4db6ac !important;
        /* Borde punteado elegante */
        margin-bottom: 15px !important;
        /* Más espacio para separarlo de la lista */
        transition: background-color 0.25s;
        text-decoration: none;
        /* Asegura que no tenga subrayado de enlace */
    }

    .add-new-email:hover {
        background-color: #b2ebf2 !important;
        /* Tono más fuerte al pasar el mouse */
        cursor: pointer;
        transform: none !important;
        /* Quita el deslizamiento horizontal */
    }

    /* Ajuste sutil para los iconos de la opción Agregar */
    .add-new-email i {
        font-size: 1.25rem;
    }

    /* --- Modificación de la Grid de Acciones (4 tarjetas) --- */
    .four-profiles-grid {
        grid-template-columns: 1fr 1fr;
        /* Mantiene 2 columnas */
        gap: 10px;
    }

    .profile-card-elegant {
        /* Estilo general de la tarjeta de perfil */
        height: 85px;
        /* Más alto para acomodar el texto y el PIN */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        line-height: 1.2;
        padding: 5px;
    }

    .pin-indicator {
        display: block;
        font-size: 0.75rem;
        font-weight: 500;
        color: #00796b;
        /* Un tono verde más oscuro para el PIN */
        margin-top: 3px;
        padding: 2px 5px;
        background-color: #a5d6a7;
        border-radius: 3px;
    }

    /* --- Estilos para la Sección de Contraseña --- */
    .password-section-elegant {
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
        /* Separador sutil */
    }

    .password-title {
        font-weight: 700;
        color: #344767;
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .password-display-box {
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        padding: 10px 15px;
        border-radius: 0.5rem;
        text-align: center;
    }

    .password-text {
        font-size: 1.1rem;
        font-weight: 600;
        color: #6c757d;
        /* Gris para indicar que está oculto */
        letter-spacing: 2px;
    }

    .elegant-password-button {
        background-image: linear-gradient(195deg, #42a5f5 0%, #1e88e5 100%);
        /* Degradado azul para acción secundaria */
        color: white !important;
        font-weight: 600 !important;
        border: none !important;
    }

    .elegant-password-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* --- Estilos de Modal Elegante (Opcional, si no usas los de tu framework) --- */
    .modal-content-elegant {
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .modal-header-elegant {
        border-bottom: none;
        padding-bottom: 0;
    }

    .modal-title-elegant {
        font-weight: 700;
        color: #344767;
    }
    /* Colores para el estado del perfil */
.profile-card-elegant.status-red {
    background-color: #f8d7da !important; /* Fondo rojo muy claro */
    border: 1px solid #dc3545 !important; /* Borde rojo */
    color: #58151c !important; /* Texto oscuro para contraste */
}

.profile-card-elegant.status-green {
    background-color: #d4edda !important; /* Fondo verde muy claro */
    border: 1px solid #28a745 !important; /* Borde verde */
    color: #155724 !important; /* Texto oscuro para contraste */
}

.profile-card-elegant.status-purple {
    background-color: #e2d9ff !important; /* Fondo morado muy claro */
    border: 1px solid #6f42c1 !important; /* Borde morado */
    color: #3b2068 !important; /* Texto oscuro para contraste */
}
</style>