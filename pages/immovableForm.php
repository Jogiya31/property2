<!DOCTYPE html>
<html>

<?php require 'head.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php require 'header.php'; ?>
        <!-- =============================================== -->

        <?php require 'sidebar.php'; ?>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Immovable Property
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>New Request</li>
                    <li class="active">Immovable property</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <form role="form">
                    <div class=" text-center">
                        <h5 class="fw-bold text-uppercase">Property transaction for immovable property</h5>
                        <small class="text-muted">(Prior intimation / Seeking sanction under Rule 18 (2) of the CCS (Conduct) Rules, 1964)</small>
                    </div>

                    <div class="box box-primary">
                        <!-- form start -->
                        <div class="box-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="required-label">Purpose of application</label>
                                        <select class="form-control required-label" name="purpose" required>
                                            <option value="">Select...</option>
                                            <option value="Sanction for transaction">Sanction for transaction</option>
                                            <option value="Prior intimation of Transaction">Prior intimation of Transaction</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="required-label">Acquired or Disposed</label>
                                        <select name="acquired_disposed" class="form-control" required>
                                            <option value="">Select...</option>
                                            <option value="acquired">Acquired</option>
                                            <option value="disposed">Disposed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none" id="mode_acquisition">
                                    <div class="form-group">
                                        <label class="required-label">Mode of acquisition</label>
                                        <select name="mode_acquisition" class="form-control" required>
                                            <option value="">Select...</option>
                                            <option value="Purchase">Purchase</option>
                                            <option value="Gift">Gift</option>
                                            <option value="Mortgage">Mortgage</option>
                                            <option value="Lease">Lease</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none" id="mode_disposal">
                                    <div class="form-group">
                                        <label class="required-label">Mode of disposal</label>
                                        <select name="mode_disposal" class="form-control" required>
                                            <option value="">Select...</option>
                                            <option value="Sale">Sale</option>
                                            <option value="Gift">Gift</option>
                                            <option value="Mortgage">Mortgage</option>
                                            <option value="Lease">Lease</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none" id="date_acq_dis">
                                    <div class="form-group">
                                        <label class="required-label" id="date_acquisition_disposed">Probable date of acquisition/disposal </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right datepicker" id="datepicker" name="date_acquisition_disposed" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </form>
                <!-- /.form -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <?php require 'footer.php'; ?>
    <script src="js/immovable.js"></script>

</body>

</html>