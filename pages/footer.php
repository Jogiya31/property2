<!-- jQuery 2.2.3 -->
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- bootstrap datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<!-- Session Manager - Auto-Logout Handler -->
<script src="../js/session-manager.js"></script>

<script>
    $(function() {

        //Date picker
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });
       
    });

    function showAlert(message, type = 'success') {
        const msgDiv = document.getElementById('msg');
        if (!msgDiv) return;

        // Limit number of alerts (optional but recommended)
        const maxAlerts = 3;
        if (msgDiv.children.length >= maxAlerts) {
            msgDiv.removeChild(msgDiv.firstChild);
        }

        // Create alert
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.role = "alert";

        alert.innerHTML = `
        ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        msgDiv.appendChild(alert);

        // Auto close after 5 sec (better UX than 10s)
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('fade');

            // Remove from DOM after animation
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 6000);
    }
</script>