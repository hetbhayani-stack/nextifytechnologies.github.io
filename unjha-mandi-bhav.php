<?php
/* Force search engines to index this page even if other included files send noindex */
header_remove("X-Robots-Tag");
header("X-Robots-Tag: index, follow", true);

require_once('/home3/envisvsx/public_html/common_apis/v2/beta/apmc_function.php');

$page_title = "Unjha Mandi Bhav Today – Jeera, Isabgol & APMC Market Rates";
$meta_description = "Check today's Unjha APMC mandi bhav including Jeera, Isabgol, Fennel and other crop prices. Updated Gujarat APMC market rates for farmers.";

/* Fetch market data server-side to hide API from browser network */
$api_url = "https://beta.envisiontechnolabs.com/apmc/api-market-rates.php";

$post_fields = http_build_query([
    "store_id" => 7,
    "type" => 1
]);

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
curl_close($ch);

$marketData = json_decode($response, true);
if (!$marketData) {
    $marketData = ["data" => [], "date" => ""];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>

    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Favicon & App Icons -->
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="image/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="image/favicon-16x16.png">

    <link rel="apple-touch-icon" sizes="180x180" href="image/apple-touch-icon.png">

    <link rel="icon" type="image/png" sizes="192x192" href="image/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="image/android-chrome-512x512.png">

    <!-- SVG icon (optional modern browsers) -->
    <link rel="icon" type="image/svg+xml" href="image/app_store.svg">

    <!-- Web App Manifest -->
    <link rel="manifest" href="/apmc/image/site.webmanifest">

    <meta name="theme-color" content="#ffffff">
    <meta name="application-name" content="APMC Mandi Bhav">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="APMC Mandi Bhav">
    <meta name="mobile-web-app-capable" content="yes">

    <link rel="canonical" href="https://envisiontechnolabs.com/apmc/unjha-mandi-bhav">

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $meta_description; ?>">
    <meta property="og:type" content="website">

    <!-- Basic styling -->
    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f5f7f2;
            color: #333;
        }

        .container {
            display: flex;
            gap: 30px;
            align-items: flex-start;
            max-width: 1200px;      /* center layout on desktop */
            margin: 0 auto;         /* horizontal center */
            padding: 30px 20px;     /* balanced padding for all screens */
        }

        .content {
            flex: 3;
            max-width: 720px;   /* stable readable width */
        }

        .review-sidebar {
            flex: 1;
            max-width: 320px;
            background: #fff;
            border-radius: 10px;
            padding: 7px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            height: fit-content;
        }

        .review-sidebar h3 {
            margin-top: 0;
            color: #1b5e20;
            text-align: center;
        }

        .review {
            display: none;
            font-size: 14px;
            line-height: 1.0;
            position: relative;
        }

        .review.active {
            display: block;
        }

        .review-text {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 8px;
            color: green;
            margin-top: -10px;
            text-align: center;
        }

        .review-user {
            font-weight: 700;
            margin-top: 6px;
            text-align: right;
            display: block;
        }

        /* large quote icon for testimonial style -- moved to inline HTML */

        .review-quote-start,
        .review-quote-end {
            font-size: 20px;
            color: #9b9797;
            font-weight: bold;
        }

        .review-quote-start {
            margin-right: 3px;
        }

        .review-quote-end {
            margin-left: 3px;
        }

        .review-dots {
            text-align: center;
            margin-top: 10px;
        }

        .review-dots span {
            height: 8px;
            width: 8px;
            margin: 3px;
            background: #ccc;
            display: inline-block;
            border-radius: 50%;
            cursor: pointer;
        }

        .review-dots span.active {
            background: #2e7d32;
        }

        .review-stars {
            margin: 6px 0 10px 0;
            font-size: 18px;
            color: #fbc02d;
            letter-spacing: 2px;
            text-align: center;
        }

        .review-stars span {
            opacity: 0;
            transform: scale(0.5);
            display: inline-block;
            transition: all .3s ease;
        }

        .review-stars span.show {
            opacity: 1;
            transform: scale(1);
        }

        .review-stars-anim span {
            opacity: 0;
            transform: scale(0.5);
        }

        .review.active .review-stars-anim span {
            animation: starPop .4s forwards;
        }

        .review.active .review-stars-anim span:nth-child(1) {
            animation-delay: .05s
        }

        .review.active .review-stars-anim span:nth-child(2) {
            animation-delay: .15s
        }

        .review.active .review-stars-anim span:nth-child(3) {
            animation-delay: .25s
        }

        .review.active .review-stars-anim span:nth-child(4) {
            animation-delay: .35s
        }

        .review.active .review-stars-anim span:nth-child(5) {
            animation-delay: .45s
        }

        @keyframes starPop {
            from {
                opacity: 0;
                transform: scale(.5)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        h1 {
            color: #1b5e20;
        }

        h2 {
            color: #2e7d32;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background: #2e7d32;
            color: #fff;
        }

        .cta {
            background: #e8f5e9;
            padding: 20px;
            margin-top: 30px;
            border-radius: 6px;
            text-align: center;
        }

        .cta a {
            background: #2e7d32;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .store-banner {
            text-align: center;
        }

        .store-banner .store-buttons {
            display: flex;
            flex-direction: column; /* show buttons vertically */
            align-items: center;
            gap: 12px;
            margin-top: 10px;
        }

        .store-banner img {
            height: 60px;
            width: auto;
            cursor: pointer;
            display: block;
        }

        /* nearby market buttons */
        .market-links {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            /* vertical buttons */
            gap: 10px;
        }

        .market-btn {
            background: #2e7d32;
            color: #ffffff;
            padding: 12px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: block;
            /* full width button */
            text-align: center;
        }

        .market-btn:hover {
            background: #1b5e20;
        }

        /* Nearby areas UI */
        .nearby-areas{
            list-style:none;
            padding:0;
            margin-top:10px;
            display:flex;
            flex-direction:column; /* show items vertically */
            gap:8px;
        }

        .nearby-areas li{
            /* background:#e8f5e9; */
            color:#333;
            /* padding:8px 14px; */
            /* border-radius:20px; */
            /* font-size:14px; */
            /* font-weight:600; */
        }

        /* ---------- Responsive Layout ---------- */

        @media (max-width: 1024px) {
            .container {
                gap: 20px;
            }
        }

        @media (max-width: 900px) {

            .container {
                flex-direction: column;
                padding: 20px 16px !important;   /* force equal left/right padding on mobile */
            }

            .content {
                flex: 100%;
                max-width: 100%;
            }

            .review-sidebar {
                width: 100%;
                margin-top: 20px;
                text-align: center;
                padding: 14px; /* match container side padding for equal left/right spacing */
            }

            /* mobile review text layout */
            .review {
                font-size: 14px;
                line-height: 1.6;
            }

            .review strong {
                display: none;
                /* hide names on mobile to keep UI clean */
            }

        }

        @media (max-width: 600px) {

            body {
                font-size: 14px;
            }

            h1 {
                font-size: 22px;
            }

            h2 {
                font-size: 18px;
            }

            table th,
            table td {
                padding: 8px;
                font-size: 13px;
            }

            .store-banner {
                padding: 18px;
            }

            .store-banner img {
                height: 55px;
                display: block;
                margin: 10px auto;
            }

            .review-sidebar {
                padding: 14px; /* keep same side spacing as container */
            }

            .store-divider {
                width: 15%;
                margin: 12px auto;
            }

        }

        /* make table scrollable on very small screens */
        @media (max-width: 480px) {

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

        }

        /* basic anti-copy protection */
        #marketTable,
        table {
            user-select: none;
            -webkit-user-select: none;
        }

        body.nocopy {
            user-select: none;
        }

        /* App install banner improvements */
        #appBanner {
            padding: 14px 18px !important;
        }

        #appBanner img {
            width: 48px !important;
            height: 48px !important;
        }

        #appBanner .banner-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 900px;
            margin: auto;
            gap: 12px;
            padding-right: 30px;
            box-sizing: border-box;
        }

        /* left side layout */
        #appBanner .banner-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        /* app icon */
        #appBanner .banner-left img {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            flex-shrink: 0;
        }

        /* text container */
        #appBanner .banner-text {
            line-height: 1.2;
        }

        #appBanner .banner-text .title {
            font-weight: bold;
            font-size: 15px;
        }

        #appBanner .banner-text .subtitle {
            font-size: 12px;
            color: #666;
        }

        /* animated open button */
        .open-app-btn {
            background: #2e7d32;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 15px; /* increase text size */
            /* line-height: 1.2; */
            cursor: pointer;
            animation: openPulse 1.6s infinite;
            flex-shrink: 0;
            min-width: 100px;
            min-height: 44px;
        }

        /* zoom animation */
        @keyframes openPulse {
            0% {
                transform: scale(1)
            }

            50% {
                transform: scale(1.08)
            }

            100% {
                transform: scale(1)
            }
        }

        /* divider inside store banner */
        .store-divider {
            border: none;
            border-top: 1px solid #e0e0e0;
            margin: 14px auto;
            width: 30%;
        }
    </style>

