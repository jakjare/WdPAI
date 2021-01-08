const form = document.querySelectorAll("form");
const phoneInput = form[1].querySelector('input[name="phone"]');
const emailInput = form[1].querySelector('input[name="email"]');
const emailButton = form[1].querySelector('button');
const newPasswordInput = form[2].querySelector('input[name="new-password"]');
const confirmedPasswordInput = form[2].querySelector('input[name="confirm-password"]');

function isEmail(email)
{
    return /\S+@\S+\.\S+/.test(email);
}

function isPhoneNumber(phone)
{
    return /^[0-9]{9}$/.test(phone);
}

function arePasswordsSame(password, confirmedPassword)
{
    return password === confirmedPassword;
}

function markValidation(element, condition)
{
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

phoneInput.addEventListener('keyup', function () {
    setTimeout(function () {
        markValidation(phoneInput, isPhoneNumber(phoneInput.value));
        isPhoneNumber(phoneInput.value) ? emailButton.disabled = false : emailButton.disabled = true;
        },
        1000
    );
});

emailInput.addEventListener('keyup', function () {
    setTimeout( function () {
        markValidation(emailInput, isEmail(emailInput.value));
        isEmail(emailInput.value) ? emailButton.disabled = false : emailButton.disabled = true;
        },
        1000
    );
});

confirmedPasswordInput.addEventListener('keyup', function () {
    setTimeout(function () {
        const condition = arePasswordsSame(
            newPasswordInput.value,
            confirmedPasswordInput.value
        );
        markValidation(confirmedPasswordInput, condition);
        },
        1000
    );
});