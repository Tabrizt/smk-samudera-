<?= $this->extend("layouts/master_app") ?>

<?= $this->section("content") ?>
<!-- Main content -->

<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h4 class="box-title text-capitalize">Data siswa</h4>
      <button type="button" class="btn float-end btn-primary btn-sm" onclick="save()" title="<?= lang("App.new") ?>"> <?= lang('App.new') ?></button>
    </div>
    <div class="box-body">
      <table id="data_table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama siswa</th>
            <th>Id kelas</th>
            <th>Nisn</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Foto profil</th>
            <th>Password</th>
            <th>Created at</th>
            <th>Updated at</th>

            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</section>

<!-- /Main content -->

<!-- ADD modal content -->
<div id="data-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="text-center bg-info p-3" id="model-header">
        <h4 class="modal-title text-white" id="info-header-modalLabel"></h4>
      </div>
      <div class="modal-body">
        <form id="data-form" class="pl-3 pr-3">
          <?= csrf_field() ?>
          <div class="row">
            <input type="hidden" id="id" name="id" class="form-control" placeholder="Id" maxlength="11" required>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="nama_siswa" class="col-form-label"> Nama siswa: <span class="text-danger">*</span> </label>
                <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" placeholder="Nama siswa" minlength="0" maxlength="200" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="id_kelas" class="col-form-label"> Id kelas: <span class="text-danger">*</span> </label>
                <input type="number" id="id_kelas" name="id_kelas" class="form-control" placeholder="Id kelas" minlength="0" maxlength="11" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="nisn" class="col-form-label"> Nisn: <span class="text-danger">*</span> </label>
                <input type="text" id="nisn" name="nisn" class="form-control" placeholder="Nisn" minlength="0" maxlength="12" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="alamat" class="col-form-label"> Alamat: <span class="text-danger">*</span> </label>
                <textarea cols="40" rows="5" id="alamat" name="alamat" class="form-control" placeholder="Alamat" minlength="0" required></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="email" class="col-form-label"> Email: <span class="text-danger">*</span> </label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" minlength="0" maxlength="200" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="foto_profil" class="col-form-label"> Foto profil: <span class="text-danger">*</span> </label>
                <input type="text" id="foto_profil" name="foto_profil" class="form-control" placeholder="Foto profil" minlength="0" maxlength="200" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="password" class="col-form-label"> Password: <span class="text-danger">*</span> </label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" minlength="0" maxlength="200" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="created_at" class="col-form-label"> Created at: <span class="text-danger">*</span> </label>
                <input type="date" id="created_at" name="created_at" class="form-control" dateISO="true" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="updated_at" class="col-form-label"> Updated at: <span class="text-danger">*</span> </label>
                <input type="date" id="updated_at" name="updated_at" class="form-control" dateISO="true" required>
              </div>
            </div>
          </div>

          <div class="form-group text-center">
            <div class="btn-group">
              <button type="submit" class="btn btn-success mr-2" id="form-btn"><?= lang("App.save") ?></button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang("App.cancel") ?></button>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- /ADD modal content -->


