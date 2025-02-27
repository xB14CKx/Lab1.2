<?php
session_start();
include 'database/database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailing</title>
    <link rel="stylesheet" href="statics/css/bootstrap.css">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="statics/js/bootstrap.bundle.js"></script>

</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-4">
            <div class="row mb-4">

                <p class="display-5 fw-bold text-center"> <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3.5 5.5l1.5 1.5l2.5 -2.5" />
                        <path d="M3.5 11.5l1.5 1.5l2.5 -2.5" />
                        <path d="M3.5 17.5l1.5 1.5l2.5 -2.5" />
                        <path d="M11 6l9 0" />
                        <path d="M11 12l9 0" />
                        <path d="M11 18l9 0" />
                    </svg>Detailing</p>
            </div>
            <div class="row">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
                <form id="infoForm" action="handlers/add_info_handler.php" method="POST">
                    <div class="form-group mb-3">
                        <label for="fname">First Name:</label>
                        <input type="text" class="form-control" id="fname" name="fname">
                    </div>
                    <div class="form-group mb-3">
                        <label for="mname">Middle Name:</label>
                        <input type="text" class="form-control" id="mname" name="mname">
                    </div>
                    <div class="form-group mb-3">
                        <label for="lname">Last Name:</label>
                        <input type="text" class="form-control" id="lname" name="lname">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                    <div class="form-group mb-3">
                        <label for="bgry">Barangay:</label>
                        <input type="text" class="form-control" id="bgry" name="bgry">
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary mt-3" onclick="validateAndShowModal()"> <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-world-up">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20.985 12.52a9 9 0 1 0 -8.451 8.463" />
                                <path d="M3.6 9h16.8" />
                                <path d="M3.6 15h10.9" />
                                <path d="M11.5 3a17 17 0 0 0 0 18" />
                                <path d="M12.5 3a16.996 16.996 0 0 1 2.391 11.512" />
                                <path d="M19 22v-6" />
                                <path d="M22 19l-3 -3l-3 3" />
                            </svg> Submit</button>
                        <button type="button" class="btn btn-warning mt-3" onclick="showEditModal()"> <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg> Edit</button>
                        <button type="button" class="btn btn-secondary mt-3" data-bs-toggle="modal"
                            data-bs-target="#grabDetailsModal"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-hand-grab">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 11v-3.5a1.5 1.5 0 0 1 3 0v2.5" />
                                <path d="M11 9.5v-3a1.5 1.5 0 0 1 3 0v3.5" />
                                <path d="M14 7.5a1.5 1.5 0 0 1 3 0v2.5" />
                                <path
                                    d="M17 9.5a1.5 1.5 0 0 1 3 0v4.5a6 6 0 0 1 -6 6h-2h.208a6 6 0 0 1 -5.012 -2.7l-.196 -.3c-.312 -.479 -1.407 -2.388 -3.286 -5.728a1.5 1.5 0 0 1 .536 -2.022a1.867 1.867 0 0 1 2.28 .28l1.47 1.47" />
                            </svg> Grab Details</button>
                        <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal"
                            data-bs-target="#deleteModal"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-backspace">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M20 5a2 2 0 0 1 1.995 1.85l.005 .15v10a2 2 0 0 1 -1.85 1.995l-.15 .005h-11a1 1 0 0 1 -.608 -.206l-.1 -.087l-5.037 -5.04c-.809 -.904 -.847 -2.25 -.083 -3.23l.12 -.144l5 -5a1 1 0 0 1 .577 -.284l.131 -.009h11zm-7.489 4.14a1 1 0 0 0 -1.301 1.473l.083 .094l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.403 1.403l.094 -.083l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.403 -1.403l-.083 -.094l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.403 -1.403l-.094 .083l-1.293 1.292l-1.293 -1.292l-.094 -.083l-.102 -.07z" />
                            </svg> Delete</button>
                        <a href="handlers/logout.php" class="btn btn-danger mt-3"> <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg> Logout</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitModalLabel">Confirm Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>First Name:</strong> <span id="modalFname"></span></p>
                    <p><strong>Middle Name:</strong> <span id="modalMname"></span></p>
                    <p><strong>Last Name:</strong> <span id="modalLname"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>City:</strong> <span id="modalCity"></span></p>
                    <p><strong>Barangay:</strong> <span id="modalBgry"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="grabDetailsModal" tabindex="-1" aria-labelledby="grabDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" onsubmit="fetchDetails(event)">
                    <div class="modal-header">
                        <h5 class="modal-title" id="grabDetailsModalLabel">Edit Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName">First Name:</label>
                            <input type="text" class="form-control" id="editName" name="editName">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Fetch Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editConfirmModal" tabindex="-1" aria-labelledby="editConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConfirmModalLabel">Confirm Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>First Name:</strong> <span id="editModalFname"></span></p>
                    <p><strong>Middle Name:</strong> <span id="editModalMname"></span></p>
                    <p><strong>Last Name:</strong> <span id="editModalLname"></span></p>
                    <p><strong>Email:</strong> <span id="editModalEmail"></span></p>
                    <p><strong>City:</strong> <span id="editModalCity"></span></p>
                    <p><strong>Barangay:</strong> <span id="editModalBgry"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitEdit()">Confirm Edit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="handlers/delete_info_handler.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="deleteName">Name:</label>
                            <input type="text" class="form-control" id="deleteName" name="deleteName">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="showDeleteConfirmModal()">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateAndShowModal() {
            var fname = document.getElementById('fname').value;
            var mname = document.getElementById('mname').value;
            var lname = document.getElementById('lname').value;
            var email = document.getElementById('email').value;
            var city = document.getElementById('city').value;
            var bgry = document.getElementById('bgry').value;

            if (!fname || !mname || !lname || !email || !city || !bgry) {
                alert('All fields are required.');
                return;
            }

            document.getElementById('modalFname').innerText = fname;
            document.getElementById('modalMname').innerText = mname;
            document.getElementById('modalLname').innerText = lname;
            document.getElementById('modalEmail').innerText = email;
            document.getElementById('modalCity').innerText = city;
            document.getElementById('modalBgry').innerText = bgry;

            var submitModal = new bootstrap.Modal(document.getElementById('submitModal'));
            submitModal.show();
        }

        function submitForm() {
            document.getElementById('infoForm').submit();
        }

        function fetchDetails(event) {
            event.preventDefault();
            var editName = document.getElementById('editName').value;
            if (!editName.trim()) {
                alert("Please enter a name to fetch details.");
                return;
            }

            fetch('handlers/get_details.php?name=' + encodeURIComponent(editName))
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById('fname').value = data.fname;
                        document.getElementById('mname').value = data.mname;
                        document.getElementById('lname').value = data.lname;
                        document.getElementById('email').value = data.email;
                        document.getElementById('city').value = data.city;
                        document.getElementById('bgry').value = data.bgry;

                        var grabDetailsModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('grabDetailsModal'));
                        grabDetailsModal.hide();
                    }
                })
                .catch(error => {
                    console.error('Error fetching details:', error);
                    alert('Failed to fetch details.');
                });
        }

        function showEditModal() {
            var fname = document.getElementById('fname').value;
            var mname = document.getElementById('mname').value;
            var lname = document.getElementById('lname').value;
            var email = document.getElementById('email').value;
            var city = document.getElementById('city').value;
            var bgry = document.getElementById('bgry').value;

            if (!fname || !mname || !lname || !email || !city || !bgry) {
                alert('All fields are required before editing.');
                return;
            }

            document.getElementById('editModalFname').innerText = fname;
            document.getElementById('editModalMname').innerText = mname;
            document.getElementById('editModalLname').innerText = lname;
            document.getElementById('editModalEmail').innerText = email;
            document.getElementById('editModalCity').innerText = city;
            document.getElementById('editModalBgry').innerText = bgry;

            var editConfirmModal = new bootstrap.Modal(document.getElementById('editConfirmModal'));
            editConfirmModal.show();
        }

        function submitEdit() {
            var editConfirmModal = bootstrap.Modal.getInstance(document.getElementById('editConfirmModal'));
            if (editConfirmModal) {
                editConfirmModal.hide();
            }

            setTimeout(() => {
                var formData = new FormData(document.getElementById('infoForm'));
                fetch('handlers/edit_info_handler.php', {
                    method: 'POST',
                    body: formData
                }).then(() => {
                    document.getElementById('infoForm').reset();
                    window.location.reload();
                });
            }, 300);
        }


        function showDeleteConfirmModal() {
            var deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteConfirmModal.show();
        }

        function confirmDelete() {
            var deleteConfirmModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
            if (deleteConfirmModal) {
                deleteConfirmModal.hide();
            }
            setTimeout(() => {
                document.querySelector("#deleteModal form").submit();
            }, 300);
        }
    </script>
</body>

</html>