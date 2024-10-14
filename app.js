const express = require('express');
const https = require('https');
const fs = require('fs');
const app = express();

// HTTPS options - make sure to replace with your actual certificate paths
const options = {
  key: fs.readFileSync('/path/to/your/private.key'),
  cert: fs.readFileSync('/path/to/your/certificate.crt')
};

const server = https.createServer(options, app);
const io = require('socket.io')(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

// Keep track of active streams
const activeStreams = new Set();

io.on('connection', (socket) => {
    console.log('A user connected');

    socket.on('stream', (data) => {
        // Add stream ID to active streams if it's not already there
        activeStreams.add(data.streamId);
        // Broadcast the stream data to all other connected clients
        socket.broadcast.emit('stream', data);
    });

    socket.on('stopStream', (streamId) => {
        // Remove stream from active streams when it's stopped
        activeStreams.delete(streamId);
        // Notify all clients that the stream has ended
        io.emit('streamEnded', streamId);
    });

    socket.on('disconnect', () => {
        console.log('User disconnected');
    });
});

// Endpoint to get active streams
app.get('get_streams.php', (req, res) => {
    res.json(Array.from(activeStreams));
});

const PORT = process.env.PORT || 3306;
server.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});