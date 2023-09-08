<?= $this->extend('layouts/master_app'); ?>

<?= $this->section('content'); ?>
<section class="content">
  <div class="row">
    <div class="col-3">
      <div class="card border-0">
        <div class="card-body">
          <h3>Admin</h3>
          <p><?= $admin; ?></p>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card border-0">
        <div class="card-body">
          Guru
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card border-0">
        <div class="card-body">
          Siswa
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card border-0">
        <div class="card-body">
          Jurusan
        </div>
      </div>
    </div>
  </div>
  <div class="box">

  </div>
</section>
<?= $this->endSection(); ?>