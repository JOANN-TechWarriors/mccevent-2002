const express = require('express');
const app = express();
const https = require('https').createServer(app);
const io = require('socket.io')(https, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

let server;

app.use(express.static('public')); // Serve static files from 'public' directory

app.get('/start', (req, res) => {
    if (!server) {
        const PORT = process.env.PORT || 3306;
        server = https.listen(PORT, () => {
            console.log(`Server running on port ${PORT}`);
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

        res.send('Server started');
    } else {
        res.send('Server is already running');
    }
});

app.get('/stop', (req, res) => {
    if (server) {
        server.close(() => {
            console.log('Server stopped');
            server = null;
            res.send('Server stopped');
        });
    } else {
        res.send('Server is not running');
    }
});

// Initial server state
console.log('Server is ready to start. Use the admin interface to start the server.');