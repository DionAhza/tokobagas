// Tombol lihat/sembunyikan password
document.querySelectorAll('[data-toggle-pw]').forEach(function (b) {
  b.addEventListener('click', function () {
    var i = document.getElementById(b.dataset.togglePw);
    var tampil = i.type === 'password';
    i.type = tampil ? 'text' : 'password';
    b.textContent = tampil ? 'Sembunyikan' : 'Lihat';
    b.setAttribute('aria-pressed', tampil);
  });
});
// Konfirmasi sebelum hapus
document.querySelectorAll('form[data-confirm]').forEach(function (f) {
  f.addEventListener('submit', function (e) {
    if (!confirm(f.dataset.confirm)) e.preventDefault();
  });
});
// Pratinjau gambar yang dipilih
var fi = document.querySelector('[data-preview]');
if (fi) fi.addEventListener('change', function () {
  var t = document.getElementById(fi.dataset.preview), f = fi.files[0];
  if (f && t) { t.src = URL.createObjectURL(f); t.hidden = false; }
});
