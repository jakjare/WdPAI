const overlay = document.querySelector('div[class="overlay"]');
const deviceAddButton = document.querySelector('button[id="deviceAddButton"]');
const locationAddButton = document.querySelector('button[id="locationAddButton"]');
const exitPopupButton = document.querySelector('button[id="exitPopupButton"]');
const deviceEditorForm = overlay.querySelector('form[id="deviceForm"]');
const locationForm = overlay.querySelector('form[id="locationForm"]');

exitPopupButton.addEventListener('click', function () {
    overlay.style.display = 'none';
});

deviceAddButton.addEventListener('click', function () {
    overlay.querySelector('h1').innerText = "New device";
    deviceEditorForm.action = 'addDevice';
    deviceEditorForm.reset();
    deviceEditorForm.style.display = 'block';
    locationForm.style.display = 'none';
    overlay.style.display = 'flex';
});

locationAddButton.addEventListener('click', function () {
    overlay.querySelector('h1').innerText = "New location";
    locationForm.action = 'addLocation';
    locationForm.reset();
    locationForm.style.display = 'block';
    deviceEditorForm.style.display = 'none';
    overlay.style.display = 'flex';
});