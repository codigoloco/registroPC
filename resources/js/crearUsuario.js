// client-side logic for "Crear Usuario" modal

import IMask from 'imask';

function initCrearUsuario() {
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('crearUsuarioForm');
        if (!form) return;

        const pwdField = form.querySelector('input[name="password"]');
        const confirmField = form.querySelector('input[name="password_confirmation"]');
        const msgPwd = document.getElementById('crearPwdMsg');
        const msgConfirm = document.getElementById('crearConfirmMsg');
        const mainError = document.getElementById('crearMainError');

        function checkLength(field, messageEl) {
            if (!field || !messageEl) return;
            messageEl.style.display = field.value.length < 8 ? 'inline' : 'none';
        }

        // apply IMask to password fields to fire onAccept for length check
        if (pwdField) {
            IMask(pwdField, {
                mask: /./,
                lazy: true,
                placeholderChar: '\u2000',
                onAccept: function () {
                    checkLength(pwdField, msgPwd);
                }
            });
        }
        if (confirmField) {
            IMask(confirmField, {
                mask: /./,
                lazy: true,
                placeholderChar: '\u2000',
                onAccept: function () {
                    checkLength(confirmField, msgConfirm);
                }
            });
        }

        if (pwdField) {
            pwdField.addEventListener('input', () => {
                checkLength(pwdField, msgPwd);
                if (mainError) {
                    mainError.style.display = 'none';
                    mainError.textContent = '';
                }
            });
        }
        if (confirmField) {
            confirmField.addEventListener('input', () => {
                checkLength(confirmField, msgConfirm);
                if (mainError) {
                    mainError.style.display = 'none';
                    mainError.textContent = '';
                }
            });
        }

        form.addEventListener('submit', function (e) {
            const pwd = pwdField?.value || '';
            const confirm = confirmField?.value || '';

            if (mainError) {
                mainError.style.display = 'none';
                mainError.textContent = '';
            }

            if (pwd.length < 8 || confirm.length < 8) {
                e.preventDefault();
                const message = 'Las contraseñas deben tener al menos 8 caracteres.';
                if (mainError) {
                    mainError.textContent = message;
                    mainError.style.display = 'block';
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
                return;
            }

            if (pwd !== confirm) {
                e.preventDefault();
                const message = 'Las contraseñas no coinciden.';
                if (mainError) {
                    mainError.textContent = message;
                    mainError.style.display = 'block';
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            }
        });
    });
}


// helper to clear form inputs and messages
function resetCrearUsuarioForm() {
    const form = document.getElementById('crearUsuarioForm');
    if (!form) return;
    form.reset();

    const mainError = document.getElementById('crearMainError');
    const msgPwd = document.getElementById('crearPwdMsg');
    const msgConfirm = document.getElementById('crearConfirmMsg');
    if (mainError) {
        mainError.style.display = 'none';
        mainError.textContent = '';
    }
    if (msgPwd) msgPwd.style.display = 'none';
    if (msgConfirm) msgConfirm.style.display = 'none';
}

// expose globally so blade can call it on modal close
window.resetCrearUsuarioForm = resetCrearUsuarioForm;

export default initCrearUsuario;

