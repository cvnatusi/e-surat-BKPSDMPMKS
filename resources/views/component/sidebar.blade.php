<ul class="metismenu" id="menu">
  <li class="{{ $data['menuActive'] == 'dashboard' ? 'mm-active' : '' }}" >
    <a href="{{ route('dashboard') }}">
      <div class="parent-icon"><i class='bx bx-home-circle'></i>
      </div>
      <div class="menu-title">Dashboard</div>
    </a>
  </li>
  <li class="menu-label">PERSURATAN</li>
  @if (Auth::user()->level_user == 1 || Auth::user()->level_user == 2 || Auth::user()->level_user == 5)
    <li style="" class="{{ $data['menuActive'] == 'surat-masuk' ? 'mm-active' : '' }}">
      <a href="{{ route('surat-masuk') }}" >
        <div class="parent-icon"><i class='bx bx-envelope'></i>
        </div>
        <div class="menu-title">Surat Masuk</div>
      </a>
    </li>
  @endif
  <li style="" class="{{ $data['menuActive'] == 'surat-disposisi' ? 'mm-active' : '' }}">
    <a href="{{ route('surat-disposisi') }}" >
      <div class="parent-icon"><i class='bx bx-chat'></i>
      </div>
      <div class="menu-title">Disposisi Surat</div>
    </a>
  </li>
  <li style="" class="{{ $data['menuActive'] == 'surat-keluar' ? 'mm-active' : '' }}">
    <a href="{{ route('surat-keluar') }}" >
      <div class="parent-icon"><i class='bx bx-envelope-open'></i>
      </div>
      <div class="menu-title">Surat Keluar</div>
    </a>
  </li>

  <li class="{{ $data['menuActive'] == 'surat-tugas' ? 'mm-active' : '' }}">
    <a href="{{ route('surat-tugas') }}" >
      <div class="parent-icon"><i class='bx bx-archive-in'></i>
      </div>
      <div class="menu-title">Surat Tugas</div>
    </a>
  </li>
  <li class="{{ $data['menuActive'] == 'surat-perjalanan-dinas' ? 'mm-active' : '' }}">
    <a href="{{ route('surat-perjalanan-dinas') }}" >
      <div class="parent-icon"><i class='bx bx-archive-in'></i>
      </div>
      <div class="menu-title">SPPD</div>
    </a>
  </li>
  <li>
    <a href="javascript:;" class="has-arrow">
      <div class="parent-icon"><i class='bx bxs-envelope' ></i>
      </div>
      <div class="menu-title">Surat Lainnya</div>
    </a>
    <ul>
      <li class="{{ $data['submnActive'] == 'utama-surat-bast' ? 'mm-active' : '' }}">
        <a href="{{ route('utama-surat-bast') }}"><i class="bx bx-right-arrow-alt"></i>Surat BAST</a>
      </li>
      <li class="{{ $data['submnActive'] == 'utama-surat-keputusan' ? 'mm-active' : '' }}">
        <a href="{{ route('utama-surat-keputusan') }}"><i class="bx bx-right-arrow-alt"></i>Surat Keputusan</a>
      </li>
      {{-- <li class="{{ $data['submnActive'] == 'tanda-tangan-elektronik' ? 'mm-active' : '' }}">
        <a href="{{ route('tanda-tangan-elektronik') }}"><i class="bx bx-right-arrow-alt"></i>Tanda Tangan Elektronik</a>
      </li> --}}
    </ul>
  </li>
  <li class="{{ $data['menuActive'] == 'tanda-tangan-elektronik' ? 'mm-active' : '' }}">
    <a href="{{ route('tanda-tangan-elektronik') }}" >
      <div class="parent-icon"><i class='bx bx-edit'></i>
      </div>
      <div class="menu-title"><i>e-</i> Tanda Tangan</div>
    </a>
  </li>
  <li>
    <a href="javascript:;" class="has-arrow">
      <div class="parent-icon"><i class='bx bx-data'></i>
      </div>
      <div class="menu-title">Data Master</div>
    </a>
    <ul>
      @if (Auth::user()->level_user == 1)
        <li class="{{ $data['submnActive'] == 'pengguna' ? 'mm-active' : '' }}">
          <a href="{{ route('pengguna') }}"><i class="bx bx-right-arrow-alt"></i>Data Pengguna</a>
        </li>
        <!-- <li class="#">
          <a href="#"><i class="bx bx-right-arrow-alt"></i>Data Penanda Tangan</a>
        </li> -->
      @endif
      <li class="{{ $data['submnActive'] == 'instansi' ? 'mm-active' : '' }}">
        <a href="{{ route('instansi') }}"><i class="bx bx-right-arrow-alt"></i>Data Instansi</a>
      </li>
      <li class="{{ $data['submnActive'] == 'bidang' ? 'mm-active' : '' }}">
        <a href="{{ route('bidang') }}"><i class="bx bx-right-arrow-alt"></i>Data Bidang BPKSDM</a>
      </li>
      <li class="{{ $data['submnActive'] == 'asn' ? 'mm-active' : '' }}">
        <a href="{{ route('asn') }}"><i class="bx bx-right-arrow-alt"></i>Data ASN</a>
      </li>
      <li class="{{ $data['submnActive'] == 'jabatan' ? 'mm-active' : '' }}">
        <a href="{{ route('jabatan') }}"><i class="bx bx-right-arrow-alt"></i>Data Jabatan</a>
      </li>
      <li class="{{ $data['submnActive'] == 'jenis-surat' ? 'mm-active' : '' }}">
        <a href="{{ route('jenis-surat') }}"><i class="bx bx-right-arrow-alt"></i>Data Jenis Surat</a>
      </li>
      <li class="{{ $data['submnActive'] == 'sifat-surat' ? 'mm-active' : '' }}">
        <a href="{{ route('sifat-surat') }}"><i class="bx bx-right-arrow-alt"></i>Data Sifat Surat</a>
      </li>
      <li class="{{ $data['submnActive'] == 'penanda-tangan-surat' ? 'mm-active' : '' }}">
        <a href="{{ route('penandaTanganSurat') }}"><i class="bx bx-right-arrow-alt"></i>Penanda Tangan Surat</a>
      </li>
    </ul>
  </li>
  <li>
    <a href="javascript:;" class="has-arrow">
      <div class="parent-icon"><i class='bx bx-book-content' ></i>
      </div>
      <div class="menu-title">Laporan</div>
    </a>
    <ul>
      <li class="{{ $data['submnActive'] == 'laporan-surat-masuk' ? 'mm-active' : '' }}">
        <a href="{{ route('laporan-surat-masuk') }}" ><i class="bx bx-right-arrow-alt"></i>Surat Masuk</a>
      </li>
      <li class="{{ $data['submnActive'] == 'laporan-surat-keluar' ? 'mm-active' : '' }}">
        <a href="{{ route('laporan-surat-keluar') }}" ><i class="bx bx-right-arrow-alt"></i>Surat Keluar</a>
      </li>
      <li class="{{ $data['submnActive'] == 'laporan-surat-bast' ? 'mm-active' : '' }}">
        <a href="{{ route('laporan-surat-bast') }}" ><i class="bx bx-right-arrow-alt"></i>Surat BAST</a>
      </li>
      <li class="{{ $data['submnActive'] == 'laporan-surat-keputusan' ? 'mm-active' : '' }}">
        <a href="{{ route('laporan-surat-keputusan') }}" ><i class="bx bx-right-arrow-alt"></i>Surat Keputusan</a>
      </li>
      <li class="{{ $data['submnActive'] == 'laporan-surat-tugas' ? 'mm-active' : '' }}">
        <a href="{{ route('laporan-surat-tugas') }}" ><i class="bx bx-right-arrow-alt"></i>Surat Tugas</a>
      </li>
      {{-- <li class="{{ $data['submnActive'] == 'log-activity' ? 'mm-active' : '' }}"><a href="{{ route('log-activity') }}"><i class="bx bx-right-arrow-alt"></i>Log Activity</a></li> --}}
    </ul>
  </li>
  <li class="{{ $data['menuActive'] == 'log-activity' ? 'mm-active' : '' }}">
    <a href="{{ route('log-activity') }}" >
      <div class="parent-icon"><i class='bx bx-command'></i>
      </div>
      <div class="menu-title">Log Activity</div>
    </a>
  </li>
  <!-- <li class="{{ $data['menuActive'] == 'pengaturan' ? 'mm-active' : '' }}">
    <a href="{{ route('pengaturan') }}" >
      <div class="parent-icon"><i class='bx bx-cog'></i>
      </div>
      <div class="menu-title">Pengaturan</div>
    </a>
  </li> -->
  <!-- <li>
    <a href="#" onclick="kosong()">
      <div class="parent-icon"><i class='bx bx-cog'></i>
      </div>
      <div class="menu-title">Pengaturan</div>
    </a>
  </li> -->

</ul>
