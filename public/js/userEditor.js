const overlay = document.querySelector('div[class="overlay"]');
const userAddButton = document.querySelector('button[id="userAddButton"]');
const exitPopupButton = document.querySelector('button[id="exitPopupButton"]');
const userEditorForm = overlay.querySelector('form[class="account-settings-form"]');

exitPopupButton.addEventListener('click', function () {
    overlay.style.display = 'none';
    userEditorForm.reset();
});

userAddButton.addEventListener('click', function () {
    overlay.style.display = 'flex';
});