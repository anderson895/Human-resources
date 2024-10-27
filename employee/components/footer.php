
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

   <!-- Change Password Modal -->
   <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="changePasswordForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="oldPasswordInput" class="font-weight-bold">Old Password</label>
                        <div class="input-group">
                            <input type="password" name="oldPasswordInput" class="form-control" id="oldPasswordInput" required autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="input-group-text" id="toggleOldPassword">
                                    <i class="material-icons">visibility</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newPasswordInput" class="font-weight-bold">New Password</label>
                        <div class="input-group">
                            <input type="password" name="newPasswordInput" class="form-control" id="newPasswordInput" required autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="input-group-text" id="toggleNewPassword">
                                    <i class="material-icons">visibility</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPasswordInput" class="font-weight-bold">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="confirmPasswordInput" class="form-control" id="confirmPasswordInput" required autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="input-group-text" id="toggleConfirmPassword">
                                    <i id="v" class="material-icons">visibility</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="js/change_password.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>