showTasks();

const addFormElement = document.querySelector("#add-form");
const alertElement = document.querySelector("#alert");

addFormElement.addEventListener("submit", async function (e) {
    e.preventDefault();

    const taskInputElement = document.querySelector("#task-input");

    let taskInputValue = taskInputElement.value;

    if (taskInputValue == "" || taskInputValue === undefined) {
        taskInputElement.classList.add("is-invalid");
        alertElement.innerHTML = alert("Task is required!");
    } else {
        taskInputElement.classList.remove("is-invalid");
        alertElement.innerHTML = "";

        const data = {
            task: taskInputValue,
            submit: 1
        };

        const response = await fetch("./api/add-task.php", {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();

        console.log(result);

        if (result.taskError) {
            taskInputElement.classList.add("is-invalid");
            alertElement.innerHTML = alert(result.taskError);
        } else if (result.success) {
            alertElement.innerHTML = alert(result.success, "success");
            taskInputElement.value = "";
            showTasks();
        } else if (result.failure) {
            alertElement.innerHTML = alert(result.failure);
        } else {
            alertElement.innerHTML = alert();
        }
    }
});

async function showTasks() {
    const tasksElement = document.querySelector("#tasks");

    const response = await fetch("./api/show-tasks.php");
    const result = await response.json();
    let rows = "";

    if (result.length !== 0) {
        result.forEach(function (value, index) {
            rows += `<div class="row mb-2">
                                            <div class="col-md">
                                                <input type="text" class="form-control" id="task-${value.id}" value="${value.task}" placeholder="Please enter the task!" readonly>
                                            </div>
                                            <div class="col-md-auto">
                                                <button class="btn btn-info" id="edit-${value.id}" onclick="editTask(${value.id})">Edit</button>
                                            </div>
                                            <div class="col-md-auto">
                                                <button class="btn btn-danger" id="delete-${value.id}" onclick="deleteTask(${value.id})">Delete</button>
                                            </div>
                                        </div>`;
        });
        tasksElement.innerHTML = rows;
    } else {
        tasksElement.innerHTML = `<div class="alert alert-info m-0">No record found!</div>`;
    }
}

async function deleteTask(id) {
    const data = {
        id: id
    };

    const response = await fetch("./api/delete-task.php", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    });

    const result = await response.json();

    console.log(result);

    if (result.success) {
        alertElement.innerHTML = alert(result.success, "success");
        showTasks();
    } else if (result.failure) {
        alertElement.innerHTML = alert(result.failure);
    } else {
        alertElement.innerHTML = alert();
    }
}

function alert(msg = "Something went wrong!", cls = "danger") {
    return `<div class="alert alert-${cls} alert-dismissible fade show" role="alert">
    ${msg}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
}