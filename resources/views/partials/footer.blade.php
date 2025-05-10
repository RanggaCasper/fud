<!-- Footer -->
<footer>
    <div class="px-4 md:px-2 mx-auto bg-light">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl py-16 mx-auto lg:pb-2">
            <div class="grid grid-cols-6 gap-4">
                <div class="col-span-6 md:col-span-2">
                    <div class="mb-3 max-w-32 max-h-32">
                        <x-logo />
                    </div>
                    <p class="text-sm text-muted">Suplier top up game dan voucher terlaris, murah, aman, dan legal 100% dengan berbagai pilihan pembayaran terlengkap di Indonesia. Dapatkan pengalaman berbelanja terbaik bersama kami!</p>
                </div>
                <div class="col-span-6 md:col-span-2">
                    <h6 class="font-bold text-muted text-md">Pembayaran</h6>
                    <div class="flex flex-wrap gap-1 mt-3">
                        <!-- Konten pembayaran (icons, metode pembayaran, dll) -->
                    </div>
                    <h6 class="mt-3 font-bold text-muted text-md">Ikuti Kami</h6>
                    <div class="flex flex-wrap gap-1 mt-3">
                        <!-- Ikon sosial media (misalnya Instagram, Twitter, dll) -->
                    </div>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <h6 class="font-bold text-muted text-md">Menu</h6>
                    <ul class="w-auto">
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Beranda</a></li>
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Cek Transaksi</a></li>
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Daftar Harga</a></li>
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Kontak</a></li>
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Masuk</a></li>
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Daftar</a></li>
                    </ul>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <h6 class="font-bold text-muted text-md">Legalitas</h6>
                    <ul class="w-auto">
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Tentang</a></li>
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-sm leading-6 text-muted hover:text-primary">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="@hasSection('showNavbot') pb-20 @else py-1 @endif lg:pb-1">
            <div class="w-full border-t bg-dark"></div>
            <h6 class="w-full mt-1 text-sm text-center text-muted">Copyright © 2024 CASPER TOPUP - All Right Reserved</h6>
        </div>
    </div>
</footer>
<!-- End Footer -->
