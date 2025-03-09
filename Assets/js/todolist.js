document.addEventListener('DOMContentLoaded', function () {
    const taskList = document.getElementById('myUL');
    const inputField = document.getElementById('myInput');
    const addButton = document.querySelector('.addBtn');
    const exportButton = document.getElementById('exportTasks');
    const importForm = document.getElementById('importForm');

    function loadTasks() {
        fetch('../index.php?action=getTasks')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    taskList.innerHTML = '';
                    data.tasks.forEach(task => {
                        addTaskToList(task.id, task.task, task.is_completed);
                    });
                } else {
                    alert('Failed to load tasks');
                }
            })
            .catch(() => alert('An error occurred while loading tasks'));
    }

    function addTaskToList(taskId, taskText, isCompleted) {
        const li = document.createElement('li');
        li.textContent = taskText;
        li.setAttribute('data-task-id', taskId);
        if (isCompleted) {
            li.classList.add('completed');
            li.classList.add('checked');
        }
        taskList.appendChild(li);
        const deleteButton = document.createElement('span');
        deleteButton.textContent = '\u00D7';
        deleteButton.className = 'close';
        li.appendChild(deleteButton);

        deleteButton.addEventListener('click', function () {
            deleteTask(taskId, li);
        });
    }

    function addNewTask(taskText) {
        fetch('../index.php?action=addTask', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ task: taskText }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    addTaskToList(data.task_id, taskText, false);
                } else {
                    alert('Failed to add task');
                }
            })
            .catch(() => alert('An error occurred while adding task'));
    }

    function deleteTask(taskId, taskElement) {
        fetch('../index.php?action=deleteTask', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ task_id: taskId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    taskList.removeChild(taskElement);
                } else {
                    alert('Failed to delete task');
                }
            })
            .catch(() => alert('An error occurred while deleting task'));
    }

    taskList.addEventListener('click', function (event) {
        if (event.target.tagName === 'LI') {
            const taskId = event.target.getAttribute('data-task-id');
            const isCompleted = event.target.classList.toggle('completed');
            event.target.classList.toggle('checked');
            fetch('../index.php?action=updateTask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    task_id: taskId,
                    is_completed: isCompleted ? 1 : 0,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update task status');
                        event.target.classList.toggle('completed');
                        event.target.classList.toggle('checked');
                    }
                })
                .catch(() => {
                    alert('An error occurred');
                    event.target.classList.toggle('completed');
                    event.target.classList.toggle('checked');
                });
        }
    });

    if (addButton) {
        addButton.addEventListener('click', function () {
            const taskText = inputField.value.trim();
            if (taskText === '') {
                alert('Task cannot be empty');
                return;
            }
            addNewTask(taskText);
            inputField.value = '';
        });
    }

    if (exportButton) {
        exportButton.addEventListener('click', function () {
            fetch('../index.php?action=exportTasks')
                .then(response => response.json())
                .then(tasks => {
                    const blob = new Blob([JSON.stringify(tasks, null, 2)], { type: 'application/json' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'tasks.json';
                    a.click();
                    URL.revokeObjectURL(url);
                })
                .catch(() => alert('An error occurred while exporting tasks'));
        });
    }

    if (importForm) {
        importForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const fileInput = document.getElementById('importFile');
            const file = fileInput?.files[0];
            if (!file) {
                alert('Please select a file to import');
                return;
            }
            const formData = new FormData();
            formData.append('file', file);
            fetch('../index.php?action=importTasks', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadTasks();
                    } else {
                        alert('Failed to import tasks');
                    }
                })
                .catch(() => alert('An error occurred while importing tasks'));
        });
    }
    loadTasks();
});
