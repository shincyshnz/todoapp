// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()


function fetchTaskData(taskId) {
    $.ajax({
        url: '/fetch/',
        method: 'get',
        data: { taskId: taskId },
        success: function (response) {
            $('#task-name-edit').val(response.taskInfo.name);
            $('#task-description-edit').val(response.taskInfo.description);
            $('#hidden-id').val(response.taskInfo.id);
        }
    });

}



const editButton = document.querySelectorAll('[data-edit-id]');
editButton.forEach(btn => {
    btn.addEventListener('click', (e) => {
        let taskId = e.target.getAttribute('data-edit-id');
        fetchTaskData(taskId);
    });
});

const deleteButton = document.querySelectorAll('[data-delete-id]');
deleteButton.forEach(btn => {
    btn.addEventListener('click', (e) => {
        let taskId = e.target.getAttribute('data-delete-id');
        document.getElementById('hidden-id-delete').setAttribute('value', taskId);
    });
});

document.getElementById('save-change').addEventListener('click', () => {
    let taskName = $('#task-name-edit').val();
    let taskDescription = $('#task-description-edit').val();
    let hiddenId = $('#hidden-id').val();

    if (taskName == '' || taskName.length < 5) {
        errorTaskName = 'please enter Task Name with minimum 3 characters';
        $('#task-name-span').text(errorTaskName);
    }
    else if (taskDescription == '') {
        errorTaskDes = 'please enter Task Description';
        $('#task-description-span').text(errorTaskDes);
    }
    else {
        $.ajax({
            url: '/update',
            method: 'post',
            data:
            {
                name: taskName,
                description: taskDescription,
                taskId: hiddenId
            },
            success: function (response) {
                $('#myModal').modal('hide');
                $('#myModalSuccess').modal('show');
                window.location.href = '/'
            }
        });
    }
});

document.getElementById('delete-alert').addEventListener('click', () => {
    let hiddenId = $('#hidden-id-delete').val();

    $.ajax({
        url: '/delete',
        method: 'post',
        data:
        {
            taskId: hiddenId
        },
        success: function (response) {
            $('#delete-alert').modal('hide');
            window.location.href = '/'
        }
    });
});








