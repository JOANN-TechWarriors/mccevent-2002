const express = require('express');
const app = express();
const https = require('https').createServer(app);
const io = require('socket.io')(https, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

io.on('connection', (socket) => {
    console.log('A user connected');

    socket.on('stream', (data) => {
        socket.broadcast.emit('stream', data);
    });

    socket.on('disconnect', () => {
        console.log('User disconnected');
    });
});

const PORT = process.env.PORT || 3306 ;
https.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});