<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <title> TTE</title>
    <style>
        #canvas {
            /* height: 300px;
            width: 565px; */
            border: 1px solid red;
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
                                <label for="file_scan" class="form-label">Upload Surat</label>
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
                <div class="card card-form m-3 p-3" style="height: 750px; width: 600px;">
                    <canvas id="canvas" width=400 height=500>
                    </canvas>

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
    {{-- <script src="{{asset('pdf/build/preview.js')}}"></script> --}}
    {{-- <script type="text/javascript">
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
    </script> --}}


    <script>
        $(function() {
            var img = new Image();
            img.onload = function(){
                ctx.drawImage(img, 0,0);
            };

            img.src = "../gambar/QR.png";
        })
    </script>



</body>
</html>