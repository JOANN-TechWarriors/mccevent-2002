<?php
include "db.php";

// Fetch live streams
$sql = "SELECT stream_id, stream_title, stream_status, start_time, end_time, image_url FROM live_streams ORDER BY start_time DESC LIMIT 5";
$result = $conn->query($sql);

// Prepare streams data for JavaScript
$streams = array();
while ($row = $result->fetch_assoc()) {
    // Ensure image_url is a web-accessible path
    if (!empty($row['image_url'])) {
        $row['image_url'] = '../' . ltrim(str_replace('../', '', $row['image_url']), '/');
    }
    $streams[] = $row;
}
$streamsJson = json_encode($streams);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Live Stream</title>
    <link rel="shortcut icon" href="../../images/logo copy.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/18.2.0/umd/react.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/18.2.0/umd/react-dom.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.21.2/babel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom CSS for orientation handling */
        @media screen and (orientation: portrait) {
            .stream-container {
                height: 100vh !important;
            }
            .stream-info {
                padding-bottom: env(safe-area-inset-bottom, 20px);
            }
        }
        @media screen and (orientation: landscape) {
            .stream-container {
                height: 100vh !important;
            }
        }
        /* Prevent content from being hidden under notches and curved corners */
        @supports (padding: max(0px)) {
            .stream-container {
                padding-left: max(env(safe-area-inset-left), 0px);
                padding-right: max(env(safe-area-inset-right), 0px);
                padding-top: max(env(safe-area-inset-top), 0px);
            }
        }
    </style>
</head>
<body class="overflow-hidden">
    <div id="root"></div>

    <script type="text/babel">
        const { useState, useEffect } = React;

        const isStreamActive = (startTime, endTime) => {
            const now = new Date();
            const streamStart = new Date(startTime);
            const streamEnd = endTime ? new Date(endTime) : new Date(streamStart.getTime() + (2 * 60 * 60 * 1000));
            return now >= streamStart && now <= streamEnd;
        };

        const Carousel = ({ streams }) => {
            const [currentIndex, setCurrentIndex] = useState(0);
            const [touchStart, setTouchStart] = useState(null);

            useEffect(() => {
                const interval = setInterval(() => {
                    setCurrentIndex((prevIndex) => (prevIndex + 1) % streams.length);
                }, 5000);
                return () => clearInterval(interval);
            }, [streams.length]);

            const handleTouchStart = (e) => {
                setTouchStart(e.touches[0].clientX);
            };

            const handleTouchEnd = (e) => {
                if (!touchStart) return;
                
                const touchEnd = e.changedTouches[0].clientX;
                const diff = touchStart - touchEnd;

                if (Math.abs(diff) > 50) { // Minimum swipe distance
                    if (diff > 0) {
                        // Swipe left
                        setCurrentIndex((prevIndex) => (prevIndex + 1) % streams.length);
                    } else {
                        // Swipe right
                        setCurrentIndex((prevIndex) => (prevIndex - 1 + streams.length) % streams.length);
                    }
                }

                setTouchStart(null);
            };

            const getImageUrl = (imageUrl) => {
                if (!imageUrl) {
                    return `/api/placeholder/1920/1080?text=No Image`;
                }
                const cleanPath = imageUrl.replace(/^\.\.\//, '');
                return `/${cleanPath}`;
            };

            return (
                <div 
                    className="stream-container relative w-full overflow-hidden bg-black"
                    onTouchStart={handleTouchStart}
                    onTouchEnd={handleTouchEnd}
                >
                    {streams.map((stream, index) => (
                        <div
                            key={stream.stream_id}
                            className={`absolute top-0 left-0 w-full h-full transition-opacity duration-1000 ${
                                index === currentIndex ? 'opacity-100' : 'opacity-0'
                            }`}
                        >
                            <img 
                                src={getImageUrl(stream.image_url)} 
                                alt={stream.stream_title} 
                                className="w-full h-full object-contain md:object-cover" 
                            />
                        </div>
                    ))}
                </div>
            );
        };

        const StreamInfo = ({ stream }) => {
            const active = isStreamActive(stream.start_time, stream.end_time);
            const startTime = new Date(stream.start_time);
            
            return (
                <div className="stream-info absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4 md:p-6">
                    <h2 className="text-xl md:text-2xl lg:text-3xl font-bold truncate">{stream.stream_title}</h2>
                    <p className="text-sm md:text-base">Status: {active ? "Live Now" : "Scheduled"}</p>
                    <p className="text-sm md:text-base">Start Time: {startTime.toLocaleString()}</p>
                    {!active && (
                        <p className="text-yellow-400 text-sm md:text-base">
                            {startTime > new Date() ? 
                                `Stream starts in ${Math.ceil((startTime - new Date()) / (1000 * 60))} minutes` :
                                "Stream has ended"}
                        </p>
                    )}
                </div>
            );
        };

        const App = () => {
            const [currentIndex, setCurrentIndex] = useState(0);
            const [orientation, setOrientation] = useState(window.innerHeight > window.innerWidth ? 'portrait' : 'landscape');
            const streams = JSON.parse('<?php echo addslashes($streamsJson); ?>');

            useEffect(() => {
                const handleResize = () => {
                    setOrientation(window.innerHeight > window.innerWidth ? 'portrait' : 'landscape');
                };

                window.addEventListener('resize', handleResize);
                return () => window.removeEventListener('resize', handleResize);
            }, []);

            useEffect(() => {
                const interval = setInterval(() => {
                    setCurrentIndex((prevIndex) => (prevIndex + 1) % streams.length);
                }, 5000);
                return () => clearInterval(interval);
            }, [streams.length]);

            const handleWatchLive = () => {
                const currentStream = streams[currentIndex];
                window.location.href = `audience.php?stream_id=${currentStream.stream_id}`;
            };

            const currentStream = streams[currentIndex];
            const isActive = isStreamActive(currentStream.start_time, currentStream.end_time);

            return (
                <div className="relative w-full h-screen bg-black">
                    <Carousel streams={streams} />
                    <StreamInfo stream={currentStream} />
                    <button 
                        onClick={handleWatchLive}
                        disabled={!isActive}
                        className={`absolute bottom-24 md:bottom-32 left-1/2 transform -translate-x-1/2 py-2 px-6 rounded-full text-base md:text-lg font-bold shadow-lg transition-colors duration-300 
                            ${isActive ? 
                                'bg-red-600 text-white hover:bg-red-700 cursor-pointer' : 
                                'bg-gray-400 text-gray-200 cursor-not-allowed'}`}
                    >
                        {isActive ? "Watch Live" : "Stream Not Available"}
                    </button>
                </div>
            );
        };

        ReactDOM.render(<App />, document.getElementById('root'));
    </script>
</body>
</html>