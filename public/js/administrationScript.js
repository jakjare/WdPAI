const problem_boxes = document.querySelectorAll('.problem-box');
const more_info_box = document.querySelector('.more-info');
const overlay = document.querySelector('div[class="overlay"]');
const exitPopupButton = document.querySelector('button[id="exitPopupButton"]');
const problemReplyForm = overlay.querySelector('form[id="problemReplyForm"]');

function showMoreInfo(id) {
    more_info_box.innerHTML = "";
    const data = {id: id};

    fetch("/getSpecificProblemJSON", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (fullInfo) {
        loadInformation(fullInfo[0]);
    });
}

function loadInformation(info) {
    const template = document.querySelector('#more-info-template');
    const permissionButtonsTemplate = document.querySelector('#permission-table-buttons-template');
    const problemHistoryButtonTemplate = document.querySelector('#problem-history-table-buttons-template');

    const clone = template.content.cloneNode(true);
    const state = clone.querySelector('#state');
    state.innerHTML = info.state;
    const ip = clone.querySelector('#ip');
    ip.innerHTML = info.ip_address;

    const table = clone.querySelector('#permissions-table');
    info.permissions.forEach(function (currentElement) {
        const tr = document.createElement('tr');
        const tdName = document.createElement('td');
        tdName.innerHTML = currentElement.name;
        const tdSurname = document.createElement('td');
        tdSurname.innerHTML = currentElement.surname;
        const tdEmail = document.createElement('td');
        tdEmail.innerHTML = currentElement.email;

        const cloneButtons = permissionButtonsTemplate.content.cloneNode(true);
        cloneButtons.querySelector('.fa-user-slash').parentElement.addEventListener('click', function () {
            revokePermission(currentElement.email,info.id_device);
            tr.remove();
        });

        tr.appendChild(tdName);
        tr.appendChild(tdSurname);
        tr.appendChild(tdEmail);
        tr.appendChild(cloneButtons);

        table.appendChild(tr);
    });

    const tableHistory = clone.querySelector('#problem-history-table');
    info.problem_history.forEach(function (currentElement) {
        const tr = document.createElement('tr');
        const tdStatus = document.createElement('td');
        tdStatus.innerHTML = currentElement.status.toUpperCase();
        const tdDescription = document.createElement('td');
        tdDescription.innerHTML = currentElement.description.substr(0, 50);
        const tdTime = document.createElement('td');
        tdTime.innerHTML = currentElement.time;
        const tdReported = document.createElement('td');
        tdReported.innerHTML = currentElement.reported;
        const tdAck = document.createElement('td');
        tdAck.innerHTML = currentElement.ack;

        const cloneButton = problemHistoryButtonTemplate.content.cloneNode(true);
        cloneButton.querySelector('button').addEventListener('click', function () {
            showMoreInfo(currentElement.id);
        });

        tr.appendChild(tdStatus);
        tr.appendChild(tdDescription);
        tr.appendChild(tdTime);
        tr.appendChild(tdReported);
        tr.appendChild(tdAck);
        tr.appendChild(cloneButton);

        tableHistory.appendChild(tr);
    });


    more_info_box.appendChild(clone);
}

function revokePermission(user_email, id_device) {
    const data = {email: user_email, id_device: id_device};

    fetch("/revokePermissionJSON", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
}

exitPopupButton.addEventListener('click', function () {
    overlay.style.display = 'none';
});

problem_boxes.forEach(function (currentElement) {
    const infoButton = currentElement.querySelector('.fa-info').parentElement;
    const replyButton = currentElement.querySelector('.fa-reply').parentElement;
    const acceptButton = currentElement.querySelector('.fa-check').parentElement;
    infoButton.addEventListener('click', function () {
        showMoreInfo(infoButton.id);
    });
    replyButton.addEventListener('click', function () {
        problemReplyForm.reset();
        overlay.style.display = 'flex';
        problemReplyForm.querySelector('[name="id"]').value = infoButton.id;
    });
    acceptButton.addEventListener('click', function () {
        const data = {id_problem: infoButton.id};

        fetch("/setAckJSON", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        currentElement.querySelector('.fa-hammer').nextElementSibling.innerHTML = 'Yes';
        currentElement.querySelector('h2').innerHTML = 'STATUS: IN PROCESS';
    });
});