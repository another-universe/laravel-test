export default function (selectors) {
    if (typeof selectors === 'string') {
        selectors = [selectors];
    } else if (!Array.isArray(selectors)) {
        throw new Error('The selectors parameter must be a string or an array of strings.');
    }

    for (const selector of selectors) {
        document.querySelectorAll(selector).forEach((element) => {
            element.addEventListener('click', function () {
                const passwordField = document.querySelector(this.getAttribute('data-target'));
                passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
                this.querySelectorAll('span').forEach((element) => {
                    element.classList.toggle('d-none');
                });
            });
        });
    }
}
