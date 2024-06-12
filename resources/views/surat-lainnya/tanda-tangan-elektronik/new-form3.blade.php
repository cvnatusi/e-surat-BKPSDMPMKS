{{-- <link rel="stylesheet" href="{{asset('pdf/build/bundle.css')}}" />

<script defer src="{{asset('pdf/build/bundle.js')}}"></script>
<script src="https://unpkg.com/pdf-lib@1.4.0"></script> --}}


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
	<link 	rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
			integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
			crossorigin="anonymous"
			referrerpolicy="no-referrer"/>
	{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
	<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script> --}}
	<title>TTE</title>
	<style>
		#draggable {
            width: 150px;
            height: 150px;
            padding: 0.5em;
            user-select: none;
            overflow: hidden;
            will-change: width, height, transform;
        }

        .draggable {
         position: absolute;
         user-select: none;
         /* overflow: hidden; */
         /* will-change: width, height, transform; */
         /* touch-action: none; */
        }

        .draggable img {
         pointer-events: none;
        }

		img {
			cursor: move;
		}
		.card {
			height: 50rem;
			border-radius: 10px;
			margin: 3px px;
		}

		#draggable-div, #mydiv2 {
			position: absolute;
		}
		#footer {
			position: absolute;
			cursor: move;
		}
		#pdfCanvas {
			/* border: 1px solid #ccc; */
			/* height: 50rem;
			width: 35rem;
			margin-left: 3.2rem; */
			height: 100%;
			width: 80%;
			margin-left: 5rem;
			/* padding: 5px 25px; */
			/* border: 1px solid red; */
		}
		#save {
			position: absolute;
			bottom: 0;
			left: 50%;
			transform: translateX(-50%);
			margin-bottom: 20px;
		}

        .draggable {
            width: 100px;
            height: 100px;
            /* background: rgba(0, 255, 0, 0.5);  */
            position: absolute;
            cursor: move;
        }

        #pdf-canvas {
            border: 1px solid black;
            display: block;
            margin: 0 auto;
        }

	</style>
</head>
<body>
	<div class="row content">
		<div class="card col-md-5 p-4 me-3">
			<form class="form-save">
				<h6><b><i>e</i> -Tanda Tangan</b></h6>
				<hr>
				<label for="inputBox yang_bertanda_tangan" id="label_tujuan_surat" class="form-label">Penanda Tangan Surat Tugas <span>*</span></label>
				<select class="form-select mb-3 select2" id="pilihanGambar" aria-label="Default select example">
					<option value="" selected disabled>-- Pilih penanda tangan --</option>
						@foreach ($asn as $ttd)
							<option value="{{$ttd->id_mst_asn}}" >{{$ttd->nama_asn}} {{ ($ttd->id_mst_asn == 5) ? '(KABAN)' : '(SEKDA)' }}</option>
						@endforeach
					</select>
					<div class="col-md-12 mt-3">
						<label for="file_scan" class="form-label">Upload Surat <span>*</span></label>
						<input class="form-control" type="file" id="upload-pdf" name="file_scan" accept="application/pdf">
					</div>
					<div id="surat_pendukung" style="display: none; margin-bottom: 10px; margin-top: 10px;">
						<div class="col-md-12">
							<label for="file_scan" class="form-label">Upload Surat Pendukung <span>*</span></label>
							<input class="form-control" type="file" id="myPdf2" name="file_scan">
						</div>
					</div>
					<div class="container">
						<div class="show">
							<input type="checkbox" id="barCode" >
							<p>Tampilkan Barcode Tanda Tangan Elektronik</p>
						</div>
						<div class="show">
							<input type="checkbox" name="" id="footerTTE">
							<p>Tampilkan Footer Tanda Tangan Elektronik</p>
						</div>
					</div>
					<div class="row" style="margin-top: 26rem;">
						<div class="col-md-6">
								<button id="submit" class="btn btn-primary col-md-11">SIMPAN</button>
						</div>
						<div class="col-md-6">
								<button id="cancel" class="btn btn-secondary col-md-11">KEMBALI</button>
						</div>
					</div>
            </form>
        </div>
			{{-- Preview Surat --}}
			<div class="col ms-2">
				<div>
					<button type="button" class="btn btn-secondary" id="prev">Previous</button>
					<button type="button" class="btn btn-secondary" id="next">Next</button>
					&nbsp; &nbsp;
					<span style="color: red">Page: <span id="page_num"></span> / <span id="page_count"></span></span>
				</div>
				<div class="card preview border-0 border-0 border-primary panel-form" style="background-color: rgb(222, 228, 226)">
                    <canvas id="pdf-canvas"></canvas>
                    <img src="{{asset('gambar/QR.png')}}" id="draggable-div" class="draggable" draggable="true">
					<div id="mydiv2" class="draggable" draggable="true" style="display: none;  position: absolute; left: 80px; top: -1px;">
						<img src="{{asset('assets/images/qr-code.png')}}" id="mydivheader2" style="height: 100px; width: 100px;">
					</div>
					<div id="footer" class="draggable" draggable="true" style="display: none; position: absolute; left: 130px; top: 700px; cursor: pointer;" >
						<img src="{{ asset('assets/images/footer-bsre.png') }}" id="gambarFooter" style="width: 28rem;">
					</div>
				</div>
			</div>
			{{-- Akhir Preview Surat --}}
		</div>

        {{-- <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script> --}}
        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
        <script src="{{ asset('js/dist/interact.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.js"></script>

