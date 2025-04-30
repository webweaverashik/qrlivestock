<!--begin::QR Scanner Modal-->
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">আইডি স্ক্যান করুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="বন্ধ করুন"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qr-reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                <div id="qr-reader-results" style="margin-top: 10px;"></div>
                <div id="scan-message" class="mt-2">স্ক্যান শুরুর জন্য প্রস্তুত...</div>

                <!-- Hidden Input for Hardware Scanner -->
                <input type="text" id="hardwareScannerInput" class="form-control mt-3" autocomplete="off"
                    placeholder="Scan QR Code..." />
            </div>
        </div>
    </div>
</div>
<!--end::QR Scanner Modal-->



<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    const html5QrCode = new Html5Qrcode("qr-reader");
    const qrResultElement = document.getElementById('qr-reader-results');
    const startScanButton = document.getElementById('start-scan');
    const scanMessage = document.getElementById('scan-message');
    const qrScannerModal = document.getElementById('qrScannerModal');
    const hardwareScannerInput = document.getElementById('hardwareScannerInput');

    let isScanning = false;

    const qrboxSize = window.innerWidth > 600 ? 250 : window.innerWidth - 40;

    function handleScannedData(scannedValue) {
        scanMessage.innerText = "প্রসেস করা হচ্ছে...";
        let farmUniqueId = null;

        try {
            const matches = scannedValue.match(/\/(\d+)\/?$/);
            if (matches && matches[1]) {
                farmUniqueId = matches[1];
            } else {
                throw new Error("Invalid QR code format");
            }
        } catch (error) {
            toastr.error("কার্ডটি সঠিক নয়।");
            scanMessage.innerText = "আবার চেষ্টা করুন";
            return;
        }

        fetch(`/farms/search`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    farm_unique_id: farmUniqueId
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    toastr.error(data.error);
                    scanMessage.innerText = "আবার চেষ্টা করুন";
                } else {
                    toastr.success("খামারটি সফলভাবে খুঁজে পাওয়া গেছে!");
                    scanMessage.innerText = "রিডাইরেক্ট করা হচ্ছে...";
                    setTimeout(() => {
                        window.location.href = `/farms/${data.farm.id}`;
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error("সার্ভারে একটি সমস্যা হয়েছে।");
                scanMessage.innerText = "আবার চেষ্টা করুন";
            });
    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scan result: ${decodedText}`, decodedResult);
        html5QrCode.stop();
        isScanning = false;
        handleScannedData(decodedText);
    }

    function onScanFailure(error) {
        // Optional: for debugging scan failures
        // console.warn(`QR error: ${error}`);
    }

    // Start webcam scan
    startScanButton.addEventListener('click', () => {
        if (!isScanning) {
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 30,
                    qrbox: qrboxSize,
                },
                onScanSuccess,
                onScanFailure
            );
            isScanning = true;
            scanMessage.innerText = "স্ক্যান চলছে...";
            qrResultElement.innerHTML = '';
        }
    });

    // Handle hardware scanner input
    hardwareScannerInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const scannedValue = hardwareScannerInput.value.trim();
            hardwareScannerInput.value = '';
            if (scannedValue) {
                handleScannedData(scannedValue);
            }
        }
    });

    // Modal open: reset, focus input
    qrScannerModal.addEventListener('shown.bs.modal', function() {
        scanMessage.innerText = "স্ক্যান শুরুর জন্য প্রস্তুত...";
        hardwareScannerInput.focus();
    });

    // Modal close: stop scanner
    qrScannerModal.addEventListener('hidden.bs.modal', function() {
        if (isScanning) {
            html5QrCode.stop();
            isScanning = false;
        }
        hardwareScannerInput.classList.add('d-none');
        scanMessage.innerText = "স্ক্যান শুরুর জন্য প্রস্তুত...";
    });

    // Page unload: stop scanner
    window.onunload = function() {
        if (isScanning) {
            html5QrCode.stop();
            isScanning = false;
        }
    };
</script>