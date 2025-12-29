# 🛠️ TECHNICAL REFACTORING LOG
**Tanggal:** 24 Desember 2025  
**Topik:** Penguatan Arsitektur, Keamanan Data, dan Type Safety  
**Status:** ✅ COMPLETED

Dokumen ini merinci perubahan teknis yang telah diterapkan pada sistem SIM Inventaris untuk mengatasi kelemahan arsitektural yang fatal (Race Condition) dan praktik kode yang buruk (Magic Strings, Leaking Logic).

---

## 1. 🛡️ FIX: Race Condition & Data Integrity
**Masalah:** Sistem penomoran batch BHP (`.../001`, `.../002`) menggunakan pola *check-then-act* yang tidak aman. Jika dua admin menginput data bersamaan, sistem akan *crash* atau membuat data duplikat.

**Solusi:** Implementasi **Pessimistic Locking** dan **Database Transactions**.

### Perubahan File: `app/Http/Controllers/ConsumableController.php`
*   **Sebelum (Berisiko):**
    ```php
    $counter = ConsumableDetail::where(...)->count() + 1;
    // ... lalu save ...
    ```
*   **Sesudah (Aman):**
    ```php
    DB::transaction(function () use ($request) {
        // LOCK row parent agar request lain harus ANTRI
        $consumable = Consumable::lockForUpdate()->findOrFail($request->consumable_id);
       
        // Kalkulasi aman karena kita pegang kunci
        $counter = ConsumableDetail::where(...)->count() + 1;
       
        // ... save ...
    });
    ```

---

## 2. 🏗️ REFACTOR: Separation of Concerns (View vs Logic)
**Masalah:** Logika bisnis ("Apakah peminjaman ini terlambat?") ditulis mentah di dalam View Blade (`@php ... @endphp`). Ini membuat View kotor dan logika sulit di-reuse.

**Solusi:** Memindahkan logika ke Model Accessor.

### Perubahan File:
1.  **`app/Models/Loan.php`** (Menambah Accessor):
    ```php
    public function getIsOverdueAttribute() {
        return $this->status === LoanStatus::DIPINJAM && now() > $this->return_date_plan;
    }
    ```
2.  **`resources/views/pages/loans/index.blade.php`** (Membersihkan View):
    *   Menghapus blok `@php` logic.
    *   Mengganti pengecekan manual dengan `$loan->is_overdue`.

---

## 3. 💎 REFACTOR: Type Safety (Enums vs Magic Strings)
**Masalah:** Kode dipenuhi *Magic Strings* (`'dipinjam'`, `'tersedia'`, `'masuk'`). Ini rawan *typo* dan sulit di-maintain (refactoring mimpi buruk).

**Solusi:** Implementasi PHP Native Enums.

### A. Enums Baru Dibuat:
1.  `app/Enums/LoanStatus.php`: (`DIPINJAM`, `KEMBALI`, `OVERDUE`)
2.  `app/Enums/AssetStatus.php`: (`TERSEDIA`, `DIPINJAM`, `RUSAK`, `DIHAPUSKAN`)
3.  `app/Enums/TransactionType.php`: (`MASUK`, `KELUAR`)

### B. Implementasi Model Casting:
Model sekarang otomatis mengkonversi string database menjadi Objek Enum saat diambil.
*   `app/Models/Loan.php`:
    ```php
    protected $casts = ['status' => \App\Enums\LoanStatus::class];
    ```
*   `app/Models/Transaction.php`:
    ```php
    protected $casts = ['type' => \App\Enums\TransactionType::class];
    ```

### C. Implementasi Controller:
Mengganti semua string keras dengan Enum Reference di:
*   `LoanController.php`
*   `DashboardController.php`
*   `ReportController.php`
*   `ConsumableController.php`

**Contoh Perubahan:**
```php
// SEBELUM
->where('status', 'dipinjam')

// SESUDAH
->where('status', \App\Enums\LoanStatus::DIPINJAM)
```

---

## 📂 Ringkasan File yang Disentuh
Berikut adalah daftar file yang telah dimodifikasi secara signifikan:

1.  `app/Http/Controllers/ConsumableController.php` (Security & Enums)
2.  `app/Http/Controllers/LoanController.php` (Enums)
3.  `app/Http/Controllers/DashboardController.php` (Enums)
4.  `app/Http/Controllers/ReportController.php` (Enums)
5.  `app/Models/Loan.php` (Accessor & Casts)
6.  `app/Models/Transaction.php` (Casts)
7.  `resources/views/pages/loans/index.blade.php` (Cleanup View)
8.  `app/Enums/*.php` (File Baru)

---

## 💡 Pesan Akhir
Sistem Anda sekarang memiliki fondasi "Enterprise Grade" yang lebih kuat.
1.  **Aman:** Transaksi stok tidak akan tabrakan.
2.  **Bersih:** View hanya menampilkan data, Model mengurus logika.
3.  **Tangguh:** Tidak ada lagi *typo* status yang menyebabkan bug tersembunyi.
