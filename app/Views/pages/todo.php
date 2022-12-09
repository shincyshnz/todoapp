<div class="container-fluid">
    <nav class="navbar navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url(); ?>/assets/images/tasks-boss-svgrepo-com.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
                To Do App
            </a>
        </div>
    </nav>

    <div class="container d-flex flex-sm-column">
        <form class="row needs-validation" novalidate action="<?= base_url(); ?>" method="post" accept-charset="utf-8">
            <div class="row mt-3">
                <div class="col-12 ">
                    <input class="form-control" type="text" name="task-name" value="<?= set_value('task-name') ?>" id="task-name" placeholder="Task Name" aria-label="Task Name" required>

                    <?php if (isset($validation) && $validation->hasError('task-name')) : ?>
                        <span class="text-danger"><?= $validation->getError('task-name'); ?></span>
                    <?php endif ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">

                    <textarea class="form-control" name="task-description" value="<?= set_value('task-description'); ?>" id="floatingTextarea" style="height: 5em;" placeholder="Description" required><?php if (isset($textarea)) : echo  $textarea; ?><?php endif ?></textarea>

                    <?php if (isset($validation) && $validation->hasError('task-description')) : ?> <span class="text-danger"><?= $validation->getError('task-description'); ?></span>
                    <?php endif ?>
                </div>
                <div class=" col-12 mt-3 text-center">
                    <button class="btn btn-outline-primary px-5" type="submit">Add Task</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container d-flex flex-wrap align-content-center justify-content-center mt-5 gap-2">
        <?php if (!empty($taskData)) : ?>
            <?php foreach ($taskData as $task) : ?>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $task['name']; ?></h5>
                        <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                        <p class="card-text"><?= $task['description']; ?></p>
                        <button type="button" data-edit-id="<?= $task['id']; ?>" class=" btn btn-outline-success card-link" data-bs-toggle="modal" data-bs-target="#myModal">Edit</button>
                        <button type="button" data-delete-id="<?= $task['id']; ?>" class="btn btn-outline-danger card-link" data-bs-toggle="modal" data-bs-target="#delete-alert">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="container">
                <p class="text-grey">No Tasks to Display</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Task Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="inputs" class="needs-validation" novalidate="" action="<?= base_url(); ?>/update" method="post">
                        <div class="form-group mx-2 mb-3">
                            <label for="task-name">Task Name</label>
                            <input type="text" class="form-control" id="task-name-edit" placeholder="Task name" required>
                            <span class="text-danger" id="task-name-span"></span>
                        </div>
                        <div class=" form-group mx-2">
                            <label for="task-description">Task Description</label>
                            <textarea class="form-control" id="task-description-edit" placeholder="Task Description" required></textarea>
                            <span class="text-danger" id="task-description-span"></span>
                        </div>
                        <input type="hidden" id="hidden-id">
                    </form>
                </div>

                <!-- Modal footer -->
                <div class=" modal-footer justify text-14">
                    <button id="save-change" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalForm">Save Changes</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Alert -->

    <div class="modal" id="delete-alert">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-danger">Are you sure you want to delete?</p>
                </div>
                <input type="hidden" id="hidden-id-delete">
                <!-- Modal footer -->
                <div class=" modal-footer justify text-14">
                    <button id="delete-task" type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-alert">Delete</button>
                </div>
            </div>
        </div>
    </div>