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

    <script src="https://cdn.rawgit.com/konvajs/konva/2.0.2/konva.min.js"></script>

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
        }

        .draggable img {
         pointer-events: none;
        }

		img {
			cursor: move;
		}
		.card-canvas {
            /* display: flex;
            flex-direction: column; */
			height: 95rem;
			border-radius: 10px;
			/* margin: 3px px; */
		}

        .form-save {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .mt-auto {
            margin-top: auto;
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
            /* width: 120px;
            height: 120px; */
            /* background: rgba(0, 255, 0, 0.5);  */
            position: absolute;
            cursor: move;
        }

        #pdf-canvas {
            /* border: 0.5px solid grey; */
            display: block;
            /* width: 50%; */
            margin: 0 auto;
            /* height: auto; */
        }

	</style>
</head>
<body>
	<div class="row content">
		<div class="card col-md-5 p-4 me-3 d-flex flex-column" style="height: 97rem; width: 30rem;">
			<form class="form-save d-flex flex-column flex-grow-1">
				<h6><b><i>e</i> -Tanda Tangan</b></h6>
				<hr>
				<label for="inputBox yang_bertanda_tangan" id="label_tujuan_surat" class="form-label">Penanda Tangan Surat Tugas <span>*</span></label>
                  <select class="form-select mb-3 select2" id="pilihanGambar" onchange="handleSelectChange(this)" aria-label="Default select example">
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
					<div class="row mt-auto">
						<div class="col-md-6">
							<button type="button" id="submit" class="btn btn-primary col-md-11">SIMPAN</button>
						</div>
						<div class="col-md-6">
							<button id="cancel" class="btn btn-secondary col-md-11">KEMBALI</button>
						</div>
					</div>
            </form>
        </div>
        {{-- Preview Surat --}}
        <div class="col-md-12" style="height: 90rem;">
            <div>
                <button type="button" class="btn btn-secondary" id="prev">Previous</button>
                <button type="button" class="btn btn-secondary" id="next">Next</button>
                &nbsp; &nbsp;
                <span style="color: red">Page: <span id="page_num"></span> / <span id="page_count"></span></span>
            </div>
            <div class="card card-canvas preview border-0 border-0 border-primary panel-form" style="background-color: rgb(222, 228, 226)">
                <canvas id="pdf-canvas"></canvas>
                <img src="{{asset('gambar/qr.png')}}" id="draggable-div" class="draggable" crossorigin="anonymous" draggable="true" width="120" style="display: none;">
                <img src="{{asset('gambar/qrs.png')}}" id="qr-2" class="draggable" crossorigin="anonymous" draggable="true" width="120" style="display: none;">
                {{-- <div class="draggable" id="draggable-div" style="display: none">
                </div> --}}
                {{-- <img src="{{ asset('assets/images/qr.png') }}" id="qr-2" class="draggable" style="height: 100px; width: 100px; display: none;"> --}}
                {{-- <img src="{{ asset('gambar/qrs.png') }}" id="qr-2" class="draggable" style="height: 100px; width: 100px; display: none;"> --}}
                {{-- <div id="mydiv2" class="draggable" draggable="true" style="display: none;  position: absolute; left: 80px; top: -1px;">
                </div> --}}
                <img src="{{ asset('assets/images/footer-bsre.png') }}" class="footer" id="footer" style="width: 45rem; display: none;">
                {{-- <div id="footer" class="draggable" draggable="true" style="display: none; position: absolute; left: 130px; top: 700px; width: 45rem cursor: pointer;">
                </div> --}}
            </div>
        </div>
        {{-- Akhir Preview Surat --}}
	</div>

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="{{ asset('js/dist/interact.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" type="text/javascript" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



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
    const checkboxBarcode = document.getElementById('barCode');
    const checkboxFooter = document.getElementById('footerTTE');
    const gambar = document.getElementById('draggable-div');
    const gambar2 = document.getElementById('qr-2');
    const suratPendukung = document.getElementById('surat_pendukung');
    const footer = document.getElementById('footer');

    var idAsn;

    let pdfDoc = null;
    let pageNum = 1;
    let scale = 1.5;
    let viewport = null;

    // QR CODE
    var barCWidth = 120;
    var barCHeight = 120;
    const MAX_WIDTH = 200;
    const MIN_WIDTH = 50;

    // FOOTER
    var barFWidth = 720;
    var barFHeight = 55;

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
            // console.log('done');
            });
        };

        fileReader.readAsArrayBuffer(file);
    });

        // function applyInteractions(selector) {
            interact('.draggable')
            // interact(selector)
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
                edges: { bottom: true, right: true },
                preserveAspectRatio: true,
                listeners: {
                    move(event) {
                        const target = event.target;
                        let x = (parseFloat(target.getAttribute('data-x')) || 0);
                        let y = (parseFloat(target.getAttribute('data-y')) || 0);

                        // Calculate the new width and ensure it does not exceed MAX_WIDTH
                        let newWidth = event.rect.width;
                        if (newWidth > MAX_WIDTH) {
                            newWidth = MAX_WIDTH;
                        } else if (newWidth < MIN_WIDTH) {
                            newWidth = MIN_WIDTH;
                        }

                        // Calculate the new height to maintain the aspect ratio
                        let newHeight = newWidth;

                        // Update the element's style
                        target.style.width = newWidth + 'px';
                        target.style.height = newHeight + 'px';

                        // Translate when resizing from the right-bottom edge
                        x += event.deltaRect.left;
                        y += event.deltaRect.top;

                        target.style.transform = `translate(${x}px, ${y}px)`;

                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);

                        barCWidth = newWidth;
                        barCHeight = newHeight;

                        // console.log(`Height: ${newHeight} | Width: ${newWidth}`);
                    }
                }
            })
        // }
        // applyInteractions('.draggable');

        const urlQr5 = "{{ asset('gambar/qr.png') }}";
        const urlQr52 = "{{ asset('gambar/qrs.png') }}";

        function drawBarcode(x, y) {

            // Buat elemen gambar untuk QR.png
            const img = new Image();

            const imgWidth =  barCWidth || 120;
            const imgHeight = barCHeight || 120;

            img.width = imgWidth;
            img.height = imgHeight;

            const penandaTanganSurat = $('#pilihanGambar').val();

            if(penandaTanganSurat === '5'){
                img.src = urlQr5
                console.log('Drs. Saudi');
            }else if(penandaTanganSurat === '52') {
                img.src = urlQr52
                console.log('Ir. Totok');
            }

            // Ketika gambar QR.png dimuat, gambar ke canvas
            img.onload = function() {
                console.log("Gambar dimuat:", img.src);
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
                // console.log(`Base64 Image: ${base64Image}`);
            };

            img.onerror = function() {
                console.error("Gambar tidak dapat dimuat:", img.src);
            };

            img.setAttribute('crossorigin', 'anonymous');

        }


        interact('.footer')
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
            edges: { left: true, right: true, bottom: true, top: true },
            preserveAspectRatio: true
        })
        .on('resizemove', event => {
            const target = event.target;
            let x = (parseFloat(target.getAttribute('data-x')) || 0);
            let y = (parseFloat(target.getAttribute('data-y')) || 0);

            // Update the element's style
            target.style.width = event.rect.width + 'px';
            target.style.height = event.rect.height + 'px';

            // Translate when resizing from any edge
            x += event.deltaRect.left;
            y += event.deltaRect.top;

            target.style.transform = `translate(${x}px, ${y}px)`;

            target.setAttribute('data-x-image', x);
            target.setAttribute('data-y-image', y);

            newWidth = event.rect.width;
            newHeight = event.rect.height;

            barFWidth = newWidth;
            barFHeight = newHeight;

            // console.log(`height: ${event.rect.height} | width: ${event.rect.width} `);
        });

        function drawFooter(x, y) {
            // Buat elemen gambar untuk QR.png
            const img = new Image();

            const imgWidth =  barFWidth || 720;
            const imgHeight = barFHeight || 55;

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
                // console.log(`Base64 Image: ${base64Image}`);
            };

            img.setAttribute('crossorigin', 'anonymous');
            img.src = "{{ asset('assets/images/footer-bsre.png') }}";
        }

        $(document).ready(function () {
          submitButton.addEventListener('click', () => {
                let textButton = submitButton.innerHTML;
                submitButton.innerHTML = "Sending...";
                submitButton.setAttribute('disabled',true);
              const rect = canvas.getBoundingClientRect();
              const draggableRect = draggableDiv.getBoundingClientRect();
              const position = {
                x: draggableRect.left - rect.left,
                y: draggableRect.top - rect.top
              };

              // Gambar barcode pada canvas
              drawBarcode(position.x, position.y);
            //   return

              const fotoerRect = footer.getBoundingClientRect();
              const cordinate = {
                x: fotoerRect.left - rect.left,
                y: fotoerRect.top - rect.top
              };

              drawFooter(cordinate.x, cordinate.y);

              setTimeout(() => {
                  // Convert canvas ke base64 image
                  const base64Image = canvas.toDataURL('image/png');
                  // console.log(`Base64 Images: ${base64Image}`);

                  const { jsPDF } = window.jspdf;
                  const pdf = new jsPDF({
                      orientation: "portrait",
                      unit: "mm",
                      format: [230.00, 330.00]
                  });
                  const imgWidthPDF = 210; // Lebar A4 dalam mm
                  const imgHeightPDF = canvas.height * imgWidthPDF / canvas.width;
                  pdf.addImage(base64Image, 'PNG', 0, 0, imgWidthPDF, imgHeightPDF);

                  // Simpan dokumen PDF dalam format Base64
                  const pdfBase64 = pdf.output('dataurlstring');
                  // console.log(`Base64 PDF: ${pdfBase64}`);

                  // Kirim PDF ke server melalui AJAX
                  $.ajax({
                      url: '{{route("savePDF")}}',
                      method: 'POST',
                      data: {
                          "_token" : '{{csrf_token()}}',
                          pdf: pdfBase64,
                          namaSurat: resfile.name,
                          penandaTangan: $('#pilihanGambar').val()
                      },
                  }).done(function(data){
                    submitButton.innerHTML = textButton;
                    submitButton.setAttribute('disabled',false);
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
                        submitButton.innerHTML = textButton;
                        submitButton.setAttribute('disabled',false);
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

                  const penandaTanganSurat = $('#pilihanGambar').val();
                  if(penandaTanganSurat === '5'){
                      gambar.style.display = 'none'; // qrcode
                      footer.style.display = 'none'; // qrcode
                  } else{
                      gambar2.style.display = 'none'; // optik
                      footer.style.display = 'none'; // optik
                  }
              }, 100); // Tunggu 100ms untuk memastikan gambar barcode selesai digambar
          });
        });

        checkboxBarcode.addEventListener('change', function () {
            var opsiGambar = $('#pilihanGambar').val()
            // console.log(opsiGambar)
            if(opsiGambar == null){
                alert('Silahkan pilih penanda tangan surat tugas!');
                $('#barCode').prop('checked',false)
            }
            // gambar.style.display = 'block'
            // gambar2.style.display = 'block';
            if (this.checked) {
                if(opsiGambar == '5') {
                    gambar.style.display = 'block'; // Tampilkan gambar ketika checkbox di checklist
                    gambar2.style.display = 'none'; // Sembunyikan gambar ketika checkbox di checklist
                }else{
                    gambar.style.display = 'none'; // Sembunyikan gambar ketika checkbox di checklist
                    gambar2.style.display = 'block'; // Tampilkan gambar ketika checkbox di checklist
                }
            } else {
                if(opsiGambar == '5'){
                    gambar.style.display = 'none'; // Sembunyikan gambar ketika checkbox di checklist
                }else{
                    gambar2.style.display = 'none'; // Sembunyikan gambar ketika checkbox di checklist
                }
            }
        });

        function handleSelectChange(ini) {
          const currentValue = document.getElementById('pilihanGambar').value;
          idAsn = currentValue;

          var checkbox = $('#barCode:checkbox:checked').length;
          if (checkbox > 0 ){
                // if(currentValue == '5') {
                //     gambar.style.display = 'block'; // Tampilkan gambar ketika checkbox di checklist
                //     gambar2.style.display = 'none'; // Tampilkan gambar ketika checkbox di checklist
                // }else{
                //     gambar.style.display = 'none'; // Tampilkan gambar ketika checkbox di checklist
                //     gambar2.style.display = 'block'; // Tampilkan gambar ketika checkbox di checklist
                // }
            // if (currentValue === '5') {
            //     document.getElementById('draggable-div').style.display = 'block';
            //     document.getElementById('qr-2').style.display = 'none';
            // } else {
            //     document.getElementById('draggable-div').style.display = 'none';
            //     document.getElementById('qr-2').style.display = 'block';
            // }
          }
        // console.log("\nQR : "+document.getElementById('draggable-div').style.display)
        // console.log('QRS : '+document.getElementById('qr-2').style.display)

          if (currentValue === '5') {
              document.getElementById('surat_pendukung').style.display = 'none';
          } else {
              document.getElementById('surat_pendukung').style.display = 'block';
          }
          // console.log(currentValue);
        }

        // Event listener untuk elemen <select>
        // document.getElementById('pilihanGambar').addEventListener('change', function () {
        //     const selectedValue = this.value;
        //     console.log(selectedValue)
        //     var checkbox = $('#barCode:checkbox:checked').length;
        //     if (checkbox > 0 ){
        //         if (selectedValue === '5') {
        //             document.getElementById('draggable-div').style.display = 'block';
        //             document.getElementById('mydiv2').style.display = 'none';
        //         } else {
        //             document.getElementById('draggable-div').style.display = 'none';
        //             document.getElementById('mydiv2').style.display = 'block';
        //         }
        //     }
        //     if (selectedValue === '5') {
        //     	document.getElementById('surat_pendukung').style.display = 'none';
        //     } else {
        //     	document.getElementById('surat_pendukung').style.display = 'block';
        //     }
        // });





        checkboxFooter.addEventListener('change', function () {
            if (this.checked) {
                footer.style.display = 'block'; // Tampilkan footer ketika checkbox di checklist
            } else {
                footer.style.display = 'none'; // Sembunyikan footer ketika checkbox tidak di checklist
            }
        });


		// // Fungsi untuk menggambar elemen footer pada elemen canvas
		function drawFooterOnCanvas() {
			const canvas = document.getElementById('pdfCanvas');
			const ctx = canvas.getContext("2d");
			var imageFooter = document.getElementById('footer');

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
		});

</script>
</body>
</html>
