const phoneInput = document.querySelector('input[name="phone"]');
const emailInput = document.querySelector('input[name="email"]');
const emailButton = emailInput.parentElement.parentElement.parentElement.querySelector('button');
const newPasswordInput = document.querySelector('input[name="new-password"]');
const confirmedPasswordInput = document.querySelector('input[name="confirm-password"]');
const passwordButton = newPasswordInput.parentElement.parentElement.parentElement.querySelector('button');

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
        condition ? passwordButton.disabled = false : passwordButton.disabled = true;
        markValidation(confirmedPasswordInput, condition);
        },
        1000
    );
});