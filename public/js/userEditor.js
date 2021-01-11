const overlay = document.querySelector('div[class="overlay"]');
const userAddButton = document.querySelector('button[id="userAddButton"]');
const exitPopupButton = document.querySelector('button[id="exitPopupButton"]');
const userEditorForm = overlay.querySelector('form[class="account-settings-form"]');
const actions = document.querySelector('table[class="objects-table"]').querySelectorAll('tr[id]');
const form = overlay.querySelector('form');

actions.forEach(function (currentValue) {
    const data = {email: currentValue.querySelector('[id="email"]').innerHTML};
    currentValue.querySelector('.fa-user-edit').addEventListener('click', function () {
        fetch("/getUserJSON", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (user) {
            editExistingUser(user[0]);
        });
    });

    currentValue.querySelector('.fa-user-lock').addEventListener('click', function () {
        fetch("/changeUserStatusJSON", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (response) {
            currentValue.querySelector('[id="status"]').innerHTML = response ? 'Active' : 'Inactive';
        });
    });

    currentValue.querySelector('.fa-trash').addEventListener('click', function () {
        if (confirm('Are you sure want to delete this user?')) {
            fetch("/deleteUserJSON", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            currentValue.remove();
        }
    })
});

exitPopupButton.addEventListener('click', function () {
    overlay.style.display = 'none';
    overlay.querySelector('h1').innerText = "New user";
    form.action = 'addUser';
    userEditorForm.reset();
});

userAddButton.addEventListener('click', function () {
    overlay.style.display = 'flex';
});

function editExistingUser(user)
{
    overlay.style.display = 'flex';
    overlay.querySelector('h1').innerText = "Change user information";
    form.action = 'editUser';
    form.querySelector('input[name="old-email"]').value = user.email;
    form.querySelector('input[name="email"]').value = user.email;
    form.querySelector('input[name="name"]').value = user.name;
    form.querySelector('input[name="surname"]').value = user.surname;
    form.querySelector('input[name="phone"]').value = user.phone;
    form.querySelectorAll('option').forEach(function (currentValue) {
        if(currentValue.innerText.toLowerCase() == user.role)
        {
            currentValue.selected = true;
        }
    });
}