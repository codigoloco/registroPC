import IMask from 'imask';

document.addEventListener('alpine:init', () => {
    Alpine.directive('imask', (el, { expression }, { evaluate, cleanup }) => {
        const type = evaluate(expression);
        let maskOptions;

        if (type === 'text') {
            maskOptions = {
                mask: /^[a-zA-Z\sÀ-ÿ]*$/
            };
        } else if (type === 'number') {
            maskOptions = {
                mask: /^\d*$/
            };
        } else {
            maskOptions = {
                mask: type
            };
        }

        const mask = IMask(el, maskOptions);
        cleanup(() => mask.destroy());
    });
});
