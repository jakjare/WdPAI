const table = document.querySelector('.objects-table');
const allCheckbox = table.querySelector('#check-all');
const oneCheckbox = table.querySelectorAll('tr[id]');
const openRequestBlock = document.querySelector('div[id="open-request"]');
const deleteCheckedButton = document.querySelector('#deleteCheckedButton');

function changeArchivedStatus(id) {
    const data = {id: id};

    fetch("/changeRequestArchivedJSON", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
}

function openRequest(id) {
    const data = {id: id};

    fetch("/getRequestJSON", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (request) {
        showRequest(request[0]);
    });
    openRequestBlock.style.display = 'flex';
}

function showRequest(requestElement) {
    openRequestBlock.querySelector("#topic").innerHTML = requestElement.topic;
    openRequestBlock.querySelector("#from").innerHTML = "From: "+requestElement.from;
    openRequestBlock.querySelector("#date").innerHTML = "Date: "+requestElement.date;
    openRequestBlock.querySelector("#device").href = requestElement.id_device;
    openRequestBlock.querySelector("#device").innerHTML = requestElement.device;
    openRequestBlock.querySelector("p").innerHTML = requestElement.content;
}

allCheckbox.addEventListener('click', function () {
    const type = allCheckbox.checked
    oneCheckbox.forEach(function (currentValue) {
        currentValue.querySelector('input[type="checkbox"]').checked = type;
    });
});

oneCheckbox.forEach(function (currentValue) {
    currentValue.querySelector(".fa-archive").addEventListener('click', function () {
        changeArchivedStatus(currentValue.id);
        currentValue.remove();
    });

    const data = currentValue.querySelectorAll('.click');
    data.forEach(function (current) {
        current.addEventListener('click',function () {
            currentValue.classList.remove('bold');
            openRequest(currentValue.id);
        });
    });

});

deleteCheckedButton.addEventListener('click', function () {
    oneCheckbox.forEach(function (currentValue) {
        if (currentValue.querySelector('input[type="checkbox"]').checked)
        {
            changeArchivedStatus(currentValue.id);
            currentValue.remove();
        }
    });
});