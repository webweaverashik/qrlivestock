<!--begin::QR Scanner Modal-->
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">আইডি স্ক্যান করুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="বন্ধ করুন"></button>
            </div>
            <div class="modal-body">
                <div id="qr-reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                <div id="qr-reader-results" style="margin-top: 10px; text-align: center;"></div>
                <div id="scan-message" class="text-center mt-2">স্ক্যান শুরুর জন্য প্রস্তুত...</div>
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

    let isScanning = false;

    const qrboxSize = window.innerWidth > 600 ? 250 : window.innerWidth - 40;

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scan result: ${decodedText}`, decodedResult);
        scanMessage.innerText = "প্রসেস করা হচ্ছে...";


        // Extract the numeric ID from the URL
        let farmUniqueId = null;
        try {
            // This will match the last numeric part of the URL
            const matches = decodedText.match(/\/(\d+)\/?$/);
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
                    farm_unique_id: farmUniqueId  // Using the extracted ID
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    // Show toast message based on error type
                    if (data.type === 'error') {
                        toastr.error(data.error);
                    } else {
                        toastr.warning(data.error);
                    }
                    scanMessage.innerText = "আবার চেষ্টা করুন";
                } else {
                    // Found a valid farm, stop scanning and redirect
                    html5QrCode.stop();
                    isScanning = false;
                    toastr.success("খামারটি সফলভাবে খুঁজে পাওয়া গেছে!");

                    scanMessage.innerText = "রিডাইরেক্ট করা হচ্ছে...";

                    // Delay slightly so user sees the success message before redirect
                    setTimeout(() => {
                        window.location.href = `/farms/${data.farm.id}`;
                    }, 2000); // 1 second delay
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error("সার্ভারে একটি সমস্যা হয়েছে।");
                scanMessage.innerText = "আবার চেষ্টা করুন";
            });
    }

    function onScanFailure(error) {
        // Optional: can be used for debugging frequent failures
        // console.warn(`QR error: ${error}`);
    }

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

    // Listen for modal hide event
    qrScannerModal.addEventListener('hidden.bs.modal', function() {
        if (isScanning) {
            html5QrCode.stop();
            isScanning = false;
            scanMessage.innerText = "স্ক্যান শুরুর জন্য প্রস্তুত...";
        }
    });

    // Stop scanning on page unload
    window.onunload = function() {
        if (isScanning) {
            html5QrCode.stop();
            isScanning = false;
        }
    };
</script>
