 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../img/logo.png"/>
    <title>Event Judging System</title>

    <!-- Le styles -->
    <link href="..//assets/css/bootstrap.css" rel="stylesheet">
    <link href="..//assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="..//assets/css/docs.css" rel="stylesheet">
    <link href="..//assets/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="..//assets/fullcalendar/main.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="..//assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="..//assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="..//assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="..//assets/ico/apple-touch-icon-57-precomposed.png">
                                   <!-- <link rel="shortcut icon" href="ejs_logo.png"> -->
                                
                                   <script type="text/javascript">
    // Disable right-click with an alert
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        alert("Right-click is disabled on this page.");
    });

    // Disable F12 key and Inspect Element keyboard shortcuts with alerts
    document.onkeydown = function(e) {
        // F12
        if (e.key === "F12") {
            alert("F12 (DevTools) is disabled.");
            e.preventDefault(); // Prevent default action
            return false;
        }

        // Ctrl + Shift + I (Inspect)
        if (e.ctrlKey && e.shiftKey && e.key === "I") {
            alert("Inspect Element is disabled.");
            e.preventDefault();
            return false;
        }

        // Ctrl + Shift + J (Console)
        if (e.ctrlKey && e.shiftKey && e.key === "J") {
            alert("Console is disabled.");
            e.preventDefault();
            return false;
        }


         // Ctrl + U or Ctrl + u (View Source)
         if (e.ctrlKey && (e.key === "U" || e.key === "u" || e.keyCode === 85)) {
            alert("Viewing page source is disabled.");
            e.preventDefault();
            return false;
        }
    };
</script>

<script>
    (function() {
  const detectDevToolsAdvanced = () => {
    // Detect if the console is open by triggering a breakpoint
    const start = new Date();
    debugger; // This will trigger when dev tools are open
    const end = new Date();
    if (end - start > 100) {
      document.body.innerHTML = "<h1>Unauthorized Access</h1><p>Developer tools are not allowed on this page.</p>";
      document.body.style.textAlign = "center";
      document.body.style.paddingTop = "20%";
      document.body.style.backgroundColor = "#fff";
      document.body.style.color = "#000";
    }
  };

  setInterval(detectDevToolsAdvanced, 500); // Continuously monitor
})();


const blockedAgents = ["Cyberfox", "Kali"];
if (navigator.userAgent.includes(blockedAgents)) {
  document.body.innerHTML = "<h1>Access Denied</h1><p>Your browser is not supported.</p>";
}


if (window.__proto__.toString() !== "[object Window]") {
  alert("Unauthorized modification detected.");
  window.location.href = "https://www.bible-knowledge.com/wp-content/uploads/battle-verses-against-demonic-attacks.jpg";
}

</script>
<?php
$disallowedUserAgents = [
    "BurpSuite", 
    "Cyberfox", 
    "OWASP ZAP", 
    "PostmanRuntime"
];

if (preg_match("/(" . implode("|", $disallowedUserAgents) . ")/i", $_SERVER['HTTP_USER_AGENT'])) {
    http_response_code(403);
    exit("Unauthorized access");
}
?>

  </head>
  
  