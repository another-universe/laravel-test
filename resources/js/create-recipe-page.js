import hideValidationErrors from './hide-validation-errors.js';

hideValidationErrors('#recipeForm input.is-invalid', 'input');

const alert = document.getElementById('recipeWasCreated');

if (alert !== null) {
    alert.addEventListener('closed.bs.alert', function () {
        document.getElementById('title').focus();
    });
}