</head>


<body>

    <!-- Smart App Install Banner -->
    <div id="appBanner" onclick="goToStore()" style="cursor:pointer;display:none;position:fixed;top:0;left:0;width:100%;background:#ffffff;border-bottom:1px solid #ddd;z-index:9999;box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <div class="banner-inner">
            <div class="banner-left">
                <img src="https://play-lh.googleusercontent.com/hW11sGrIs7XyGaUr9qXFxU_JZjvpWlmIppfUdYdJhsaSA_FZP4fP8ATRZmYu73wncEs=w240-h480-rw" alt="APMC Mandi Bhav App Icon" width="48" height="48">
                <div class="banner-text">
                    <div class="title">Gujarat APMC Mandi Bhav</div>
                    <div class="subtitle">Check daily mandi rates</div>
                </div>
            </div>
            <div>
                <button class="open-app-btn"><strong>Open App</strong></button>
            </div>
        </div>
    </div>

    <main class="container">

        <div class="content">


            <h1>Unjha APMC Mandi Bhav Today</h1>

            <p>
                Unjha APMC is one of India's largest spice markets located in Gujarat.
                Farmers and traders visit the market daily to check mandi bhav for crops like Jeera,
                Isabgol, Fennel and other commodities.
            </p>

            <p>
                Below are sample mandi rates for demonstration. Actual prices change daily
                based on market arrivals and demand.
            </p>

            <h2 id="marketHeading">Unjha Market Rates (<span id="displayDate">Loading...</span>)</h2>

            <table>

                <tr>
                    <th>Crop</th>
                    <th>Minimum Price (₹)</th>
                    <th>Maximum Price (₹)</th>
                </tr>

                <tbody id="marketTable">
                    <tr>
                        <td colspan="3" style="text-align:center;">Loading market data...</td>
                    </tr>
                </tbody>

            </table>


            <h2>Explore Other Gujarat APMC Markets</h2>

            <div class="market-links">
                <a class="market-btn" href="https://beta.envisiontechnolabs.com/apmc/gondal-mandi-bhav.php">
                    Gondal Market Yard
                </a>
                <a class="market-btn" href="https://beta.envisiontechnolabs.com/apmc/rajkot-mandi-bhav.php">
                    Rajkot Market Yard
                </a>
                <a class="market-btn" href="https://beta.envisiontechnolabs.com/apmc/amreli-mandi-bhav.php">
                    Amreli Market Yard
                </a>
                <a class="market-btn" href="https://beta.envisiontechnolabs.com/apmc/ahmedabad-mandi-bhav.php">
                    Ahmedabad Market Yard
                </a>
            </div>


            <h2>Major Crops in Unjha APMC</h2>

            <p>
                Unjha market is known for spice and seed trading including Jeera,
                Isabgol, Fennel, Coriander, Mustard and other agricultural commodities.
            </p>

            <h2>Unjha APMC – Mehsana District (Nearby Areas)</h2>

            <ul class="nearby-areas">
                <li>• Visnagar</li>
                <li>• Siddhpur</li>
                <li>• Vadnagar</li>
                <li>• Patan</li>
                <li>• Kheralu</li>
            </ul>




            <div id="faqSection">

            <h2>Frequently Asked Questions</h2>

            <h3>Why is Unjha Market Yard famous?</h3>
            <p>
                Unjha is famous as the largest cumin (jeera) market in India.
            </p>

            <h3>Which crops are traded in Unjha APMC?</h3>
            <p>
                Cumin, coriander, fennel, fenugreek, and other spices.
            </p>

            <h3>Do Unjha market prices change daily?</h3>
            <p>
                Yes, prices change daily based on arrivals and export demand.
            </p>

            <h3>Are Unjha prices important for exporters?</h3>
            <p>
                Yes, Unjha prices are a national reference for spice exports.
            </p>

            </div>


        </div>

        <div class="review-sidebar">

            <div class="store-banner">

                <h2>Check Daily Gujarat APMC Mandi Bhav</h2>

                <p>
                    Get daily mandi bhav updates from Gujarat APMC markets including
                    Unjha, Rajkot, Gondal, Amreli and Ahmedabad directly on your mobile.
                </p>

                <div class="store-buttons">
                    <a href="https://play.google.com/store/apps/details?id=com.envisiontechnolabs.GujaratAPMC" target="_blank">
                        <img src="https://beta.envisiontechnolabs.com/apmc/image/play_store.svg" alt="Google Play Store" width="180" height="60">
                    </a>

                    <a href="https://apps.apple.com/us/app/apmc-gujarat-daily-mandi-rate/id6746297098" target="_blank">
                        <img src="https://beta.envisiontechnolabs.com/apmc/image/app_store.svg" alt="Apple App Store" width="180" height="60">
                    </a>
                </div>

                <hr class="store-divider">

                <div style="margin-top:10px;font-size:14px;color:#444;text-align:center;">
                    <div>
                        <span style="color:#fbc02d;font-size:18px;">★★★★★</span>
                        <strong>4.9</strong> Ratings
                    </div>
                    <div style="margin-top:4px;">
                        <strong>10K+</strong> Farmers using the app
                    </div>
                </div>

            </div>

             <hr class="store-divider">

            <h3>Farmer Reviews</h3>
            <div id="reviewsContainer" class="test"></div>
            <div class="review-dots" id="reviewDots">
                <span class="active"></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

    </main>


    <!-- FAQ Schema -->

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [{
                    "@type": "Question",
                    "name": "What is today's Unjha mandi bhav?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Mandi bhav in Unjha APMC changes daily depending on crop arrivals and market demand."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Which crops are traded in Unjha APMC?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Jeera, Isabgol, Fennel, Coriander and Mustard are commonly traded crops in Unjha market."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How to check Gujarat mandi bhav daily?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "You can check daily Gujarat APMC mandi bhav using the Gujarat APMC Mandi Bhav mobile app."
                    }
                }
            ]
        }
    </script>

    <script>
        /* Smart App Banner + Deep Linking */

        const isAndroid = /Android/i.test(navigator.userAgent);
        const isiOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);

        const appScheme = "gujaratapmc://home";
        const androidStore = "https://play.google.com/store/apps/details?id=com.envisiontechnolabs.GujaratAPMC";
        // const iosStore = "https://apps.apple.com/app/id6746297098";
        const iosStore = "https://apps.apple.com/app/apple-store/id6746297098";


        /* show banner only on mobile */
        if (isAndroid || isiOS) {
            document.getElementById("appBanner").style.display = "block";
            document.body.style.paddingTop = "70px";
        }

        /* deep link open app */
        function openApp() {

            /* iOS: attempt deep link silently then fallback to App Store */
            if (isiOS) {

                const start = Date.now();
                window.location.href = appScheme;

                setTimeout(function() {
                    if (Date.now() - start < 1500) {
                        window.location.href = iosStore;
                    }
                }, 1200);

                return;
            }

            /* Android: try to open app first using deep link */
            if (isAndroid) {

                window.location.href = appScheme;

                setTimeout(function() {
                    window.location.href = androidStore;
                }, 1200);

            }
        }

        function goToStore() {

            /* Direct redirect to app store without loading the web page */
            if (isAndroid) {
                window.location.href = androidStore;
                return;
            }

            if (isiOS) {
                window.location.href = iosStore;
                return;
            }
        }

        let deferredPrompt = null;

        /* capture PWA install event */
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
        });

        /* install button */
        function installApp() {

            /* If browser supports PWA install */
            if (deferredPrompt) {

                deferredPrompt.prompt();

                deferredPrompt.userChoice.then((choiceResult) => {
                    deferredPrompt = null;
                });

            } else {

                /* fallback to app store */
                if (isAndroid) {
                    window.location = androidStore;
                } else if (isiOS) {
                    window.location = iosStore;
                }

            }

        }

        /* optional auto redirect if app installed */

        /* Market data already fetched server-side (hidden from browser network) */
        const encodedData = "<?php echo base64_encode(json_encode($marketData)); ?>";
        const data = JSON.parse(atob(encodedData));

        const table = document.getElementById('marketTable');
        table.innerHTML = '';

        if (data.data && data.data.length > 0) {

            const apiDate = data.date || '';
            document.getElementById('displayDate').innerText = apiDate;

            const today = new Date();
            const todayFormatted = today.toISOString().split('T')[0];

            const heading = document.getElementById('marketHeading');

            if (apiDate === todayFormatted) {
                heading.innerHTML = `Today's Unjha Market Rates (<span id="displayDate">${apiDate}</span>)`;
            } else {
                heading.innerHTML = `Unjha Market Rates (<span id="displayDate">${apiDate}</span>)`;
            }

            data.data.forEach(row => {

                const minPrice = row.min_price ? Number(row.min_price).toLocaleString('en-IN') : '';
                const maxPrice = row.max_price ? Number(row.max_price).toLocaleString('en-IN') : '';

                const tr = document.createElement('tr');

                tr.innerHTML =
                    `<td>${row.name ?? ''}</td>
                     <td>${minPrice}</td>
                     <td>${maxPrice}</td>`;

                table.appendChild(tr);

            });

        } else {
            table.innerHTML =
                `<tr><td colspan="3" style="text-align:center;">No market data available</td></tr>`;
        }

        // Render reviews dynamically
        const reviewData = [
            {
                text: "ખેતરમાંથી પાક વેચવા પહેલા હું રોજ આ એપમાં મંડિ ભાવ જોઈ લઉં છું, ખેડૂત માટે રોજ ઉપયોગી અને વિશ્વસનીય માહિતી મળે છે.",
                user: "- Ramesh Patel"
            },
            {
                text: "ઉંઝા માર્કેટના તાજા મંડિ ભાવ અહીં ઝડપથી અપડેટ થાય છે, તેથી વેપારીઓ અને ખેડૂત બંનેને સાચી માહિતી મળી રહે છે.",
                user: "- Mahesh Chaudhary"
            },
            {
                text: "મોબાઇલમાં ગુજરાતના અલગ અલગ APMC_MARKETના રોજના મંડિ ભાવ સરળ રીતે જોવા માટે આ એપ ખૂબ ઉપયોગી છે.",
                user: "- Kalpesh Parmar"
            },
            {
                text: "એપ વાપરવામાં સરળ છે અને બજારના સાચા ભાવ સમયસર મળી જાય છે, એટલે પાક વેચવાનો નિર્ણય લેવો સરળ બને છે.",
                user: "- Vijay Desai"
            },
            {
                text: "અમારા ગામના ઘણા ખેડૂત આ એપમાં રોજના પાકના બજાર ભાવ ચેક કરે છે, ખેડૂત માટે ખરેખર મદદરૂપ એપ છે.",
                user: "- Arvind Patel"
            }
        ];

        const reviewsContainer = document.getElementById('reviewsContainer');
        reviewData.forEach((r, i) => {
            const div = document.createElement('div');
            div.className = 'review' + (i === 0 ? ' active' : '');
            div.innerHTML = `
                <div class="review-text">
                <span class="review-quote-start">“</span>${r.text}<span class="review-quote-end">”</span>
                </div>
                <div class="review-stars review-stars-anim">
                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </div>
                <div class="review-user">${r.user}</div>
            `;
            reviewsContainer.appendChild(div);
        });

        // 5 star animation on reload
        const starList = document.querySelectorAll('#reviewStars span');
        starList.forEach((star, i) => {
            setTimeout(() => {
                star.classList.add('show');
            }, i * 200);
        });

        function moveReviewsForMobile() {
            const sidebar = document.querySelector('.review-sidebar');
            const banner = document.querySelector('.store-banner');
            const faq = document.getElementById('faqSection');

            if (!sidebar || !banner) return;

            if (window.innerWidth > 900) {
    /* Desktop: keep default layout (no element movement) */
                sidebar.style.background = "#fff";
                sidebar.style.boxShadow = "0 2px 10px rgba(0,0,0,0.08)";
                sidebar.style.padding = "15px";
                sidebar.style.textAlign = "left";
                sidebar.style.maxWidth = "26%";


            } else {
                /* Mobile styling */
                sidebar.style.background = "#fff";
                sidebar.style.boxShadow = "none";
                sidebar.style.padding = "14px";
                sidebar.style.marginTop = "15px";
                sidebar.style.borderTop = "none";
                sidebar.style.textAlign = "center";

                /* Move FAQ below review sidebar on mobile */
                if (faq && sidebar.nextElementSibling !== faq) {
                    sidebar.parentNode.insertBefore(faq, sidebar.nextSibling);
                }
            }
        }

        moveReviewsForMobile();
        window.addEventListener('resize', moveReviewsForMobile);

        const reviews = document.querySelectorAll('.review');
        const dots = document.querySelectorAll('#reviewDots span');
        let reviewIndex = 0;

        function showReview(i) {
            reviews.forEach(r => {
                r.classList.remove('active');

                const stars = r.querySelectorAll('.review-stars-anim span');
                stars.forEach(s => {
                    s.style.animation = 'none';
                    s.offsetHeight;
                    s.style.animation = '';
                });
            });

            dots.forEach(d => d.classList.remove('active'));

            reviews[i].classList.add('active');
            dots[i].classList.add('active');
        }

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                reviewIndex = i;
                showReview(reviewIndex);
            });
        });

        setInterval(() => {
            reviewIndex = (reviewIndex + 1) % reviews.length;
            showReview(reviewIndex);
        }, 4000);

        /* ----- Basic anti copy / anti inspect protection ----- */

        /* disable right click */
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        /* block common inspect / dev shortcuts */
        document.addEventListener('keydown', function(e) {

            /* F12 */
            if (e.key === "F12") {
                e.preventDefault();
            }

            /* Ctrl+Shift+I , Ctrl+Shift+J , Ctrl+U */
            if (e.ctrlKey && e.shiftKey && (e.key === "I" || e.key === "J")) {
                e.preventDefault();
            }

            if (e.ctrlKey && e.key === "u") {
                e.preventDefault();
            }

        });


        /* Register service worker for PWA install */
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/apmc/service-worker.js')
                    .then(function() {
                        console.log('Service Worker Registered');
                    })
                    .catch(function(error) {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }
    </script>

</body>

</html>