<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ngrok -->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>iofrm</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/iofrm-theme4.css">
</head>

<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="<?= base_url('assets/') ?>images/logo-light.svg" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="<?= base_url('assets/') ?>images/graphic1.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Hubungkan Nomor Induk</h3>
                        <p>Silahkan masukan nomor induk anda untuk dihubungkan dengan akun siswa</p>
                        <form method="POST" action="<?php echo base_url(); ?>auth/linked_account">
                            <input class="form-control nomorinduk" type="number" name="nomorinduk" placeholder="Nomor induk siswa" required>
                            <div class="info"></div>
                            <div class="form-button full-width">
                                <button id="submit" type="submit" class="ibtn btn-forget">Kaitkan akun</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/') ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/popper.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/main.js"></script>
</body>

</html>

<script>
    $('.btn-forget').click(function(e) {
        e.preventDefault();
        var inputField = $('.nomorinduk').val();
        $('.info').html('<small class="error-message">Nomor induk harus 10 angka</small>');
        if (inputField.length != 10) {
            $('.info').html('<small class="error-message">Nomor induk harus 10 angka</small>');
        } else {
            $('.info').html('<small class="pending-message">Mohon tunggu, sedang di proses</small>')
            $(this).html('proses..')

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>ajax/linked_nis",
                data: {
                    nomorinduk: inputField,
                },
                dataType: 'json',
                process: function() {},
                success: function(data) {
                    if (data == 'already') {
                        $('.info').html('<small class="error-message">Nomor induk tersebut salah atau sudah terkait akun</small>');
                        $('.btn-forget').html('Kaitkan akun')
                    } else if (data == 'success') {
                        $('.error-message').remove();
                        $('.form-items', '.form-content').addClass('hide-it');
                        $('.form-sent', '.form-content').addClass('show-it');

                        // Redirect to linked_proccess page with the 'nis' parameter
                        window.location.href = "<?php echo base_url(); ?>student/auth/linked_proccess?nis=" + inputField;
                    }
                },
                error: function() {
                    $('.modal-body').html('Kesalahan system')
                }
            });
        }
    });
</script>