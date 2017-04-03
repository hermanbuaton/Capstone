var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);


app.get('/', function(req, res){
    res.sendFile(__dirname + '/Chat');
    // res.send('<h1>Hello world</h1>');
});


// http.listen(3000, funcion(){
io.listen(3000, function(){
  console.log('listening on *:3000');
});


io.on('connection', function(socket){
    
    // connect
    // inherit from tutorial
    console.log('A user connected.');
    
    // disconnect
    // inherit from tutorial
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
    
    // ping all user when new user connected
    // inherit from tutorial
    socket.on('room', function(room) {
        socket.join(room);
        console.log("someone joined " + room);
        
        // TODO: remove testing line
        var message = 'Lets welcome a new buddy to ' + room;
        io.sockets.in(room).emit('chat message', message);
        console.log("emited message: " + message);
    });
    
    
    
    /** ========================================
     *  Real Work
     *  ======================================== */
    
    // message
    socket.on('thread', function(data){
        var r = data['room'];
        var d = data['html'];
        io.sockets.in(r).emit('thread', d);
    });
    
    // vote
    socket.on('vote', function(data){
        io.emit('vote', data);
    });
    
    // hand
    socket.on('hand', function(data){
        io.emit('hand', data);
    });
    
    // respond
    socket.on('respond', function(data){
        io.emit('respond', data);
    });
    
    // delegate respond
    socket.on('delegate respond', function(data){
        var r = data['room'];
        var d = { "user": data['user'], "message": data['message'] };
        io.sockets.in(r).emit('delegate respond', data);
    });
    
    // depreciated
    socket.on('live vote', function(data){
        io.emit('live vote', data);
    });
    
    // poll start
    socket.on('poll start', function(data){
        var r = data['room'];
        var d = data['data'];
        io.sockets.in(r).emit('poll start', d);
    });
    
    // poll vote
    socket.on('poll vote', function(data){
        var r = data['room'];
        var d = data['data'];
        console.log("poll vote in " + r);
        io.sockets.in(r).emit('poll vote', d);
    });
    
    // message
    socket.on('system broadcasting', function(msg){
        io.emit('system broadcasting', msg);
    });
    
    
    
    /*
    // send a message to everyone except for certain socket
    socket.broadcast.emit('hi');
    */
    
});