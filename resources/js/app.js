import './bootstrap';
import './masks.js';
import './dataTable.js';
import initCrearUsuario from './crearUsuario.js';
import initModificarUsuario from './modificarUsuario.js';

// expose SweetAlert2 globally for easy use in inline scripts
import Swal from 'sweetalert2';
window.Swal = Swal;

// initialize feature-specific scripts
initCrearUsuario();
initModificarUsuario();
