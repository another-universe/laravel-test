export default function (selector, event) {
    document.querySelectorAll(selector).forEach((element) => {
        element.addEventListener(event, function () {
            this.classList.remove('is-invalid');
        });
    });
}
