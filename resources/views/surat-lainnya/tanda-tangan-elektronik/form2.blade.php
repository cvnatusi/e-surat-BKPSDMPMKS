<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title> TTE</title>
    <style>
        #canvas {
            /* height: 300px;
            width: 565px; */
            border: 1px solid red;
        }
        img {
			cursor: move;
		}
        .box {
            border: 1px solid white;
            height: 45rem;
            width: 40rem;
            background-color: white;
        }
    </style>
    {{-- <script>
        $(function(){
            var img = new Image();
            img.onload = function(){
                ctx.drawImage(img, 0,0);
            };
            img.src = "../gambar/QR.png";

            var canvas=document.getElementById("canvas");
            var ctx=canvas.getContext("2d");
            var canvasOffset=$("#canvas").offset();
            var offsetX=canvasOffset.left;
            var offsetY=canvasOffset.top;
            var canvasWidth=canvas.width;
            var canvasHeight=canvas.height;
            var isDragging=false;

            function handleMouseDown(e){
            canMouseX=parseInt(e.clientX-offsetX);
            canMouseY=parseInt(e.clientY-offsetY);
            // set the drag flag
            isDragging=true;
            }

            function handleMouseUp(e){
            canMouseX=parseInt(e.clientX-offsetX);
            canMouseY=parseInt(e.clientY-offsetY);
            // clear the drag flag
            isDragging=false;
            }

            function handleMouseOut(e){
            canMouseX=parseInt(e.clientX-offsetX);
            canMouseY=parseInt(e.clientY-offsetY);
            // user has left the canvas, so clear the drag flag
            //isDragging=false;
            }

            function handleMouseMove(e){
            canMouseX=parseInt(e.clientX-offsetX);
            canMouseY=parseInt(e.clientY-offsetY);
            // if the drag flag is set, clear the canvas and draw the image
            if(isDragging){
                ctx.clearRect(0,0,canvasWidth,canvasHeight);
                ctx.drawImage(img,canMouseX-128/2,canMouseY-120/2,128,120);
            }
            console.log('X : '+canMouseX , '|' , 'Y : '+ canMouseY);
            }

            $("#canvas").mousedown(function(e){handleMouseDown(e);});
            $("#canvas").mousemove(function(e){handleMouseMove(e);});
            $("#canvas").mouseup(function(e){handleMouseUp(e);});
            $("#canvas").mouseout(function(e){handleMouseOut(e);});

        });
    </script> --}}
