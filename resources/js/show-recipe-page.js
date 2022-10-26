import axios from './axios.js';

document.getElementById('favorite').addEventListener('click', async function () {
    try {
        this.disabled = true;
        this.classList.add('active');

        const url = this.getAttribute('data-url');
        let response = null;

        if (this.getAttribute('data-action') === 'add') {
            response = await axios.post(url);
            this.setAttribute('data-action', 'remove');
        } else {
            response = await axios.delete(url);
            this.setAttribute('data-action', 'add');
        }

        this.querySelectorAll('span').forEach((element) => {
            element.classList.toggle('d-none');
        });

        if (typeof response.data.actual_value === 'number') {
            document.querySelector('.in-favorites').textContent = response.data.actual_value;
        }
    } finally {
        this.classList.remove('active');
        this.disabled = false;
    }
});

let dynamicListener = null;

const modal = document.getElementById('shareModal'),
    clearForm = function () {
        document
            .getElementById('shareForm')
            .querySelectorAll('select,input')
            .forEach((element) => {
                if (element instanceof HTMLSelectElement) {
                    element.options[0].selected = true;
                } else {
                    element.value = '';
                }

                if (element.id === 'recipient') {
                    if (dynamicListener !== null) {
                        element.removeEventListener('input', dynamicListener);
                        dynamicListener = null;
                    }

                    element.type = 'text';
                }

                element.classList.remove('is-invalid');
                element.parentElement.querySelector('.invalid-feedback').textContent = '';
            });
    },
    hideAlerts = function () {
        modal.querySelectorAll('.alert').forEach((element) => {
            element.classList.add('d-none');
        });
    },
    onErrorFocus = function (element = null) {
        if (element === null) {
            element = document.getElementById('shareForm').querySelector('.is-invalid');
        }

        if (element !== null) {
            element.focus();
        }
    };

modal.addEventListener('shown.bs.modal', function () {
    document.getElementById('channel').focus();
});

modal.addEventListener('hide.bs.modal', function (event) {
    if (document.getElementById('share').disabled) {
        event.preventDefault();
    }
});

modal.addEventListener('hidden.bs.modal', function () {
    clearForm();
    hideAlerts();
});

modal.querySelectorAll('.alert > .btn-close').forEach((btn) => {
    btn.addEventListener('click', function () {
        const alert = this.closest('.alert');
        alert.classList.add('d-none');

        if (alert.classList.contains('alert-success')) {
            document.getElementById('channel').focus();
        } else {
            document.getElementById('share').focus();
        }
    });
});

document.getElementById('channel').addEventListener('change', function () {
    const field = document.getElementById('recipient');
    field.value = '';
    field.classList.remove('is-invalid');
    field.parentElement.querySelector('.invalid-feedback').textContent = '';

    switch (this.value) {
        case 'mail':
            if (dynamicListener !== null) {
                field.removeEventListener('input', dynamicListener);
                dynamicListener = null;
            }

            field.type = 'email';
            break;
        case 'telegram':
            if (dynamicListener === null) {
                dynamicListener = function () {
                    const char = field.value.charAt(0),
                        type = char === '+' ? 'tel' : 'text';

                    if (field.type !== type) {
                        field.type = type;
                    }
                };
                field.addEventListener('input', dynamicListener);
            }

            field.type = 'text';
            break;
        case 'viber':
            if (dynamicListener !== null) {
                field.removeEventListener('input', dynamicListener);
                dynamicListener = null;
            }

            field.type = 'tel';
            break;
    }

    this.classList.remove('is-invalid');
    this.parentElement.querySelector('.invalid-feedback').textContent = '';
});

document.getElementById('sender').addEventListener('input', function () {
    this.classList.remove('is-invalid');
    this.parentElement.querySelector('.invalid-feedback').textContent = '';
});

document.getElementById('recipient').addEventListener('input', function () {
    this.classList.remove('is-invalid');
    this.parentElement.querySelector('.invalid-feedback').textContent = '';
    this.value = this.value.replace(/\s+/g, '');
    this.selectionStart = this.value.length;
});

document.getElementById('share').addEventListener('click', async function () {
    hideAlerts();
    const form = document.getElementById('shareForm'),
        invalid = form.querySelector('.is-invalid');

    if (invalid !== null) {
        onErrorFocus(invalid);

        return;
    }

    for (const id of ['channel', 'recipient']) {
        const element = document.getElementById(id);

        if (element.value === '') {
            element.classList.add('is-invalid');
            onErrorFocus(element);

            return;
        }
    }

    this.classList.add('active');
    this.disabled = true;

    try {
        await axios.post(modal.getAttribute('data-url'), new FormData(form));
        clearForm();
        modal.querySelector('.alert-success').classList.remove('d-none');
    } catch (e) {
        if (e.response) {
            const {status, data} = e.response;

            if (status === 422) {
                for (const [key, errors] of Object.entries(data.errors)) {
                    const element = form.querySelector(`[name="${key}"]`);
                    element.parentElement.querySelector('.invalid-feedback').textContent = errors[0];
                    element.classList.add('is-invalid');
                }

                onErrorFocus();

                return;
            }
        }

        modal.querySelector('.alert-danger').classList.remove('d-none');
    } finally {
        this.disabled = false;
        this.classList.remove('active');
    }
});
