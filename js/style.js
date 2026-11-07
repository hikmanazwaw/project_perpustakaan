document.addEventListener('DOMContentLoaded', function () {
  // Tampilkan/sembunyikan password
  var toggle = document.getElementById('togglePassword');
  if (toggle) {
    toggle.addEventListener('click', function () {
      var pw = document.getElementById('password');
      var icon = this.querySelector('i');
      var show = pw.type === 'password';
      pw.type = show ? 'text' : 'password';
      icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
  }

  // Alert otomatis hilang
  document.querySelectorAll('.auto-dismiss').forEach(function (el) {
    setTimeout(function () { bootstrap.Alert.getOrCreateInstance(el).close(); }, 4000);
  });

  // Konfirmasi hapus
  document.querySelectorAll('.form-hapus').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!confirm('Hapus buku "' + this.dataset.judul + '"? Data dan file sampul akan dihapus permanen.')) e.preventDefault();
    });
  });

  // Modal sampul besar
  var modal = document.getElementById('modalSampul');
  if (modal) {
    modal.addEventListener('show.bs.modal', function (ev) {
      document.getElementById('imgSampulBesar').src = ev.relatedTarget.dataset.src;
    });
  }

  // Preview status berdasarkan stok
  var stok = document.getElementById('stok'), prev = document.getElementById('previewStatus');
  function updStatus() {
    if (!stok || !prev) return;
    var v = parseInt(stok.value, 10);
    if (isNaN(v)) { prev.textContent = '-'; prev.className = 'fw-bold'; return; }
    prev.textContent = v > 0 ? 'Tersedia' : 'Dipinjam';
    prev.className = 'fw-bold ' + (v > 0 ? 'text-success' : 'text-danger');
  }
  if (stok) { stok.addEventListener('input', updStatus); updStatus(); }

  // Validasi file di sisi klien + preview
  var file = document.getElementById('sampul');
  if (file) {
    file.addEventListener('change', function () {
      var f = this.files[0], img = document.getElementById('previewSampul');
      if (!f) return;
      var okTipe = ['image/jpeg', 'image/png'].indexOf(f.type) !== -1;
      if (!okTipe) { alert('Format file harus JPG atau PNG.'); this.value = ''; return; }
      if (f.size > 2 * 1024 * 1024) { alert('Ukuran file maksimal 2 MB.'); this.value = ''; return; }
      img.src = URL.createObjectURL(f);
      img.classList.remove('d-none');
    });
  }

  // Validasi form sederhana
  var form = document.getElementById('formBuku');
  if (form) {
    form.addEventListener('submit', function (e) {
      var kosong = Array.from(form.querySelectorAll('[required]')).some(function (el) { return !el.value.trim(); });
      if (kosong) { e.preventDefault(); alert('Semua field wajib diisi.'); }
    });
  }
});
