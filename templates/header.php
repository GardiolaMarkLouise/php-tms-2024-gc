<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="public/assets/img/tms-final.png" type="image/x-icon" />
<link rel="icon" href="public/assets/img/gc-logo.png" type="image/x-icon" />

<!-- checkboxes -->
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>


<!-- Fonts and icons -->
<script src="assets/js/plugin/webfont/webfont.min.js"></script>
<script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
            urls: ['assets/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>


<script>
    //if browser support service worker
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("sw.js").then(() => {
            console.log("[ServiceWorker**] - Registered");
        });
    }
</script>


<!-- CSS Files -->
<link rel="stylesheet" href="assets/css/buttons.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/atlantis.css">
<link rel="stylesheet" href="assets/css/custom.css">
<link rel="manifest" href="public/manifest.json">
<link rel="apple-touch-icon" href="assets/img/tms-final.png">
<link rel="apple-touch-icon" href="assets/img/gc-logo.png">
<link rel="apple-touch-icon" sizes="192x192" href="assets/img/icon-192x192.png">
<link rel="apple-touch-icon" sizes="256x256" href="assets/img/icon-256x256.png">
<link rel="apple-touch-icon" sizes="384x384" href="assets/img/icon-384x384.png">
<link rel="apple-touch-icon" sizes="512x512" href="assets/img/icon-512x512.png">

<style>
    #loading-container {
        position: absolute;
        display: flex;
        height: 100%;
        width: 100%;
        background-color: white;
        z-index: 9999;
    }

    #loading-screen {
        position: absolute;
        left: 48%;
        top: 48%;
        z-index: 9999;
        text-align: center;
    }
</style>