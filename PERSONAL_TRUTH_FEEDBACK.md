# 🚨 AUDIT KODE & UMPAN BALIK KRITIS: SIM INVENTARIS

**Tanggal Audit:** 24 Desember 2025  
**Auditor:** Antigravity (AI Advisor)  
**Status:** ⚠️ PERLU PERBAIKAN SEGERA

---

## 🛑 RINGKASAN EKSEKUTIF
Jangan tertipu oleh tampilan antarmuka yang bagus atau diagram HTML yang rapi. Secara arsitektur, kode ini memiliki cacat fundamental yang membuatnya **tidak layak untuk lingkungan produksi multi-user**. Jika sistem ini digunakan oleh lebih dari satu orang secara bersamaan, integritas data akan hancur.

Dokumen ini membedah kelemahan logika, risiko keamanan data (race condition), dan praktik *clean code* yang diabaikan.

---

## 1. 💣 CRITICAL: Race Condition pada Generator Kode (`ConsumableController`)

**Lokasi:** `app\Http\Controllers\ConsumableController.php` (Baris 111-128)

### Isu
Anda menggunakan pola *Check-Then-Act* yang naif untuk membuat nomor urut batch (`.../001`, `.../002`).
```php
$counter = ConsumableDetail::where('consumable_id', $consumable->id)->count() + 1;
do {
    // ...
    $exists = ConsumableDetail::where('batch_code', $code)->exists();
} while ($exists);
```

### Mengapa Ini Berbahaya?
Dalam lingkungan nyata, dua request bisa masuk di milidetik yang sama:
1. **Request A** menghitung jumlah: 50.
2. **Request B** menghitung jumlah: 50 (karena A belum selesai simpan).
3. **Request A** generate kode `.../051` -> Cek DB -> Kosong -> **OK**.
4. **Request B** generate kode `.../051` -> Cek DB -> Kosong -> **OK**.
5. Keduanya mencoba `INSERT` ke database.
   - **Skenario Terbaik:** Salah satu error (crash/500 Internal Server Error) karena *Unique Constraint*.
   - **Skenario Terburuk:** Jika tidak ada unique index di DB, Anda punya data duplikat yang merusak stok.

### Solusi
1. **DB Transaction & Locking:** Gunakan `DB::transaction()` dan `lockForUpdate()` saat membaca counter terakhir.
2. **Auto-Increment Database:** Biarkan database yang mengurus urutan ID, lalu format saat display.

---

## 2. 🏗️ ARCHITECTURE: Business Logic "Bocor" ke View

**Lokasi:** `resources\views\pages\loans\index.blade.php` (Baris 66)

### Isu
Anda meletakkan logika penentuan status di layer presentasi (Blade):
```php
@php
    $isOverdue = $loan->status == 'dipinjam' && now() > $loan->return_date_plan;
@endphp
```

### Mengapa Ini Salah?
1. **Intermingling Concerns:** View seharusnya "bodoh". Tugasnya hanya menampilkan data, bukan memproses logika.
2. **Duplikasi Kode:** Jika Anda butuh logika "Overdue" ini di halaman dashboard, di email notifikasi, atau di laporan PDF, Anda harus copy-paste rumus ini. Jika rumus berubah, Anda harus ubah di banyak tempat.

### Solusi
Pindahkan logika ke Model `Loan` menggunakan **Accessor**:
```php
// App\Models\Loan.php
public function getIsOverdueAttribute() {
    return $this->status == 'dipinjam' && now() > $this->return_date_plan;
}
```
Di Blade cukup panggil: `@if($loan->is_overdue)`

---

## 3. 🕸️ CLEAN CODE: Magic Strings & Hardcoding

**Lokasi:** Tersebar di Controller dan View.

### Isu
- `loans/index.blade.php`: `value="dipinjam"`, `value="kembali"`.
- `ConsumableController.php`: `'type' => 'masuk'`.

### Mengapa Ini Buruk?
Ini adalah "bom waktu maintenabilitas".
- Jika dosen meminta istilah "dipinjam" diganti jadi "loaned", Anda harus melakukan *Global Find & Replace* yang berisiko salah ganti.
- Tidak ada validasi ketat (typo `'dipinjam'` vs `'di_pinjam'` akan lolos tapi merusak fitur).

### Solusi
Gunakan **PHP Enums** (Fitur Native PHP 8.1+) atau Class Constants.
```php
enum LoanStatus: string {
    case DIPINJAM = 'dipinjam';
    case KEMBALI = 'kembali';
}
```

---

## 4. 🔗 COUPLING: Controller Tahu Terlalu Banyak

**Lokasi:** `ConsumableController.php` (Store Method)

### Isu
Controller ini tidak hanya menyimpan data batch consumable, tapi juga secara manual membuat record `Transaction`.
```php
\App\Models\Transaction::create([...]);
```

### Mengapa Ini Buruk?
Anda melanggar **Single Responsibility Principle**. Controller jadi gemuk dan tahu detail implementasi logging transaksi.
Jika besok ada fitur "Import Excel Consumable", Anda harus menduplikasi logika pembuatan transaksi ini di sana. Jika lupa satu field, data tidak konsisten.

### Solusi
Gunakan **Eloquent Observers** atau **Service Class**.
Saat `ConsumableDetail` berhasil dibuat (`created` event), sistem (Observer) otomatis mencatat transaksi tanpa perlu ditulis manual di Controller.

---

## 📋 RENCANA AKSI (URGENSI TINGGI)

Berikut adalah langkah-langkah konkret untuk memperbaiki kekacauan ini:

1.  [ ] **Refactor Model `Loan`:** Implementasikan Accessor `is_overdue`.
2.  [ ] **Refactor View Blade:** Hapus `@php` block logic dan gunakan Accessor.
3.  [ ] **Fix Transaction Safety:** Bungkus operasi `storeDetail` dalam `DB::transaction(function() { ... })`.
4.  [ ] **Hapus Magic Strings:** Buat Enum atau Constants untuk Status.
5.  [ ] **(Opsional tapi Penting)**: Pindahkan logika counter kode unik ke Service atau gunakan locking yang benar.

Ingat: **"Kode yang jalan" bukan berarti "Kode yang benar".**
