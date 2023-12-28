// function dragElement(elmnt) {
//     var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
//     if (document.getElementById(elmnt.id + "header")) {
//       // if present, the header is where you move the DIV from:
//       document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
//     } else {
//       // otherwise, move the DIV from anywhere inside the DIV:
//       elmnt.onmousedown = dragMouseDown;
//     }
  
//     function dragMouseDown(e) {
//       e = e || window.event;
//       e.preventDefault();
//       // get the mouse cursor position at startup:
//       pos3 = e.clientX;
//       pos4 = e.clientY;
//       document.onmouseup = closeDragElement;
//       // call a function whenever the cursor moves:
//       document.onmousemove = elementDrag;
//     }
  
//     function elementDrag(e) {
//       e = e || window.onload;
//       e.preventDefault();
//       // calculate the new cursor position:
//       pos1 = pos3 - e.clientX;
//       pos2 = pos4 - e.clientY;
//       pos3 = e.clientX;
//       pos4 = e.clientY;
//       // set the element's new position:
//       elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
//       elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
//       console.log(pos1,pos2,"X :"+pos3,"Y :"+pos4);
//     }
  
//     function closeDragElement() {
//       // stop moving when mouse button is released:
//       document.onmouseup = null;
//       document.onmousemove = null;
//     }
//   };
  
//   dragElement(document.getElementById("mydiv")); // qrcode
//   dragElement(document.getElementById("mydiv2")); // optik

  // Fungsi untuk menggambar elemen barcode pada elemen canvas
  function drawBarcodeOnCanvas(pos3, pos4) {
    const canvas = document.getElementById('pdfCanvas');
    const ctx = canvas.getContext("2d");
    const penandaTangan = $('#pilihanGambar').val()

    // Ambil posisi elemen "mydiv" dan gambar barcode
    var qrcode = document.getElementById('mydivheader');
    var optik = document.getElementById('mydivheader2');

    // penandaTangan===0 {qrcode} start
    var image = qrcode
    // var divX = parseInt(document.getElementById('mydiv').style.left, 10);
    // var divY = parseInt(document.getElementById('mydiv').style.top, 10);
    var divX = parseInt(document.getElementById('mydiv').style.left, pos3);
    // var divY = parseInt(document.getElementById('mydiv').style.top, 13.2);
    var divY = parseInt(document.getElementById('mydiv').style.top, pos4);
    // penandaTangan===0 {qrcode} end

    if(penandaTangan === '52'){ // penandaTangan === 52 {optik}
    image = optik
    // divX = parseInt(document.getElementById('mydiv2').style.left, 9.8);
    // divY = parseInt(document.getElementById('mydiv2').style.top, 13.2);
    divX = parseInt(document.getElementById('mydiv2').style.left, 10);
    divY = parseInt(document.getElementById('mydiv2').style.top, 10);
    }

    // const height = parseInt(image.height)
    // const width = parseInt(image.width)
    // ctx.drawImage(image, divX-9, divY-26, isNaN(width)?150:width+48, isNaN(height)?150:height+55);
    const width = 90;
    const height = 90;

    ctx.drawImage(image, divX, divY, width, height);
}

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
            const canvas = document.getElementById('pdfCanvas');
            const context = canvas.getContext('2d');
            let pageNum = 1;
    
            // Function to render a page
            function renderPage() {
              pdfDoc.getPage(pageNum).then(function (page) {
                const viewport = page.getViewport({ scale: 1 });
                // console.log(viewport);
                console.log(`Ukuran Halaman ${pageNum}: Lebar ${viewport.width}px, Panjang ${viewport.height}px`);
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

              // console.log(`Ukuran Halaman ${pageNum}: Panjang ${width}px, Lebar ${height}px`);
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
          const canvas = document.getElementById('pdfCanvas');
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

