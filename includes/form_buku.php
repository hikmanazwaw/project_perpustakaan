<?php
// Variabel: $aksi, $data (array), $errors (array), $tombol, $id (opsional)
?>
<?php if (!empty($errors)): ?>
  <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>
<form action="<?= e($aksi) ?>" method="POST" enctype="multipart/form-data" id="formBuku" novalidate>
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
  <?php if (!empty($id)): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif; ?>
  <div class="row g-3">
    <div class="col-md-8">
      <div class="mb-3">
        <label class="form-label">Judul Buku</label>
        <input type="text" name="judul" class="form-control" maxlength="200" value="<?= e($data['judul']) ?>" required>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Kategori</label>
          <select name="kategori" class="form-select" required>
            <option value="">-- Pilih --</option>
            <?php foreach (daftar_kategori() as $k): ?>
              <option value="<?= e($k) ?>" <?= $data['kategori'] === $k ? 'selected' : '' ?>><?= e($k) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Penulis</label>
          <input type="text" name="penulis" class="form-control" value="<?= e($data['penulis']) ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Tahun Terbit</label>
          <input type="number" name="tahun_terbit" class="form-control" min="1900" max="<?= date('Y') + 1 ?>" value="<?= e($data['tahun_terbit']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Stok (Status Ketersediaan)</label>
          <input type="number" name="stok" id="stok" class="form-control" min="0" value="<?= e($data['stok']) ?>" required>
          <div class="form-text">Stok &gt; 0 = <span class="text-success fw-semibold">Tersedia</span>, 0 = <span class="text-danger fw-semibold">Dipinjam</span>. Status: <span id="previewStatus" class="fw-bold"></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <label class="form-label">Sampul Buku (.jpg/.png, maks 2MB)</label>
      <input type="file" name="sampul" id="sampul" class="form-control" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
      <div class="mt-3 text-center">
        <?php $adaGambar = !empty($data['sampul']) && is_file(UPLOAD_DIR . $data['sampul']); ?>
        <img id="previewSampul" src="<?= $adaGambar ? 'uploads/' . e($data['sampul']) : '' ?>" class="img-fluid rounded border preview-cover <?= $adaGambar ? '' : 'd-none' ?>" alt="Preview">
        <?php if (!empty($id)): ?><div class="form-text">Kosongkan jika tidak ingin mengganti sampul.</div><?php endif; ?>
      </div>
    </div>
  </div>
  <hr>
  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> <?= e($tombol) ?></button>
    <a href="dashboard.php" class="btn btn-outline-secondary">Batal</a>
  </div>
</form>