</head>
<body>
    <div class=" content">  
        <div class="row">
            <div class="col">
                <div class="card card-form m-3 p-3">
                    <form class="form-save">
                        <h6><b><i>e</i> -Tanda Tangan</b></h6>
                        <hr>
                        <label for="inputBox yang_bertanda_tangan" id="label_tujuan_surat" class="form-label">Penanda Tangan Surat Tugas <span>*</span></label>
                        <select class="form-select mb-3" id="pilihanGambar" aria-label="Default select example">
                            <option value="" selected disabled>Pilih penanda tangan</option>
                                @foreach ($asn as $ttd)
                                    <option value="{{$ttd->id_mst_asn}}" >{{$ttd->nama_asn}} @if ($ttd->id_mst_asn == 5) (KABAN) @else SEKDA @endif</option>
                                @endforeach
                            </select>
                            <div id="surat_pendukung" style="display: none; margin-bottom: 10px;">
                                <div class="col-md-12">
                                    <label for="file_scan" class="form-label">Upload Surat Pendukung<span>*</span></label>
                                    <input class="form-control" type="file" id="myPdf2" name="file_scan">
                                </div>
                            </div>  
                            <div class="col-md-12">
                                <label for="file_scan" class="form-label">Upload Surat <span>*</span> </label>
                                <input class="form-control" type="file" id="myPdf" name="file_scan" accept="application/pdf" >
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
                            <div class="row" style="margin-top: 26.5rem">
                                <div class="col-md-6">
                                        <button id="convertToPDF" class="btn btn-primary col-md-11">SIMPAN</button>
                                </div>
                                <div class="col-md-6">
                                        <button id="cancel" class="btn btn-secondary col-md-11">KEMBALI</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="col">
                <div>
					<button type="button" class="btn btn-secondary" id="prev">Previous</button> 
					    <button type="button" class="btn btn-secondary" id="next">Next</button>
					        &nbsp; &nbsp;
					<span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
				</div>
                {{-- <div class="box">
                </div> --}}
                <div class="card card-form m-3 p-3" style="height: 750px; width: 600px;">
                    <canvas id="canvas" width=400 height=500></canvas>

                    <div id="mydiv" draggable="true" style="display: none;  position: absolute; left: 100px; top: 200px;">
						<img src="{{asset('gambar/QR.png')}}" id="mydivheader" style="height: 90px; width: 90px;">
					</div>
					<div id="mydiv2" draggable="true" style="display: none;  position: absolute; left: 100px; top: 200px;">
						<img src="{{asset('assets/images/qr-code.png')}}" id="mydivheader2" style="height: 100px; width: 100px;">
					</div>
					<div id="footer" draggable="true" style="display: none; position: absolute; left: 130px; top: 700px;" >
						<img src="{{ asset('assets/images/footer-bsre.png') }}" id="gambarFooter" style="width: 28rem;">
					</div>
                </div>
			</div>
            </div>
        </div>
	</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" type="text/javascript" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.js"></script>
    <script src="{{asset('pdf/build/preview.js')}}"></script>


    <script type="text/javascript">
        const checkboxBarcode = document.getElementById('barCode');
        const checkboxFooter = document.getElementById('footerTTE');
        const gambar2 = document.getElementById('mydiv2');
        const gambar = document.getElementById('mydiv');



        document.getElementById('pilihanGambar').addEventListener('change', function () {
            const selectedValue = this.value;
            // console.log(selectedValue)
            var checkbox = $('#barCode:checkbox:checked').length;
            if (checkbox > 0 ){
                if (selectedValue === '5') {
                    document.getElementById('mydiv').style.display = 'block';
                    document.getElementById('mydiv2').style.display = 'none';
                } else {
                    document.getElementById('mydiv').style.display = 'none';
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
            if(opsiGambar === null){
                alert('Silahkan pilih penanda tangan surat tugas!');
                $('#barCode').prop('checked',false)
            }
            if (this.checked) {
                if(opsiGambar == '5'){
                    gambar.style.display = 'block'; // Tampilkan gambar ketika checkbox di checklist
                    gambar2.style.display = 'none'; // Sembunyikan gambar ketika checkbox tidak di checklist
                }else{
                    gambar.style.display = 'none'; // Sembunyikan gambar ketika checkbox tidak di checklist
                    gambar2.style.display = 'block'; // Tampilkan gambar ketika checkbox di checklist
                }
            } else {
                if(opsiGambar == '5'){
                    gambar.style.display = 'none'; // Sembunyikan gambar ketika checkbox tidak di checklist
                }else{
                    gambar2.style.display = 'none'; 
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

        // SECTION SAVE FILE
        var resfile = ""
        document.getElementById('myPdf').addEventListener('change', function () {
            var file_ = this.files[0]; // Ambil file yang dipilih oleh pengguna
            resfile = file_
        });

        function dragElement(elmnt) {
            var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            if (document.getElementById(elmnt.id + "header")) {
                // Jika elemen header ada, inilah tempat Anda menggeser DIV dari sana:
                document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
            } else {
                // Jika tidak, maka Anda dapat menggeser DIV dari mana saja di dalam DIV:
                elmnt.onmousedown = dragMouseDown;
            }

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                // Dapatkan posisi kursor mouse saat memulai:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // Panggil fungsi setiap kali kursor bergerak:
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                // Hitung posisi kursor baru:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // Tetapkan posisi baru elemen:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";

                // Panggil fungsi drawBarcodeOnCanvas untuk menggambar elemen
                drawBarcodeOnCanvas(elmnt, pos3, pos4);
            }

            function closeDragElement() {
                // Berhenti menggeser ketika tombol mouse dilepas:
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }

        function drawBarcodeOnCanvas(elmnt, posX, posY) {
            console.log(posX, posY);
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');
            const penandaTangan = $('#pilihanGambar').val();

            // Ambil posisi elemen "mydiv" dan gambar barcode
            var qrcode = document.getElementById('mydivheader');
            var optik = document.getElementById('mydivheader2');

            // penandaTangan===0 {qrcode} start
            var image = qrcode;
            var divX = parseInt(posX);
            var divY = parseInt(posY);
            // penandaTangan===0 {qrcode} end

            if (penandaTangan === '52') { // penandaTangan === 52 {optik}
                image = optik;
                divX = parseInt(posX);
                divY = parseInt(posY);
            }

            const width = 90;
            const height = 90;

            ctx.drawImage(image, divX, divY, width, height);
        }

        // Function untuk menggambar elemen barcode
        function drawBarcodeOnCanvas() {
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');
            const penandaTangan = $('#pilihanGambar').val();

            // Ambil posisi elemen "mydiv" dan gambar barcode
            var qrcode = document.getElementById('mydivheader');
            var optik = document.getElementById('mydivheader2');

            // penandaTangan===0 {qrcode} start
            var image = qrcode;

            if (penandaTangan === '0') { // penandaTangan === 0 {qrcode}
                // divX dan divY telah diatur di dalam fungsi elementDrag
            }

            if (penandaTangan === '52') { // penandaTangan === 52 {optik}
                image = optik;
                // divX dan divY telah diatur di dalam fungsi elementDrag
            }

            const width = 90;
            const height = 90;

            ctx.drawImage(image, divX, divY, width, height);
        }


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
                drawBarcodeOnCanvas();
                drawFooterOnCanvas();
            } else if (checkboxBarcode.checked) {  // Tampilkan hanya elemen barcode pada elemen canvas
                drawBarcodeOnCanvas();
            } else if (checkboxFooter.checked) {   // Tampilkan hanya elemen footer pada elemen canvas
                drawFooterOnCanvas();
            }
            // Ubah elemen canvas menjadi URL data
            const canvas = document.getElementById('canvas');
            const imgData = canvas.toDataURL('image/png');

            // Buat objek jsPDF
            const pdf = new jsPDF({
                orientation: "portrait",
                unit: "mm",
                // format: [210.00, 330.00]
                format: [230.00, 330.00]
            });
            const imgWidth = 3508; // Lebar A4 dalam piksel
            var pageHeight = 295;  
            const imgHeight = canvas.height * imgWidth / canvas.width;
            var heightLeft = imgHeight;
            pdf.addImage(imgData, 'PNG', 0, 0, 210, 330); // Tambahkan gambar ke dokumen PDF

            /* Simpan dokumen PDF dalam format Base64
            Anda dapat menggunakan pdfBase64 untuk tujuan yang diinginkan, seperti menyimpannya ke server atau mengirimkannya melalui AJAX. */
            const pdfBase64 = pdf.output('dataurlstring');
            var penandaTangan = $('#pilihanGambar').val();
            // return console.log(resfile)

            // ----------------------------------------- //
            // var imgData = canvas.toDataURL('image/png');
            //     var imgWidth = 210; 
            //     var pageHeight = 295;  
            //     var imgHeight = canvas.height * imgWidth / canvas.width;
            //     var heightLeft = imgHeight;
            //     var doc = new jsPDF('p', 'mm');
            //     var position = 10; // give some top padding to first page

            //     doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            //     heightLeft -= pageHeight;

            //     while (heightLeft >= 0) {
            //     position += heightLeft - imgHeight; // top padding for other pages
            //     doc.addPage();
            //     doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            //     heightLeft -= pageHeight;
            //     }
            // doc.save( 'file.pdf');
            // ----------------------------------------- //


            $.ajax({
                url: '{{ route("savePDF" )}}',
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
    </script>

    <script type="text/javascript">
        $(function () {
            var img = new Image();
            img.onload = function () {
                ctx.drawImage(img, 0, 0, img.width, img.height);
            };
            img.src = "../gambar/QR.png";

            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext("2d");
            var canvasOffset = $("#canvas").offset();
            var offsetX = canvasOffset.left;
            var offsetY = canvasOffset.top;
            var canvasWidth = canvas.width;
            var canvasHeight = canvas.height;
            var isDragging = false;

            // Faktor perubahan ukuran gambar (misalnya, 1.2 kali)
            var scaleFactor = 1.2;

            function handleMouseDown(e) {
                canMouseX = parseInt(e.clientX - offsetX);
                canMouseY = parseInt(e.clientY - offsetY);
                // set the drag flag
                isDragging = true;
            }

            function handleMouseUp(e) {
                canMouseX = parseInt(e.clientX - offsetX);
                canMouseY = parseInt(e.clientY - offsetY);
                // clear the drag flag
                isDragging = false;
            }

            function handleMouseOut(e) {
                canMouseX = parseInt(e.clientX - offsetX);
                canMouseY = parseInt(e.clientY - offsetY);
                // user has left the canvas, so clear the drag flag
                isDragging = false;
            }

            function handleMouseMove(e) {
                canMouseX = parseInt(e.clientX - offsetX);
                canMouseY = parseInt(e.clientY - offsetY);
                // if the drag flag is set, clear the canvas and draw the image
                if (isDragging) {
                    ctx.clearRect(0, 0, canvasWidth, canvasHeight);
                    var newWidth = img.width * 0.1;
                    var newHeight = img.height * 0.1;
                    ctx.drawImage(img, canMouseX - newWidth / 2, canMouseY - newHeight / 2, newWidth, newHeight);
                    console.log('X ' + canMouseX, 'Y ' + canMouseY);
                }
            }

            $("#canvas").mousedown(function (e) { handleMouseDown(e); });
            $("#canvas").mousemove(function (e) { handleMouseMove(e); });
            $("#canvas").mouseup(function (e) { handleMouseUp(e); });
            $("#canvas").mouseout(function (e) { handleMouseOut(e); });

        });

    // PREVIEW FILE PDF
    $(document).ready(function () {
        document.getElementById('myPdf').addEventListener('change', function (event) {
            // console.log('ashvdlva');
        const file = event.target.files[0];
        
        if (file && file.type === 'application/pdf') {
            const pdfjsLib = window['pdfjs-dist/build/pdf'];

            // Initialize a FileReader
            const reader = new FileReader();
        
            reader.onload = function (e) {
            // Read the PDF file as an ArrayBuffer
            const buffer = e.target.result;
        
            // Load and render the first page of the PDF
            pdfjsLib.getDocument({ data: buffer }).promise.then(function (pdfDoc) {
                const canvas = document.getElementById('canvas');
                const context = canvas.getContext('2d');
                let pageNum = 1;
        
                // Function to render a page
                function renderPage() {
                pdfDoc.getPage(pageNum).then(function (page) {
                    const viewport = page.getViewport({ scale: 1 });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
        
                    const renderContext = {
                    canvasContext: context,
                    viewport: viewport,
                    };
        
                    page.render(renderContext).promise.then(function () {
                    // Canvas is now populated with the PDF content
                    });
                });
        
                document.getElementById('page_num').textContent = pageNum;
                document.getElementById('page_count').textContent = pdfDoc.numPages;
                }
        
                // Initial page rendering
                renderPage();
        
                // Event listener for previous page button
                document.getElementById('prev').addEventListener('click', function () {
                if (pageNum <= 1) {
                    return;
                }
                pageNum--;
                renderPage();
                });
        
                // Event listener for next page button
                document.getElementById('next').addEventListener('click', function () {
                if (pageNum >= pdfDoc.numPages) {
                    return;
                }
                pageNum++;
                renderPage();
                });
            });
            };
        
            // Read the selected file as an ArrayBuffer
            reader.readAsArrayBuffer(file);
        }
        });
        
        $('#remove_file').on('click', function () {
            $('#myPdf').val('');
            const canvas = document.getElementById('canvas');
            if (canvas.tagName === 'CANVAS') {
                const context = canvas.getContext('2d');
                context.clearRect(0, 0, canvas.width, canvas.height); 
            } else {
                console.log("Elemen dengan ID 'pdfCanvas' bukan elemen canvas.");
            }
            $('#page_num').textContent = '';
            $('#page_count').textContent = '';
        });

    });
    </script>

    {{-- <script>
        $(function() {
            var img = new Image();
            img.onload = function(){
                ctx.drawImage(img, 0,0);
            };

            img.src = "../gambar/QR.png";

            var canvas=document.getElementById("canvas");
            var ctx=canvas.getContext("2d");
            var canvasOffset=$("#canvas").offset();
            var offsetX=canvasOffset.left;
            var offsetY=canvasOffset.top;
            var canvasWidth=canvas.width;
            var canvasHeight=canvas.height;
            var isDragging=false;

            function handleMouseDown(e){
            canMouseX=parseInt(e.clientX-offsetX);
            canMouseY=parseInt(e.clientY-offsetY);
            // set the drag flag
            isDragging=true;
            }

            function handleMouseUp(e){
            canMouseX=parseInt(e.clientX-offsetX);
            canMouseY=parseInt(e.clientY-offsetY);
            // clear the drag flag
            isDragging=false;
            }

            function handleMouseOut(e){
            canMouseX=parseInt(e.clientX-offsetX);
            canMouseY=parseInt(e.clientY-offsetY);
            // user has left the canvas, so clear the drag flag
            //isDragging=false;
            }
            
            function handleMouseMove(e){
            canMouseX=parseInt(e.clientX-offsetX);
            canMouseY=parseInt(e.clientY-offsetY);
            // if the drag flag is set, clear the canvas and draw the image
            if(isDragging){
                ctx.clearRect(0,0,canvasWidth,canvasHeight);
                ctx.drawImage(img,canMouseX-128/2,canMouseY-120/2,128,120);
            console.log('X ' + canMouseX, 'Y ' + canMouseY);
            }
            }

            $("#canvas").mousedown(function(e){handleMouseDown(e);});
            $("#canvas").mousemove(function(e){handleMouseMove(e);});
            $("#canvas").mouseup(function(e){handleMouseUp(e);});
            $("#canvas").mouseout(function(e){handleMouseOut(e);});
        })
    </script> --}}



</body>
</html>