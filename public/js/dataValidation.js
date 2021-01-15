const phoneInput = document.querySelector('input[name="phone"]');
const emailInput = document.querySelector('input[name="email"]');
const emailButton = emailInput.parentElement.parentElement.parentElement.querySelector('button');
const newPasswordInput = document.querySelector('input[name="new-password"]');
const confirmedPasswordInput = document.querySelector('input[name="confirm-password"]');
const passwordButton = newPasswordInput.parentElement.parentElement.parentElement.querySelector('button');
let xDval = 123;

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

function passwordsLength(password)
{
    return password.length >= 3;
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
        const same = arePasswordsSame(
            newPasswordInput.value,
            confirmedPasswordInput.value
        );
        const length = passwordsLength(newPasswordInput.value);
        const condition = same && length;
        condition ? passwordButton.disabled = false : passwordButton.disabled = true;
        markValidation(confirmedPasswordInput, condition);
        },
        1000
    );
});