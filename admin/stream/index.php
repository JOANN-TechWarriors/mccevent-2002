<?php

include "db.php";
// Fetch live streams
$sql = "SELECT stream_id, stream_title, stream_status, start_time, image_url FROM live_streams ORDER BY start_time DESC LIMIT 5";
$result = $conn->query($sql);

// Prepare streams data for JavaScript
$streams = array();
while ($row = $result->fetch_assoc()) {
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/18.2.0/umd/react.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/18.2.0/umd/react-dom.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.21.2/babel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div id="root"></div>

    <script type="text/babel">
        const { useState, useEffect } = React;

        const Carousel = ({ streams }) => {
            const [currentIndex, setCurrentIndex] = useState(0);

            useEffect(() => {
                const interval = setInterval(() => {
                    setCurrentIndex((prevIndex) => (prevIndex + 1) % streams.length);
                }, 5000);
                return () => clearInterval(interval);
            }, [streams.length]);

            return (
                <div className="relative w-full h-screen overflow-hidden">
                    {streams.map((stream, index) => (
                        <div
                            key={stream.stream_id}
                            className={`absolute top-0 left-0 w-full h-full transition-opacity duration-1000 ${
                                index === currentIndex ? 'opacity-100' : 'opacity-0'
                            }`}
                        >
                            <img src={stream.image_url || `/api/placeholder/1920/1080?text=${stream.stream_title}`} alt={stream.stream_title} className="w-full h-full object-cover" />
                        </div>
                    ))}
                </div>
            );
        };

        const StreamInfo = ({ stream }) => (
            <div className="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
                <h2 className="text-2xl font-bold">{stream.stream_title}</h2>
                <p>Status: {stream.stream_status}</p>
                <p>Start Time: {stream.start_time}</p>
            </div>
        );

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

            return (
                <div className="relative">
                    <Carousel streams={streams} />
                    <StreamInfo stream={streams[currentIndex]} />
                    <button 
                        onClick={handleWatchLive}
                        className="absolute bottom-8 left-1/2 transform -translate-x-1/2 bg-red-600 text-white py-2 px-6 rounded-full text-lg font-bold shadow-lg hover:bg-red-700 transition-colors duration-300"
                    >
                        Watch Live
                    </button>
                </div>
            );
        };

        ReactDOM.render(<App />, document.getElementById('root'));
    </script>
</body>
</html>