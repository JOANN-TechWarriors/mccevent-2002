<?php
session_start();
// Database connection (replace with your actual database credentials)
$db = new mysqli('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
// Get active streams
$result = $db->query("SELECT * FROM streams WHERE status = 'live'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <title>Live Stream Viewer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        .stream-container {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
        .stream-video {
            width: 1290px;
            height: 580px;
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .stream-video img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        #no-streams {
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Available Live Streams</h1>
    <div id="streams-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='stream-container' id='stream-" . $row['id'] . "'>";
            echo "<div class='stream-video'>";
            echo "<img id='video-" . $row['id'] . "' src='' alt='Live Stream'>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p id='no-streams'>No active streams at the moment.</p>";
    }
    ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script>
        const socket = io('https://mcceventsjudging.com');

        socket.on('streamEnded', (streamId) => {
    const streamElement = document.getElementById(`stream-${streamId}`);
    if (streamElement) {
        streamElement.remove();
    }
    });

    function updateStreams() {
    fetch('get_streams.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            const streams = data.streams || [];
            const container = document.getElementById('streams-container');
            if (streams.length === 0) {
                container.innerHTML = '<p id="no-streams">No active streams at the moment.</p>';
            } else {
                streams.forEach(stream => {
                    let streamDiv = document.getElementById(`stream-${stream.id}`);
                    if (!streamDiv) {
                        streamDiv = document.createElement('div');
                        streamDiv.className = 'stream-container';
                        streamDiv.id = `stream-${stream.id}`;
                        streamDiv.innerHTML = `
                            <div class='stream-video'>
                                <img id='video-${stream.id}' src='' alt='Live Stream'>
                            </div>
                        `;
                        container.appendChild(streamDiv);
                    }
                });
                // Remove streams that are no longer active
                Array.from(container.children).forEach(child => {
                    if (child.id && child.id.startsWith('stream-')) {
                        const streamId = child.id.split('-')[1];
                        if (!streams.some(s => s.id == streamId)) {
                            container.removeChild(child);
                        }
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error fetching streams:', error);
            const container = document.getElementById('streams-container');
            container.innerHTML = `<p>Error loading streams: ${error.message}. Please try again later.</p>`;
        });
        }
        // Log WebSocket connection status
        const socket = io('https://mcceventsjudging.com');
        socket.on('connect', () => {
            console.log('WebSocket connected');
        });
        socket.on('connect_error', (error) => {
            console.error('WebSocket connection error:', error);
        });

        // Initial load of streams
        updateStreams();

        // Update stream list every 30 seconds
        setInterval(updateStreams, 30000);
    </script>
</body>
</html>
<?php
    // ==============================
    // Security Headers
    // ==============================

    // Content Security Policy: Restricts sources for content, scripts, and frames
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-scripts.com; frame-ancestors 'none';");
    header("Content-Security-Policy: script-src 'self'; object-src 'none';");

    // Prevent clickjacking by disallowing framing
    header("X-Frame-Options: DENY");

    // Enforce HTTPS using Strict-Transport-Security
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

    // Prevent MIME type sniffing
    header("X-Content-Type-Options: nosniff");

    // Enable basic XSS protection for older browsers
    header("X-XSS-Protection: 1; mode=block");

    // Control referrer information sent with requests
    header("Referrer-Policy: no-referrer-when-downgrade");

    // Restrict usage of certain browser features and APIs
    header("Permissions-Policy: geolocation=(), camera=(), microphone=(), payment=()");



    // ==============================
    // Redirect HTTP to HTTPS
    // ==============================
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
        header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }

    // ==============================
    // Secure Session Cookie Settings
    // ==============================
    ini_set('session.cookie_secure', '1');          // Enforces HTTPS-only session cookies
    ini_set('session.cookie_httponly', '1');        // Prevents JavaScript access to session cookies
    ini_set('session.cookie_samesite', 'Strict');   // Mitigates CSRF by limiting cross-site cookie usage

    // Start a session securely
    session_start();                                

    // ==============================
    // Anti-XXE: Secure XML Parsing
    // ==============================

    // Disable loading of external entities to prevent XXE attacks
    libxml_disable_entity_loader(true);

    // Suppress libxml errors to allow custom handling
    libxml_use_internal_errors(true);

    /**
     * Securely parses XML strings to prevent XXE vulnerabilities.
     *
     * @param string $xmlString The XML input as a string.
     * @return DOMDocument The parsed DOMDocument object.
     * @throws Exception If parsing fails.
     */
    function parseXMLSecurely($xmlString) {
        $dom = new DOMDocument();

        // Load the XML string securely
        if (!$dom->loadXML($xmlString, LIBXML_NOENT | LIBXML_DTDLOAD | LIBXML_DTDATTR | LIBXML_NOCDATA)) {
            throw new Exception('Error loading XML');
        }

        return $dom;
    }

    // ==============================
    // Example Usage
    // ==============================
    try {
        $xmlString = '<root><element>Sample</element></root>'; // Replace with actual XML input
        $dom = parseXMLSecurely($xmlString);

        // Continue processing $dom...
        echo " ";
    } catch (Exception $e) {
        // Handle XML processing errors securely
        echo 'Error processing XML: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
    ?>
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