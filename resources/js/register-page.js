import togglePasswordVisibility from './toggle-password-visibility.js';
import hideValidationErrors from './hide-validation-errors.js';

togglePasswordVisibility('#passwordVisibilityToggler');

hideValidationErrors('#registerForm input.is-invalid', 'input');