<?= $this->endSection() ?>
<!-- page script -->
<?= $this->section("script") ?>
<script>
  let csrfHash = '<?= csrf_hash(); ?>'
  let csrfToken = '<?= csrf_token(); ?>'
  // dataTables
  $(function() {
    var table = $('#data_table').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scrollY": '45vh',
      "scrollX": true,
      "scrollCollapse": false,
      "responsive": false,
      "ajax": {
        "url": '<?php echo base_url($controller . "/getAll") ?>',
        "type": "POST",
        "dataType": "json",
        async: "true"
      }
    });
  });

  var urlController = '';
  var submitText = '';

  function getUrl() {
    return urlController;
  }

  function getSubmitText() {
    return submitText;
  }

  function save(id) {
    // reset the form 
    $("#data-form")[0].reset();
    $(".form-control").removeClass('is-invalid').removeClass('is-valid');
    if (typeof id === 'undefined' || id < 1) { //add
      urlController = '<?= base_url($controller . "/add") ?>';
      submitText = '<?= lang("App.save") ?>';
      $("#info-header-modalLabel").text('<?= lang("App.add") ?>');
      $("#form-btn").text(submitText);
      $('#data-modal').modal('show');
    } else { //edit
      urlController = '<?= base_url($controller . "/edit") ?>';
      submitText = '<?= lang("App.update") ?>';
      $.ajax({
        url: '<?= base_url($controller . "/getOne") ?>',
        type: 'post',
        data: {
          id: id,
          [csrfToken]: csrfHash
        },
        dataType: 'json',
        success: function(response) {
          $("#info-header-modalLabel").text('<?= lang("App.edit") ?>');
          $("#form-btn").text(submitText);
          $('#data-modal').modal('show');
          //insert data to form
          $("#data-form #id").val(response.id);
          $("#data-form #nama_siswa").val(response.nama_siswa);
          $("#data-form #id_kelas").val(response.id_kelas);
          $("#data-form #nisn").val(response.nisn);
          $("#data-form #alamat").val(response.alamat);
          $("#data-form #email").val(response.email);
          $("#data-form #foto_profil").val(response.foto_profil);
          $("#data-form #password").val(response.password);
          $("#data-form #created_at").val(response.created_at);
          $("#data-form #updated_at").val(response.updated_at);


        }
      });
    }
    $.validator.setDefaults({
      highlight: function(element) {
        $(element).addClass('is-invalid').removeClass('is-valid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid').addClass('is-valid');
      },
      errorElement: 'div ',
      errorClass: 'invalid-feedback',
      errorPlacement: function(error, element) {
        if (element.parent('.input-group').length) {
          error.insertAfter(element.parent());
        } else if ($(element).is('.select')) {
          element.next().after(error);
        } else if (element.hasClass('select2')) {
          //error.insertAfter(element);
          error.insertAfter(element.next());
        } else if (element.hasClass('selectpicker')) {
          error.insertAfter(element.next());
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form) {
        var form = $('#data-form');
        $(".text-danger").remove();
        $.ajax({
          // fixBug get url from global function only
          // get global variable is bug!
          url: getUrl(),
          type: 'post',
          data: form.serialize(),
          cache: false,
          dataType: 'json',
          beforeSend: function() {
            $('#form-btn').html('<i class="fad fa-spinner fa-spin"></i>');
          },
          success: function(response) {
            if (response.success === true) {
              $('#data-modal').modal('hide');
              Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: response.messages,
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
              })
            } else {
              if (response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var ele = $("#" + index);
                  ele.closest('.form-control')
                    .removeClass('is-invalid')
                    .removeClass('is-valid')
                    .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
                  ele.after('<div class="invalid-feedback">' + response.messages[index] + '</div>');
                });
              } else {
                Swal.fire({
                  toast: false,
                  position: 'bottom-end',
                  icon: 'error',
                  title: response.messages,
                  showConfirmButton: false,
                  timer: 3000
                })

              }
            }
            $('#form-btn').html(getSubmitText());
          }
        }).fail(function(res) {
          console.log(res);
        });
        return false;
      }
    });

    $('#data-form').validate({

      //insert data-form to database

    });
  }

  function remove(id) {
    Swal.fire({
      title: "<?= lang("App.remove-title") ?>",
      text: "<?= lang("App.remove-text") ?>",
      icon: 'warning',
      showCancelButton: true,
      showClass: {
        popup: 'animate__animated animate__fadeInDown'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
      },
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<?= lang("App.confirm") ?>',
      cancelButtonText: '<?= lang("App.cancel") ?>'
    }).then((result) => {

      if (result.value) {
        $.ajax({
          url: '<?php echo base_url($controller . "/remove") ?>',
          type: 'post',
          data: {
            id: id,
            [csrfToken]: csrfHash
          },
          dataType: 'json',
          success: function(response) {
            if (response.success === true) {
              Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: response.messages,
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
              })
            } else {
              Swal.fire({
                toast: false,
                position: 'bottom-end',
                icon: 'error',
                title: response.messages,
                showConfirmButton: false,
                timer: 3000
              })
            }
          }
        });
      }
    })
  }
</script>


<?= $this->endSection() ?>