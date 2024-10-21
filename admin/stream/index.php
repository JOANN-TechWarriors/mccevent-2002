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
    <link rel="shortcut icon" href="../images/logo copy.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/18.2.0/umd/react.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/18.2.0/umd/react-dom.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.21.2/babel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div id="root"></div>

    <script type="text/babel">
        const { useState, useEffect } = React;

        const isStreamActive = (startTime, endTime) => {
            const now = new Date();
            const streamStart = new Date(startTime);
            const streamEnd = endTime ? new Date(endTime) : new Date(streamStart.getTime() + (2 * 60 * 60 * 1000)); // Default 2 hours duration
            return now >= streamStart && now <= streamEnd;
        };

        const Carousel = ({ streams }) => {
            const [currentIndex, setCurrentIndex] = useState(0);

            useEffect(() => {
                const interval = setInterval(() => {
                    setCurrentIndex((prevIndex) => (prevIndex + 1) % streams.length);
                }, 5000);
                return () => clearInterval(interval);
            }, [streams.length]);

            const getImageUrl = (imageUrl) => {
                if (!imageUrl) {
                    return `/api/placeholder/1920/1080?text=No Image`;
                }
                const cleanPath = imageUrl.replace(/^\.\.\//, '');
                return `/${cleanPath}`;
            };

            return (
                <div className="relative w-full h-screen overflow-hidden">
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
                                className="w-full h-full object-cover" 
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
                <div className="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
                    <h2 className="text-2xl font-bold">{stream.stream_title}</h2>
                    <p>Status: {active ? "Live Now" : "Scheduled"}</p>
                    <p>Start Time: {startTime.toLocaleString()}</p>
                    {!active && (
                        <p className="text-yellow-400">
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
            const streams = JSON.parse('<?php echo addslashes($streamsJson); ?>');

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
                <div className="relative">
                    <Carousel streams={streams} />
                    <StreamInfo stream={currentStream} />
                    <button 
                        onClick={handleWatchLive}
                        disabled={!isActive}
                        className={`absolute bottom-8 left-1/2 transform -translate-x-1/2 py-2 px-6 rounded-full text-lg font-bold shadow-lg transition-colors duration-300 
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