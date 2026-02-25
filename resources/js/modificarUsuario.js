// client-side logic for "Modificar Usuario" modal
import IMask from 'imask';

function initModificarUsuario() {
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('modificarUsuarioForm');
        if (!form) return;

        const pwdField = form.querySelector('input[name="password"]');
        const confirmField = form.querySelector('input[name="password_confirmation"]');
        const msgPwd = document.getElementById('editPwdMsg');
        const msgConfirm = document.getElementById('editConfirmMsg');
        const mainError = document.getElementById('editMainError');

        function checkLength(field, messageEl) {
            if (!field || !messageEl) return;
            // If empty, don't show error (since it's optional on edit)
            if (field.value.length === 0) {
                messageEl.style.display = 'none';
                return;
            }
            messageEl.style.display = field.value.length < 8 ? 'inline' : 'none';
        }

        // apply IMask to password fields to fire onAccept for length check
        if (pwdField) {
            IMask(pwdField, {
                mask: /^.*$/,
                onAccept: function () {
                    checkLength(pwdField, msgPwd);
                }
            });
            pwdField.addEventListener('input', () => {
                checkLength(pwdField, msgPwd);
                if (mainError) {
                    mainError.style.display = 'none';
                    mainError.textContent = '';
                }
            });
        }
        if (confirmField) {
            IMask(confirmField, {
                mask: /^.*$/,
                onAccept: function () {
                    checkLength(confirmField, msgConfirm);
                }
            });
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

            // If any content is entered, validate length
            if ((pwd.length > 0 && pwd.length < 8) || (confirm.length > 0 && confirm.length < 8)) {
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

            // If any content is entered, validate match
            if (pwd.length > 0 || confirm.length > 0) {
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
            }
        });
    });
}

export default initModificarUsuario;
