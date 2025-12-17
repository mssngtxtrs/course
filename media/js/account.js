import { AuthAPI } from "./modules/auth_api.js";

const hostings = getHostings();
const cpus = getCPUs();
const permissions = getPermissions();

const max_retries = 3;
let personal_retries = 0;


buildPersonal();
buildRequests();


function buildPersonal() {
    const personal = document.getElementById('personal')
    const personal_buttons = personal.querySelector('.buttons');

    AuthAPI.getCredentials()
        .then(json => {
            const name = personal.querySelector('h1');
            const email = personal.querySelector('h2');
            const permission = personal.querySelector('p');

            const permissionName = permissions[json.output.permissionID];

            name.innerHTML = `${json.output.firstName} ${json.output.lastName}`;

            email.innerHTML = `${json.output.email}`;
            permission.innerHTML += `${permissionName.permission}`;

            if (json.output.permissionID == 3) {
                personal_buttons.innerHTML += `<button class="button" onclick="window.location = 'requests/admin'">Админ-панель</button>`;
            }

            personal_buttons.innerHTML += `<button class="button" onclick="window.location = 'api/auth/log-out'">Выход</button>`;
        })
        .catch(err => {
            console.error("Error getting personal info: " + err);
            if (personal_retries < max_retries) {
                personal_retries += 1;
                buildPersonal();
            }
        });
}

function buildRequests() {
    const requests = document.getElementById('requests');

    // fetch();
}

function getHostings() {
    const output = {};

    fetch("/api/hostings")
        .then(response => {
            if (!response.ok) throw new Error("No response from server");
            return response.json();
        })
        .then (json => {
            json.output.forEach(item => {
                output[item.hostingID] = {
                    'hostingAlias': item.hostingAlias,
                    'maxUsers': item.maxUsers,
                    'cpuID': item.cpuID,
                    'ram': item.ram,
                    'ramUser': item.ramUser,
                    'diskSpace': item.diskSpace,
                    'diskSpaceUser': item.diskSpaceUser,
                };
            })
        })
        .catch(err => {
            console.log("Error getting hostings list: " + err)
        });

    return output;
}

function getCPUs() {
    const output = {};

    fetch("/api/hostings/cpu")
        .then(response => {
            if (!response.ok) throw new Error("No response from server");
            return response.json();
        })
        .then (json => {
            json.output.forEach(item => {
                output[item.cpuID] = {
                    'cpuName': item.cpuName,
                    'frequency': item.frequency,
                    'cores': item.cores,
                    'threads': item.threads,
                    'cacheL3': item.cacheL3,
                    'cacheL2': item.cacheL2,
                    'cacheL1': item.cacheL1,
                };
            })
        })
        .catch(err => {
            console.log("Error getting CPUs list: " + err)
        });

    return output;
}

function getPermissions() {
    const output = {};

    fetch("/api/requests/get-permissions")
        .then(response => {
            if (!response.ok) throw new Error("No response from server");
            return response.json();
        })
        .then (json => {
            json.output.forEach(item => {
                output[item.permissionID] = {
                    'permission': item.permission,
                };
            })
        })
        .catch(err => {
            console.log("Error getting hostings list: " + err)
        });

    return output;
}