<script>
    $('.select2').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
        tags: true,
    });

    const canvas = document.getElementById('pdf-canvas');
    const ctx = canvas.getContext('2d');
    const draggableDiv = document.getElementById('draggable-div');
    const uploadPdf = document.getElementById('upload-pdf');
    const submitButton = document.getElementById('submit');
    const checkboxBarcode = document.getElementById('draggable-div');
    const checkboxFooter = document.getElementById('footerTTE');

    let pdfDoc = null;
    let pageNum = 1;
    let scale = 1.5;
    let viewport = null;

    function renderPage(num) {
        pdfDoc.getPage(num).then(page => {
            viewport = page.getViewport({ scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            page.render(renderContext);
        });
    }

    uploadPdf.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const fileReader = new FileReader();

        fileReader.onload = function () {
            const typedArray = new Uint8Array(this.result);
            pdfjsLib.getDocument(typedArray).promise.then(pdf => {
                pdfDoc = pdf;
                pageNum = pdf.numPages;
                renderPage(pageNum);
            console.log('done');
            });
        };

        fileReader.readAsArrayBuffer(file);
    });

        interact('.draggable')
        .draggable({
            onmove: event => {
                const target = event.target;
                const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                target.style.transform = `translate(${x}px, ${y}px)`;

                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);
            }
        })
        .resizable({
            edges: { left: true, right: true, bottom: true, top: true }
        })
        .on('resizemove', event => {
            const target = event.target;
            let x = (parseFloat(target.getAttribute('data-x')) || 0);
            let y = (parseFloat(target.getAttribute('data-y')) || 0);

            // update the element's style
            target.style.width = event.rect.width + 'px';
            target.style.height = event.rect.height + 'px';

            // translate when resizing from top or left edges
            x += event.deltaRect.left;
            y += event.deltaRect.top;

            var height = event.rect.height
            var width = event.rect.width

            target.style.transform = `translate(${x}px, ${y}px)`;

            target.setAttribute('data-x-image', x);
            target.setAttribute('data-y-image', y);

            // console.log(`height: ${height} | width: ${width} `);
        });

        function drawBarcode(x, y) {
            // Buat elemen gambar untuk QR.png
            const img = new Image();


            const imgWidth =  100;
            const imgHeight = 100;
            img.width = imgWidth;
            img.height = imgHeight;

            // Ketika gambar QR.png dimuat, gambar ke canvas
            img.onload = function() {
                // Buat canvas sementara untuk menggambar QR.png
                const tempCanvas = document.createElement('canvas');
                const tempCtx = tempCanvas.getContext('2d');
                tempCanvas.width = imgWidth;
                tempCanvas.height = imgHeight;

                // Gambar QR.png ke canvas sementara
                tempCtx.drawImage(img, 0, 0, imgWidth, imgHeight);

                // Gambar canvas sementara ke canvas utama
                ctx.drawImage(tempCanvas, x, y, imgWidth, imgHeight);

                // Convert canvas ke base64
                const base64Image = canvas.toDataURL('image/png');
                console.log(`Base64 Image: ${base64Image}`);
            };
            img.setAttribute('crossorigin', 'anonymous');
            // img.src = './QR.png';
            img.src = 'https://c8.staticflickr.com/8/7492/15644563231_4d682b3c88_n.jpg';
        }

		// const gambar = document.getElementById('draggable-div');
		// const gambar2 = document.getElementById('mydiv2');
		// const checkboxBarcode = document.getElementById('barCode');
		// const footer = document.getElementById('footer');
		// const checkboxFooter = document.getElementById('footerTTE');
		// const suratPendukung = document.getElementById('surat_pendukung');

		// Event listener untuk elemen <select>
			document.getElementById('pilihanGambar').addEventListener('change', function () {
				const selectedValue = this.value;
				// console.log(selectedValue)
				var checkbox = $('#barCode:checkbox:checked').length;
				if (checkbox > 0 ){
					if (selectedValue === '5') {
						document.getElementById('draggable-div').style.display = 'block';
						document.getElementById('mydiv2').style.display = 'none';
					} else {
						document.getElementById('draggable-div').style.display = 'none';
						document.getElementById('mydiv2').style.display = 'block';
					}
				}
				if (selectedValue === '5') {
					document.getElementById('surat_pendukung').style.display = 'none';
				} else {
					document.getElementById('surat_pendukung').style.display = 'block';
				}
			});

			checkboxBarcode.addEventListener('change', function () {
				var opsiGambar = $('#pilihanGambar').val()
				// console.log(opsiGambar)
				if(opsiGambar === ''){
					alert('Silahkan pilih penanda tangan surat tugas!');
					$('#barCode').prop('checked',false)
				}
				if (this.checked) {
					if(opsiGambar == '5') {
						gambar.style.display = 'block'; // Tampilkan gambar ketika checkbox di checklist
						gambar2.style.display = 'none'; // Tampilkan gambar ketika checkbox di checklist
					}else{
						gambar.style.display = 'none'; // Tampilkan gambar ketika checkbox di checklist
						gambar2.style.display = 'block'; // Tampilkan gambar ketika checkbox di checklist
					}
				} else {
					if(opsiGambar == '5'){
						gambar.style.display = 'none'; // Tampilkan gambar ketika checkbox di checklist
					}else{
						gambar2.style.display = 'none'; // Tampilkan gambar ketika checkbox di checklist
					}
				}
			});

			checkboxFooter.addEventListener('change', function () {
				if (this.checked) {
					footer.style.display = 'block'; // Tampilkan footer ketika checkbox di checklist
				} else {
					footer.style.display = 'none'; // Sembunyikan footer ketika checkbox tidak di checklist
				}
			});

			$('#simpan').click(function(){
				window.jsPDF = window.jspdf.jsPDF
				const canvas = document.getElementById('pdfCanvas'); // Ambil elemen canvas

				// Konversi elemen canvas ke gambar menggunakan html2canvas
				html2canvas(canvas, {
					allowTaint: true,
					useCORS: true,
					scale: 5 // Skala untuk meningkatkan resolusi gambar
				}).then(canvasImage => {
					const imgData = canvasImage.toDataURL('image/png'); // Ubah gambar canvas menjadi URL data

					// Buat objek jsPDF
					const pdf = new jsPDF({
						orientation: "portrait",
						// unit: "in",
						unit: "mm",
						// format: [4, 2]
						format: 'a4'
					});
					const imgWidth = 3508; // Lebar A4 dalam piksel
					const imgHeight = canvasImage.height * imgWidth / canvasImage.width;
					pdf.addImage(imgData, 'PNG', 0, 0,  450, 670); // Tambahkan gambar ke dokumen PDF
					pdf.save("canvas_to_pdf.pdf"); // Simpan dokumen PDF dengan nama "canvas_to_pdf.pdf"
				});
			});


		// // Fungsi untuk menggambar elemen footer pada elemen canvas
		function drawFooterOnCanvas() {
			const canvas = document.getElementById('pdfCanvas');
			const ctx = canvas.getContext("2d");
			var imageFooter = document.getElementById('gambarFooter');

			// Ambil posisi elemen "footer" dan gambar footer
			// const footerImg = document.getElementById('footer').getElementsByTagName('img')[0];
			var image = imageFooter
			const footerX = parseInt(document.getElementById('footer').style.left, 12);
			const footerY = parseInt(document.getElementById('footer').style.top, 13.5);

			// Gambar elemen footer pada elemen canvas
			// ctx.drawImage(footerImg, footerX, footerY, footerImg.width, footerImg.height);
			// const height = parseInt(image.height)
			// const width = parseInt(image.width)
			const height = parseInt(image.height)
			const width = 128;
			// ctx.drawImage(image, footerX, footerY, isNaN(width)?350:width+200, isNaN(height)?40:height+20);
			ctx.drawImage(image, footerX, footerY, width, height);
		}




		// AMBIL NAMA ASLI FILE YANG DI UPLOAD
		var resfile = ""
		document.getElementById('upload-pdf').addEventListener('change', function () {
			var file_ = this.files[0]; // Ambil file yang dipilih oleh pengguna
			resfile = file_
			// var namaFile = $('#pload-pdf').files[0].name;
			// console.log(file_)

			// if (file_) {
			// 	console.log('Nama file : ' + file_.name);
			// } else {
			// 	console.log('Tidak ada file yang dipilih.');
			// }
		});


			// $('#convertToPDF').on('click', function() {
				// 	window.jsPDF = window.jspdf.jsPDF;
				// 	const canvas = document.getElementById('pdfViewer');
				// 	// e.preventDefault();
				// 	var penandaTangan = $('#pilihanGambar').val();
				// 	var tanggalTTD = new Date("31-7-2023");
				// 	var namaSurat = prompt('Masukkan nama file PDF');

				// 	// Buat objek jsPDF
				// 	const pdf = new jsPDF({
					// 		orientation: 'portrait', // Atur orientasi portrait atau landscape
					// 		unit: 'px', // Atur unit ukuran (piksel)
					// 		format: 'a4' // Atur format halaman (A4)
					// 	});
					// 	// const imgData = canvas.toDataURL('image/png');
					// 	const imgData = canvas.toDataURL(); // Ubah elemen canvas menjadi gambar data URL (PNG)
					// 	pdf.addImage(imgData, 'PNG', 0, 0); // Tambahkan gambar ke dokumen PDF

					// 	/* Simpan dokumen PDF dalam format Base64
					// 	Anda dapat menggunakan pdfBase64 untuk tujuan yang diinginkan, seperti menyimpannya ke server atau mengirimkannya melalui AJAX. */
					// 	const pdfBase64 = pdf.output('dataurlstring');
					// 	// pdf.save("canvas_to_pdf.pdf") // Download pdf
					// 	$.ajax({
						// 		url: '{{route("savePDF")}}',
						// 		method: 'POST',
						// 		data: {
							// 			"_token" : '{{csrf_token()}}',
							// 			// pdf: btoa(pdf)
							// 			pdf: pdfBase64,
							// 			namaSurat: namaSurat, // Ganti namaSurat sesuai dengan nama yang Anda inginkan
							// 			tanggalTTD: '31-7-2023', // Ganti tanggalTTD sesuai dengan tanggal yang Anda inginkan
							// 			penandaTangan: penandaTangan
							// 		},
							// 		success:function(data){
								// 			$('#success').html(data);
								// 		}
								// 	}).done((res)=>{})
								// });

								$('#convertToPDF').click(function(e){
									e.preventDefault();
									// $('.btn-submit').html('Please wait...').attr('disabled', true);
									// $('#convertToPDF');
									window.jsPDF = window.jspdf.jsPDF;
									// Gambar elemen barcode dan footer pada elemen canvas terlebih dahulu
									// drawImagesOnCanvas();
									var penandaTangan = $('#pilihanGambar').val();

									// Cek checkbox yang diceklis
									const checkboxBarcode = document.getElementById('barCode');
									const checkboxFooter = document.getElementById('footerTTE');
									if (checkboxBarcode.checked && checkboxFooter.checked) { // Tampilkan elemen barcode dan footer pada elemen canvas
										drawBarcode(xDrag+50, yDrag+90);
										drawFooterOnCanvas();
									} else if (checkboxBarcode.checked) {  // Tampilkan hanya elemen barcode pada elemen canvas
										drawBarcode(xDrag, yDrag);
									} else if (checkboxFooter.checked) {   // Tampilkan hanya elemen footer pada elemen canvas
										drawFooterOnCanvas();
									}
									// Ubah elemen canvas menjadi URL data
									const canvas = document.getElementById('pdfCanvas');
									const imgData = canvas.toDataURL('image/png');
                                    // console.log(imgData);
                                    // return
									// Buat objek jsPDF
									const pdf = new jsPDF({
										orientation: "portrait",
										unit: "mm",
										// format: [210.00, 330.00]
										format: [230.00, 330.00]
									});
									const imgWidth = 3508; // Lebar A4 dalam piksel
									const imgHeight = canvas.height * imgWidth / canvas.width;
									pdf.addImage(imgData, 'PNG', 0, 0, 230, 330); // Tambahkan gambar ke dokumen PDF

									/* Simpan dokumen PDF dalam format Base64
									Anda dapat menggunakan pdfBase64 untuk tujuan yang diinginkan, seperti menyimpannya ke server atau mengirimkannya melalui AJAX. */
									const pdfBase64 = pdf.output('dataurlstring');
									var penandaTangan = $('#pilihanGambar').val();
									// return console.log(resfile)

									$.ajax({
										url: '{{route("savePDF")}}',
										method: 'POST',
										data: {
											"_token" : '{{csrf_token()}}',
											// pdf: btoa(pdf)
											pdf: pdfBase64,
											namaSurat: resfile.name,
											penandaTangan: penandaTangan
										},
									}).done(function(data){
										// console.log('tes')
										// $('.form-save').validate(data, 'has-error');
										if(data.status == 'success'){
											Lobibox.notify('success', {
												pauseDelayOnHover: true,
												size: 'mini',
												rounded: true,
												delayIndicator: false,
												icon: 'bx bx-check-circle',
												continueDelayOnInactiveTab: false,
												position: 'top right',
												sound:false,
												msg: data.message
											});
											$('.other-page').fadeOut(function(){
												$('.other-page').empty();
												$('.card').fadeIn();
												location.reload();
												$('#datagrid').DataTable().ajax.reload();
											});
										} else if(data.status == 'error') {
											$('#convertToPDF');
											Lobibox.notify('error', {
												pauseDelayOnHover: true,
												size: 'mini',
												rounded: true,
												delayIndicator: false,
												icon: 'bx bx-x-circle',
												continueDelayOnInactiveTab: false,
												position: 'top right',
												sound:false,
												msg: data.message
											});
											swal('Error :'+data.errMsg.errorInfo[0], data.errMsg.errorInfo[2], 'warning');
										} else {
											var n = 0;
											for(key in data){
												if (n == 0) {var dt0 = key;}
												n++;
											}
											$('#convertToPDF');
											Lobibox.notify('warning', {
												pauseDelayOnHover: true,
												size: 'mini',
												rounded: true,
												delayIndicator: false,
												icon: 'bx bx-error',
												continueDelayOnInactiveTab: false,
												position: 'top right',
												sound:false,
												msg: data.message
											});
										}
									}).fail(function() {
										$('#convertToPDF');
										Lobibox.notify('warning', {
											title: 'Maaf!',
											pauseDelayOnHover: true,
											size: 'mini',
											rounded: true,
											delayIndicator: false,
											icon: 'bx bx-error',
											continueDelayOnInactiveTab: false,
											position: 'top right',
											sound:false,
											msg: 'Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!'
										});
									});
									// .done((res)=>{})

									const penandaTanganSurat = $('#pilihanGambar').val()
									if(penandaTanganSurat === '5'){
										gambar.style.display = 'none'; // qrcode
									} else{
										gambar2.style.display = 'none'; // optik
									}
								});

				// Fungsi untuk melakukan konversi ke PDF
				// function convertToPDF() {
					// 	// e.preventDefault();
					// 	// console.log(resfile)
					// 	window.jsPDF = window.jspdf.jsPDF;
					// 	// Gambar elemen barcode dan footer pada elemen canvas terlebih dahulu
					// 	// drawImagesOnCanvas();
					// 	var penandaTangan = $('#pilihanGambar').val();

					// 	// Cek checkbox yang diceklis
					// 	const checkboxBarcode = document.getElementById('barCode');
					// 	const checkboxFooter = document.getElementById('footerTTE');
					// 	if (checkboxBarcode.checked && checkboxFooter.checked) {
						// 		// Tampilkan elemen barcode dan footer pada elemen canvas
						// 		drawBarcodeOnCanvas();
						// 		drawFooterOnCanvas();
						// 	} else if (checkboxBarcode.checked) {
							// 		// Tampilkan hanya elemen barcode pada elemen canvas
							// 		drawBarcodeOnCanvas();
							// 	} else if (checkboxFooter.checked) {
								// 		// Tampilkan hanya elemen footer pada elemen canvas
								// 		drawFooterOnCanvas();
								// 	}
								// 	// Ubah elemen canvas menjadi URL data
								// 	const canvas = document.getElementById('pdfViewer');
								// 	const imgData = canvas.toDataURL('image/png');

								// 	// Buat objek jsPDF
								// 	const pdf = new jsPDF({
									// 		orientation: "portrait",
									// 		unit: "px",
									// 		format: 'a4'
									// 	});
									// 	const imgWidth = 3508; // Lebar A4 dalam piksel
									// 	const imgHeight = canvas.height * imgWidth / canvas.width;
									// 	pdf.addImage(imgData, 'PNG', 0, 0, 450, 670); // Tambahkan gambar ke dokumen PDF

									// 	/* Simpan dokumen PDF dalam format Base64
									// 	Anda dapat menggunakan pdfBase64 untuk tujuan yang diinginkan, seperti menyimpannya ke server atau mengirimkannya melalui AJAX. */
									// 	const pdfBase64 = pdf.output('dataurlstring');
									// 	// const suratPendukungBase64 = pdf.output('dataurlstring');
									// 	// console.log	(suratPendukungBase64)
									// 	// pdf.save("canvas_to_pdf.pdf") // Download pdf

									// 	var penandaTangan = $('#pilihanGambar').val();
									// 	// var fileSurat = $('#pload-pdf').val();

									// 	// return console.log(resfile)

									// 	$.ajax({
										// 		url: '{{route("savePDF")}}',
										// 		method: 'POST',
										// 		data: {
											// 			"_token" : '{{csrf_token()}}',
											// 			// pdf: btoa(pdf)
											// 			pdf: pdfBase64,
											// 			// penanda_tangan : penandaTangan,
											// 			namaSurat: resfile.name,
											// 			penandaTangan: penandaTangan
											// 		},
											// 	}).done((res)=>{})

											// 	const penandaTanganSurat = $('#pilihanGambar').val()
											// 		if(penandaTanganSurat === '5'){
												// 			gambar.style.display = 'none'; // qrcode
												// 		} else{
													// 			gambar2.style.display = 'none'; // optik
													// 		}
													// 	}

		// Event listener untuk tombol "Convert to PDF"
// 		document.getElementById('convertToPDF').addEventListener('click', convertToPDF);
// 		function showForm(id) {
// 			// $('.main-page').hide();
// 			$.post("{!! route('show-tanda-tangan-elektronik') !!}", {
// 				id: id
// 			}).done(function(data) {
// 				if (data.status == 'success') {
// 					$('.modal-page').html(data.content).fadeIn();
// 				} else {
// 					$('.main-page').show();
// 				}
// 			});
//   }
</script>
</body>
</html>
