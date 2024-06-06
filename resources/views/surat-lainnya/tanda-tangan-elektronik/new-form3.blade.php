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

		#mydiv, #mydiv2 {
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

		/* #canvas{border:1px solid red;} */
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
							{{-- <option value="0" >Drs. SAUDI RAHMAN, M.Si (KABAN)</option>
								<option value="1" >Ir. TOTOK HARTONO (SEKDA)</option> --}}
						@endforeach
					</select>
					<div class="col-md-12 mt-3">
						<label for="file_scan" class="form-label">Upload Surat <span>*</span></label>
						<input class="form-control" type="file" id="myPdf" name="file_scan" accept="application/pdf" >
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
								{{-- <button  onclick="convertToPDF()" style="padding: 10px; background: " class="btn btn-primary col-md-11">SIMPAN</button> --}}
								{{-- <button style="padding: 10px; background: " id="simpan" class="btn btn-primary col-md-11">SIMPAN</button> --}}
								{{-- <button type="button" class="btn btn-secondary px-4 btn-cancel">Kembali</button> --}}
								<button id="convertToPDF" class="btn btn-primary col-md-11">SIMPAN</button>
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

					{{-- <button type="button" id="remove_file" class="btn btn-secondary float-end">Cancel</button> --}}
					{{-- <div class="col ms-2">
						<button type="button" id="remove_files" onclick="PreviewImage()" class="btn btn-secondary float-end">Show Preview</button>
						<iframe id="pdfViewer" frameborder="0" scrolling="no" width="700" height="750"></iframe>
					</div> --}}
				</div>
				<div class="card preview border-0 border-0 border-primary panel-form" style="background-color: rgb(222, 228, 226)">
					<div class="previewFile">
						<canvas id="pdfCanvas"></canvas>
					</div>
					<div id="mydiv" class="draggable" draggable="true" style="display: none;  position: absolute; left: 71px; top: -1px;">
						<img src="{{asset('gambar/QR.png')}}" id="mydivheader" style="height: 90px; width: 90px;">
					</div>
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
		{{-- <canvas id="canvas" width=300 height=300></canvas> --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/interact.js/1.10.11/interact.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Lobibox/1.0.0/css/lobibox.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Lobibox/1.0.0/js/lobibox.min.js"></script>
        <script src="{{ asset('js/dist/interact.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js" integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script type="text/javascript">
    $('.select2').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
        tags: true,
    });

    document.getElementById('convertToPDF').addEventListener('click', convertToPDF);

    let imgWidth = 150, imgHeight = 150;
    let xDrag = 250, yDrag = 250;
    let isRendering = false;

    function drawBarcode(xDrag, yDrag) {
      let canvas = document.getElementById("pdfCanvas");
      let ctx = canvas.getContext("2d");
      let img = document.querySelector("#mydiv img");
      if (imgWidth > 0 && imgHeight > 0) {
        ctx.drawImage(img, xDrag, yDrag, imgWidth, imgHeight);
      } else {
        ctx.drawImage(img, xDrag, yDrag);
      }
    }

    document.getElementById('myPdf').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file.type !== 'application/pdf') {
        alert('Please upload a PDF file.');
        return;
      }

      const fileReader = new FileReader();
      fileReader.onload = function() {
        const typedArray = new Uint8Array(this.result);
        const pdfCanvas = document.getElementById('pdfCanvas');
        const context = pdfCanvas.getContext('2d');

        pdfjsLib.getDocument(typedArray).promise.then(function(pdf) {
          return pdf.getPage(pdf.numPages).then(function(page) {
            const scale = 1.5;
            const viewport = page.getViewport({ scale: scale });

            pdfCanvas.height = viewport.height;
            pdfCanvas.width = viewport.width;

            const renderContext = {
              canvasContext: context,
              viewport: viewport
            };

            return page.render(renderContext).promise.then(() => {
              document.getElementById('mydiv').style.display = 'block';
            });
          });
        });
      };

      fileReader.readAsArrayBuffer(file);
    });

    interact('.draggable')
      .resizable({
        edges: { left: true, right: true, bottom: true, top: true },
        listeners: {
          move(event) {
            const target = event.target.querySelector('img');
            let x = (parseFloat(target.getAttribute('data-x')) || 0);
            let y = (parseFloat(target.getAttribute('data-y')) || 0);

            target.style.width = event.rect.width + 'px';
            target.style.height = event.rect.height + 'px';

            x += event.deltaRect.left;
            y += event.deltaRect.top;

            target.parentElement.style.transform = `translate(${x}px, ${y}px)`;

            target.setAttribute('data-x', x);
            target.setAttribute('data-y', y);

            imgWidth = event.rect.width;
            imgHeight = event.rect.height;

            xDrag = x;
            yDrag = y;
          }
        },
        modifiers: [
          interact.modifiers.restrictEdges({ outer: 'parent' }),
          interact.modifiers.restrictSize({ min: { width: 30, height: 30 } })
        ],
        inertia: true
      })
      .draggable({
        listeners: {
          move(event) {
            const target = event.target;
            xDrag = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
            yDrag = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

            target.style.transform = `translate(${xDrag}px, ${yDrag}px)`;

            target.setAttribute('data-x', xDrag);
            target.setAttribute('data-y', yDrag);
          }
        },
        inertia: true,
        modifiers: [
          interact.modifiers.restrictRect({ restriction: 'parent', endOnly: true })
        ]
      });

    let resfile = ""
    document.getElementById('myPdf').addEventListener('change', function () {
      var file_ = this.files[0];
      resfile = file_
    });

    $('#convertToPDF').click(async function(e) {
      e.preventDefault();

      if (isRendering) {
        console.log('Rendering in progress. Please wait.');
        return;
      }

      isRendering = true;

      window.jsPDF = window.jspdf.jsPDF;

      const penandaTangan = $('#pilihanGambar').val();
      const checkboxBarcode = document.getElementById('barCode');
      const checkboxFooter = document.getElementById('footerTTE');

      if (checkboxBarcode.checked && checkboxFooter.checked) {
        drawBarcode(xDrag + 50, yDrag + 90);
        drawFooterOnCanvas();
      } else if (checkboxBarcode.checked) {
        drawBarcode(xDrag, yDrag);
      } else if (checkboxFooter.checked) {
        drawFooterOnCanvas();
      }

      const canvas = document.getElementById('pdfCanvas');
      await new Promise((resolve) => setTimeout(resolve, 100));

      const imgData = canvas.toDataURL('image/png');

      const pdf = new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: [230.00, 330.00]
      });

      const imgWidth = 3508;
      const imgHeight = canvas.height * imgWidth / canvas.width;
      pdf.addImage(imgData, 'PNG', 0, 0, 230, 330);

      const pdfBase64 = pdf.output('dataurlstring');

      try {
        const data = await $.ajax({
          url: '{{route("savePDF")}}',
          method: 'POST',
          data: {
            "_token": '{{csrf_token()}}',
            pdf: pdfBase64,
            namaSurat: resfile.name,
            penandaTangan: penandaTangan
          }
        });

        if (data.status === 'success') {
          Lobibox.notify('success', {
            pauseDelayOnHover: true,
            size: 'mini',
            rounded: true,
            delayIndicator: false,
            icon: 'bx bx-check-circle',
            continueDelayOnInactiveTab: false,
            position: 'top right',
            sound: false,
            msg: data.message
          });
          $('.other-page').fadeOut(function() {
            $('.other-page').empty();
            $('.card').fadeIn();
            location.reload();
            $('#datagrid').DataTable().ajax.reload();
          });
        } else if (data.status === 'error') {
          $('#convertToPDF');
          Lobibox.notify('error', {
            pauseDelayOnHover: true,
            size: 'mini',
            rounded: true,
            delayIndicator: false,
            icon: 'bx bx-x-circle',
            continueDelayOnInactiveTab: false,
            position: 'top right',
            sound: false,
            msg: data.message
          });
          swal('Error :' + data.errMsg.errorInfo[0], data.errMsg.errorInfo[2], 'warning');
        } else {
          let n = 0;
          for (const key in data) {
            if (n == 0) { var dt0 = key; }
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
            sound: false,
            msg: data.message
          });
        }
      } catch (error) {
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
          sound: false,
          msg: 'Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!'
        });
      } finally {
        isRendering = false;
      }
    });


</script>
</body>
</html>
